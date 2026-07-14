<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClientSchedule;
use App\Models\PayrollBonus;
use App\Models\StaffLogHour;
use App\Models\StaffRoute;
use App\Support\PayrollPeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyPayrollMail;

class PayrollController extends Controller
{
    /**
     * Resolve the selected semi-monthly period and everything the views need.
     *
     * Replaces the old custom 4-week "January - February" calendar with two fixed
     * brackets per month (1st-15th, 16th-last day). The request param is `period`
     * and carries a compact key like "2026-01-1"; `month` is still accepted as a
     * fallback so old bookmarked/emailed links do not 500.
     */
    private function getPeriodData(?string $selectedPeriodKey): array
    {
        ['year' => $year, 'month' => $month, 'half' => $half] = PayrollPeriod::parse($selectedPeriodKey);

        [$startDate, $endDate] = PayrollPeriod::range($year, $month, $half);

        return [
            'year'                => $year,
            'month'               => $month,
            'half'                => $half,
            'monthName'           => PayrollPeriod::monthName($year, $month),
            'start_date'          => $startDate,
            'end_date'            => $endDate,
            'selectedPeriod'      => PayrollPeriod::key($year, $month, $half),
            'selectedPeriodLabel' => PayrollPeriod::label($year, $month, $half),
            'periods'             => PayrollPeriod::forYear($year),
            'previousPeriod'      => PayrollPeriod::previousKey($year, $month, $half),
            'nextPeriod'          => PayrollPeriod::nextKey($year, $month, $half),
        ];
    }

    /**
     * Accept either the new `period` key or the legacy `month` param.
     */
    private function resolvePeriodKey(Request $request): ?string
    {
        return $request->input('period', $request->input('month'));
    }

    /**
     * Sum extra hours (normal & training) for a staff member within the period
     * and value them at that staff's profile rates.
     */
    private function extraHoursSummary(User $staff, Carbon $startDate, Carbon $endDate): array
    {
        $hoursByType = StaffLogHour::where('staff_id', $staff->id)
            ->whereBetween('service_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->selectRaw('rate_type, SUM(duration_hours) as total_hours')
            ->groupBy('rate_type')
            ->pluck('total_hours', 'rate_type');

        $normalHours = (float) ($hoursByType['normal'] ?? 0);
        $trainingHours = (float) ($hoursByType['training'] ?? 0);

        $normalRate = (float) (optional($staff->profile)->normal_rate ?? 0);
        $trainingRate = (float) (optional($staff->profile)->training_rate ?? 0);

        $normalAmount = $normalHours * $normalRate;
        $trainingAmount = $trainingHours * $trainingRate;

        return [
            'normal_hours'    => $normalHours,
            'training_hours'  => $trainingHours,
            'total_hours'     => $normalHours + $trainingHours,
            'normal_amount'   => $normalAmount,
            'training_amount' => $trainingAmount,
            'total_amount'    => $normalAmount + $trainingAmount,
        ];
    }

    /**
     * Extra hours for a staff member within the period, grouped by route_id
     * and valued at that staff's profile rates.
     */
    private function extraHoursByRoute(User $staff, Carbon $startDate, Carbon $endDate)
    {
        $normalRate = (float) (optional($staff->profile)->normal_rate ?? 0);
        $trainingRate = (float) (optional($staff->profile)->training_rate ?? 0);

        $rows = StaffLogHour::where('staff_id', $staff->id)
            ->whereBetween('service_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->selectRaw('route_id, rate_type, SUM(duration_hours) as total_hours')
            ->groupBy('route_id', 'rate_type')
            ->get();

        $byRoute = [];

        foreach ($rows as $row) {
            if (!isset($byRoute[$row->route_id])) {
                $byRoute[$row->route_id] = [
                    'normal_hours'    => 0,
                    'training_hours'  => 0,
                    'total_hours'     => 0,
                    'normal_amount'   => 0,
                    'training_amount' => 0,
                    'total_amount'    => 0,
                ];
            }

            $hours = (float) $row->total_hours;

            if ($row->rate_type === 'training') {
                $byRoute[$row->route_id]['training_hours'] += $hours;
                $byRoute[$row->route_id]['training_amount'] += $hours * $trainingRate;
            } else {
                $byRoute[$row->route_id]['normal_hours'] += $hours;
                $byRoute[$row->route_id]['normal_amount'] += $hours * $normalRate;
            }

            $byRoute[$row->route_id]['total_hours'] += $hours;
            $byRoute[$row->route_id]['total_amount'] = $byRoute[$row->route_id]['normal_amount'] + $byRoute[$row->route_id]['training_amount'];
        }

        return $byRoute;
    }

    public function index(Request $request)
    {
        $cal = $this->getPeriodData($this->resolvePeriodKey($request));
        extract($cal);

        $staffs = User::role('staff')->get();
        if (Auth::user()->hasRole('staff')) {
            $staffs = $staffs->where('id', Auth::id());
        }

        $staffData = [];
        foreach ($staffs as $staff) {
            $schedules = ClientSchedule::where('status', 'completed')
                ->where('staff_id', $staff->id)
                ->whereBetween('service_date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
                ->with(['clientSchedulePayment', 'clientName'])
                ->get();

            $grossSales = 0;
            $commission = 0;

            foreach ($schedules as $schedule) {
                $price = optional($schedule->clientSchedulePayment)->final_price ?? 0;
                $grossSales += $price;
                $commPerc = $schedule->clientName->commission_percentage ?? 0;
                $commission += ($price * $commPerc) / 100;
            }

            $bonus = PayrollBonus::where('staff_id', $staff->id)
                ->where('year', $year)
                ->where('month_name', $monthName)
                ->where('week_number', $half) // week_number column now stores the half (1 or 2)
                ->sum('amount');

            $extraHours = $this->extraHoursSummary($staff, $start_date, $end_date);

            $totalGross = $commission + $bonus + $extraHours['total_amount'];

            $staffData[] = (object) [
                'id'                 => $staff->id,
                'name'               => $staff->name,
                'gross_sales'        => $grossSales,
                'commission'         => $commission,
                'bonus'              => $bonus,
                'extra_hours_amount' => $extraHours['total_amount'],
                'total_gross'        => $totalGross,
            ];
        }

        return view('dashboard.payroll.index', compact(
            'staffData', 'periods', 'selectedPeriod', 'selectedPeriodLabel', 'previousPeriod', 'nextPeriod'
        ));
    }

    public function show(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $cal = $this->getPeriodData($this->resolvePeriodKey($request));
        extract($cal);

        $schedules = ClientSchedule::where('status', 'completed')
            ->where('staff_id', $staff->id)
            ->whereBetween('service_date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
            ->with(['clientSchedulePayment', 'clientName.clientRouteStaff.route'])
            ->get();

        // One semi-monthly bracket = the currently selected period.
        // Aggregate completed schedules per route within that single bracket.
        $routePayrollData = [];

        foreach ($schedules as $schedule) {
            $clientRoute = optional($schedule->clientName)->clientRouteStaff->first();
            $routeId     = $clientRoute?->route_id;
            $routeName   = optional($clientRoute?->route)->name ?? 'Unassigned Route';

            if (!$routeId) {
                continue;
            }

            if (!isset($routePayrollData[$routeId])) {
                $routePayrollData[$routeId] = [
                    'route_id'        => $routeId,
                    'route_name'      => $routeName,
                    'start'           => $start_date,
                    'end'             => $end_date,
                    'gross_sales'     => 0,
                    'commission'      => 0,
                    'bonus'           => 0,
                    'total_gross_pay' => 0,
                ];
            }

            $price    = optional($schedule->clientSchedulePayment)->final_price ?? 0;
            $commPerc = $schedule->clientName->commission_percentage ?? 0;

            $routePayrollData[$routeId]['gross_sales'] += $price;
            $routePayrollData[$routeId]['commission']  += ($price * $commPerc) / 100;
        }

        // Bonuses for this staff + period, grouped by route.
        $bonusByRoute = PayrollBonus::where('staff_id', $staff->id)
            ->where('year', $year)
            ->where('month_name', $monthName)
            ->where('week_number', $half) // half (1 or 2)
            ->whereNotNull('route_id')
            ->selectRaw('route_id, SUM(amount) as total_bonus')
            ->groupBy('route_id')
            ->pluck('total_bonus', 'route_id');

        // Extra hours for this staff + period, grouped by route.
        $extraHoursByRoute = $this->extraHoursByRoute($staff, $start_date, $end_date);

        // Routes that only have extra hours in this period (no completed schedules) still need a row.
        foreach ($extraHoursByRoute as $routeId => $extraHoursData) {
            if (!isset($routePayrollData[$routeId])) {
                $routeName = optional(StaffRoute::find($routeId))->name ?? 'Unassigned Route';

                $routePayrollData[$routeId] = [
                    'route_id'        => $routeId,
                    'route_name'      => $routeName,
                    'start'           => $start_date,
                    'end'             => $end_date,
                    'gross_sales'     => 0,
                    'commission'      => 0,
                    'bonus'           => 0,
                    'total_gross_pay' => 0,
                ];
            }
        }

        foreach ($routePayrollData as $routeId => $routeData) {
            $bonus = (float) ($bonusByRoute[$routeId] ?? 0);
            $extraHoursData = $extraHoursByRoute[$routeId] ?? [
                'normal_hours' => 0, 'training_hours' => 0, 'total_hours' => 0,
                'normal_amount' => 0, 'training_amount' => 0, 'total_amount' => 0,
            ];

            $routePayrollData[$routeId]['bonus']              = $bonus;
            $routePayrollData[$routeId]['normal_hours']       = $extraHoursData['normal_hours'];
            $routePayrollData[$routeId]['training_hours']     = $extraHoursData['training_hours'];
            $routePayrollData[$routeId]['extra_hours_total']  = $extraHoursData['total_hours'];
            $routePayrollData[$routeId]['extra_hours_amount'] = $extraHoursData['total_amount'];
            $routePayrollData[$routeId]['total_gross_pay']    = $routePayrollData[$routeId]['commission'] + $bonus + $extraHoursData['total_amount'];
        }

        $routePayrollData = collect($routePayrollData)->sortBy('route_name')->values();

        $grandTotalPay = $routePayrollData->sum('total_gross_pay');

        return view('dashboard.payroll.show', compact(
            'staff', 'routePayrollData', 'selectedPeriod', 'selectedPeriodLabel',
            'periods', 'previousPeriod', 'nextPeriod', 'monthName', 'half', 'year',
            'grandTotalPay'
        ));
    }

    public function saveBonus(Request $request, $id)
    {
        // Bonuses are admin-only. Staff can view amounts but cannot add/edit them.
        abort_unless(Auth::user()->hasRole('admin'), 403);

        $request->validate([
            'route_id' => 'required|exists:staff_routes,id',
            'half'     => 'required|integer|min:1|max:2', // 1 = 1st-15th, 2 = 16th-EOM
            'amount'   => 'required|numeric',
            'month'    => 'required', // month name, e.g. "January"
            'year'     => 'required|integer',
        ]);

        $bonus = PayrollBonus::firstOrNew([
            'staff_id'    => $id,
            'route_id'    => $request->route_id,
            'year'        => $request->year,
            'month_name'  => $request->month,
            'week_number' => $request->half, // column reused to store the half
        ]);

        $bonus->amount = $request->amount;
        $bonus->save();

        return back()->with('message', 'Bonus updated successfully');
    }

    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'period' => 'required',
        ]);

        $staff = User::findOrFail($id);

        $cal = $this->getPeriodData($request->input('period'));
        extract($cal);

        $schedules = ClientSchedule::where('status', 'completed')
            ->where('staff_id', $staff->id)
            ->whereBetween('service_date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
            ->with(['clientSchedulePayment', 'clientName'])
            ->get();

        $grossSales = 0;
        $commission = 0;

        foreach ($schedules as $schedule) {
            $price = optional($schedule->clientSchedulePayment)->final_price ?? 0;
            $grossSales += $price;
            $commPerc = $schedule->clientName->commission_percentage ?? 0;
            $commission += ($price * $commPerc) / 100;
        }

        $bonus = PayrollBonus::where('staff_id', $staff->id)
            ->where('year', $year)
            ->where('month_name', $monthName)
            ->where('week_number', $half)
            ->sum('amount');

        $totalGrossPay = $commission + $bonus;

        $data = [
            'staff_name'      => $staff->name,
            'period_label'    => $selectedPeriodLabel,
            'date_range'      => $start_date->format('M d') . ' - ' . $end_date->format('M d'),
            'gross_sales'     => $grossSales,
            'commission'      => $commission,
            'bonus'           => $bonus,
            'total_gross_pay' => $totalGrossPay,
        ];

        $accountantEmail = env('ACCOUNTANT_EMAIL', 'cleaning@yopmail.com');
        Mail::to($accountantEmail)->send(new WeeklyPayrollMail($data));

        return back()->with('message', "Payroll details for {$selectedPeriodLabel} emailed to accountant successfully!");
    }
}
