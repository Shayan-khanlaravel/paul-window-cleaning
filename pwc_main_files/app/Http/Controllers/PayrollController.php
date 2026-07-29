<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClientSchedule;
use App\Models\PayrollBonus;
use App\Models\PayrollExtraHour;
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
     * Admin-entered extra hours amount for a staff member within the period,
     * summed across that staff's routes. payroll_extra_hours is scoped by
     * staff_id + route_id + period, so this is a direct lookup - no need to
     * re-derive "which routes belong to this staff" from schedules/assignments.
     */
    private function extraHoursAdminAmountForStaff(User $staff, Carbon $startDate, Carbon $endDate): float
    {
        return (float) PayrollExtraHour::where('staff_id', $staff->id)
            ->where('period_start', $startDate->format('Y-m-d'))
            ->where('period_end', $endDate->format('Y-m-d'))
            ->sum('total_extra_amount');
    }

    public function index(Request $request)
    {
        $cal = $this->getPeriodData($this->resolvePeriodKey($request));
        extract($cal);

        $staffs = User::role('staff')
            ->where('status', 1)
            ->whereHas('profile', function ($query) {
                $query->where('employment_type', 'employee');
            })
            ->get();
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

            $extraHoursAdminAmount = $this->extraHoursAdminAmountForStaff($staff, $start_date, $end_date);

            $totalGross = $commission + $bonus + $extraHoursAdminAmount;

            $staffData[] = (object) [
                'id'                       => $staff->id,
                'name'                     => $staff->name,
                'gross_sales'              => $grossSales,
                'commission'               => $commission,
                'bonus'                    => $bonus,
                'extra_hours_admin_amount' => $extraHoursAdminAmount,
                'total_gross'              => $totalGross,
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

        // Admin-entered extra hours for this staff + period, grouped by route.
        $extraHoursAdminByRoute = PayrollExtraHour::where('staff_id', $staff->id)
            ->where('period_start', $start_date->format('Y-m-d'))
            ->where('period_end', $end_date->format('Y-m-d'))
            ->get()
            ->keyBy('route_id');

        foreach ($routePayrollData as $routeId => $routeData) {
            $bonus = (float) ($bonusByRoute[$routeId] ?? 0);
            $extraHoursAdmin = $extraHoursAdminByRoute[$routeId] ?? null;

            $routePayrollData[$routeId]['bonus']                       = $bonus;
            $routePayrollData[$routeId]['extra_hours_admin_per_hour']  = $extraHoursAdmin->per_hour_amount ?? 0;
            $routePayrollData[$routeId]['extra_hours_admin_hours']     = $extraHoursAdmin->total_extra_hours ?? 0;
            $routePayrollData[$routeId]['extra_hours_admin_amount']    = $extraHoursAdmin->total_extra_amount ?? 0;
            $routePayrollData[$routeId]['total_gross_pay']    = $routePayrollData[$routeId]['commission'] + $bonus
                + $routePayrollData[$routeId]['extra_hours_admin_amount'];
        }

        $routePayrollData = collect($routePayrollData)->sortBy('route_name')->values();

        $grandTotalPay = $routePayrollData->sum('total_gross_pay');

        return view('dashboard.payroll.show', compact(
            'staff', 'routePayrollData', 'selectedPeriod', 'selectedPeriodLabel',
            'periods', 'previousPeriod', 'nextPeriod', 'monthName', 'half', 'year',
            'grandTotalPay', 'start_date', 'end_date'
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

    public function saveExtraHours(Request $request, $id)
    {
        // Extra hours are admin-only. Staff can view amounts but cannot add/edit them.
        abort_unless(Auth::user()->hasRole('admin'), 403);

        $staff = User::findOrFail($id);

        $request->validate([
            'route_id'           => 'required|exists:staff_routes,id',
            'period_start'       => 'required|date',
            'period_end'         => 'required|date',
            'per_hour_amount'    => 'required|numeric|min:0',
            'total_extra_hours'  => 'required|numeric|min:0',
        ]);

        PayrollExtraHour::updateOrCreate(
            [
                'staff_id'     => $staff->id,
                'route_id'     => $request->route_id,
                'period_start' => $request->period_start,
                'period_end'   => $request->period_end,
            ],
            [
                'per_hour_amount'   => $request->per_hour_amount,
                'total_extra_hours' => $request->total_extra_hours,
                'created_by'        => Auth::id(),
            ]
        );

        return back()->with('message', 'Extra hours updated successfully');
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
