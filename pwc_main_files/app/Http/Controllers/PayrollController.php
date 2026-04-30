<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClientSchedule;
use App\Models\PayrollBonus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyPayrollMail;

class PayrollController extends Controller
{
    private function getCalendarData($selectedMonthStr)
    {
        $currentDate = now();
        $selectedYear = $currentDate->year;

        if ($selectedMonthStr) {
            preg_match('/\d{4}/', $selectedMonthStr, $yearMatch);
            $selectedYear = $yearMatch[0] ?? $selectedYear;
        }

        $firstMondayOfYear = Carbon::parse("first Monday of January $selectedYear");

        $customStartDates = [
            "January - February" => $firstMondayOfYear->copy()->addDays(0),
            "February - March" => $firstMondayOfYear->copy()->addWeeks(4),
            "March" => $firstMondayOfYear->copy()->addWeeks(8),
            "March - April" => $firstMondayOfYear->copy()->addWeeks(12),
            "April - May" => $firstMondayOfYear->copy()->addWeeks(16),
            "May - June" => $firstMondayOfYear->copy()->addWeeks(20),
            "June - July" => $firstMondayOfYear->copy()->addWeeks(24),
            "July - August" => $firstMondayOfYear->copy()->addWeeks(28),
            "August - September" => $firstMondayOfYear->copy()->addWeeks(32),
            "September - October" => $firstMondayOfYear->copy()->addWeeks(36),
            "October - November" => $firstMondayOfYear->copy()->addWeeks(40),
            "November - December" => $firstMondayOfYear->copy()->addWeeks(44),
            "December - January" => $firstMondayOfYear->copy()->addWeeks(48),
        ];

        if ($selectedMonthStr) {
            $baseMonthName = trim(str_replace($selectedYear, '', $selectedMonthStr));
            if (!array_key_exists($baseMonthName, $customStartDates)) {
                $baseMonthName = "January - February";
            }
        } else {
            $baseMonthName = "January - February";
            foreach ($customStartDates as $range => $startDate) {
                if ($currentDate->gte($startDate) && $currentDate->lt($startDate->copy()->addWeeks(4))) {
                    $baseMonthName = $range;
                    break;
                }
            }
        }

        $selectedMonth = "$baseMonthName $selectedYear";
        $monthStartDate = $customStartDates[$baseMonthName];
        $monthEndDate = $monthStartDate->copy()->addWeeks(4)->subDay();

        $monthNames = array_keys($customStartDates);
        $months = [];
        foreach ($monthNames as $monthName) {
            $months[] = $monthName . ' ' . $selectedYear;
        }

        $currentIndex = array_search($baseMonthName, $monthNames);
        if ($currentIndex === false) {
            $currentIndex = 0;
        }
        if ($currentIndex > 0) {
            $previousMonthName = $monthNames[$currentIndex - 1];
            $previousMonth = $previousMonthName . ' ' . $selectedYear;
        } else {
            $previousMonthName = $monthNames[count($monthNames) - 1];
            $previousMonth = $previousMonthName . ' ' . ($selectedYear - 1);
        }
        if ($currentIndex < count($monthNames) - 1) {
            $nextMonthName = $monthNames[$currentIndex + 1];
            $nextMonth = $nextMonthName . ' ' . $selectedYear;
        } else {
            $nextMonthName = $monthNames[0];
            $nextMonth = $nextMonthName . ' ' . ($selectedYear + 1);
        }

        return [
            'baseMonthName' => $baseMonthName,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'start_date' => $monthStartDate,
            'end_date' => $monthEndDate,
            'months' => $months,
            'previousMonth' => $previousMonth,
            'nextMonth' => $nextMonth,
        ];
    }

    public function index(Request $request)
    {
        $cal = $this->getCalendarData($request->input('month'));
        extract($cal);

        $staffs = User::role('staff')->get();
        if (Auth::user()->hasRole('staff')){
            $staffs = $staffs->where('id', Auth::id());
        }

        $staffData = [];
        foreach ($staffs as $staff) {
            $schedules = ClientSchedule::where('status', 'completed')
                ->where('staff_id', $staff->id)
                ->whereBetween('start_date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
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
                ->where('year', $selectedYear)
                ->where('month_name', $baseMonthName)
                ->sum('amount');

            $totalGross = $commission + $bonus;

            $staffData[] = (object) [
                'id' => $staff->id,
                'name' => $staff->name,
                'gross_sales' => $grossSales,
                'commission' => $commission,
                'bonus' => $bonus,
                'total_gross' => $totalGross
            ];
        }

        return view('dashboard.payroll.index', compact(
            'staffData', 'months', 'selectedMonth', 'previousMonth', 'nextMonth'
        ));
    }

    public function show(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $cal = $this->getCalendarData($request->input('month'));
        extract($cal);

        $schedules = ClientSchedule::where('status', 'completed')
            ->where('staff_id', $staff->id)
            ->whereBetween('start_date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
            ->with(['clientSchedulePayment', 'clientName.clientRouteStaff.route'])
            ->get();

        $routePayrollData = [];
        $weekDateRanges = [];
        $cycleStart = $start_date->copy();

        for ($weekNum = 1; $weekNum <= 4; $weekNum++) {
            $weekStart = $cycleStart->copy();
            $weekEnd = $cycleStart->copy()->addDays(6);
            $weekDateRanges[$weekNum] = [
                'start' => $weekStart,
                'end' => $weekEnd,
            ];
            $cycleStart->addDays(7);
        }

        foreach ($schedules as $schedule) {
            $clientRoute = optional($schedule->clientName)->clientRouteStaff->first();
            $routeId = $clientRoute?->route_id;
            $routeName = optional($clientRoute?->route)->name ?? 'Unassigned Route';

            if (!$routeId) {
                continue;
            }

            if (!isset($routePayrollData[$routeId])) {
                $routePayrollData[$routeId] = [
                    'route_id' => $routeId,
                    'route_name' => $routeName,
                    'weeks' => [],
                ];
                foreach ($weekDateRanges as $weekNum => $range) {
                    $routePayrollData[$routeId]['weeks'][$weekNum] = [
                        'start' => $range['start'],
                        'end' => $range['end'],
                        'gross_sales' => 0,
                        'commission' => 0,
                        'bonus' => 0,
                        'total_gross_pay' => 0,
                    ];
                }
            }

            $scheduleDate = Carbon::parse($schedule->start_date);
            $matchedWeek = null;
            foreach ($weekDateRanges as $weekNum => $range) {
                if ($scheduleDate->between($range['start'], $range['end'])) {
                    $matchedWeek = $weekNum;
                    break;
                }
            }

            if (!$matchedWeek) {
                continue;
            }

            $price = optional($schedule->clientSchedulePayment)->final_price ?? 0;
            $commPerc = $schedule->clientName->commission_percentage ?? 0;

            $routePayrollData[$routeId]['weeks'][$matchedWeek]['gross_sales'] += $price;
            $routePayrollData[$routeId]['weeks'][$matchedWeek]['commission'] += ($price * $commPerc) / 100;
        }

        $bonusByRouteAndWeek = PayrollBonus::where('staff_id', $staff->id)
            ->where('year', $selectedYear)
            ->where('month_name', $baseMonthName)
            ->whereNotNull('route_id')
            ->selectRaw('route_id, week_number, SUM(amount) as total_bonus')
            ->groupBy('route_id', 'week_number')
            ->get()
            ->groupBy('route_id');

        foreach ($routePayrollData as $routeId => $routeData) {
            $routeBonuses = $bonusByRouteAndWeek->get($routeId, collect())->keyBy('week_number');

            foreach ($routePayrollData[$routeId]['weeks'] as $weekNum => $weekData) {
                $bonus = (float) optional($routeBonuses->get($weekNum))->total_bonus;
                $routePayrollData[$routeId]['weeks'][$weekNum]['bonus'] = $bonus;
                $routePayrollData[$routeId]['weeks'][$weekNum]['total_gross_pay'] =
                    $routePayrollData[$routeId]['weeks'][$weekNum]['commission'] + $bonus;
            }
        }

        $routePayrollData = collect($routePayrollData)->sortBy('route_name')->values();

        return view('dashboard.payroll.show', compact(
            'staff', 'routePayrollData', 'selectedMonth', 'months', 'previousMonth', 'nextMonth', 'baseMonthName', 'selectedYear'
        ));
    }

    public function saveBonus(Request $request, $id)
    {
        $request->validate([
            'route_id' => 'required|exists:staff_routes,id',
            'week_number' => 'required|integer|min:1|max:4',
            'amount' => 'required|numeric',
            'month' => 'required', // Now this is 'baseMonthName'
            'year' => 'required',
        ]);

        $bonus = PayrollBonus::firstOrNew([
            'staff_id' => $id,
            'route_id' => $request->route_id,
            'year' => $request->year,
            'month_name' => $request->month,
            'week_number' => $request->week_number,
        ]);

        $bonus->amount = $request->amount;
        $bonus->save();

        return back()->with('message', 'Bonus updated successfully');
    }

    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'week_number' => 'required',
            'month' => 'required'
        ]);

        $staff = User::findOrFail($id);
        $weekNum = $request->week_number;

        $cal = $this->getCalendarData($request->month);
        extract($cal);

        $schedules = ClientSchedule::where('status', 'completed')
            ->where('staff_id', $staff->id)
            ->whereBetween('start_date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
            ->with(['clientSchedulePayment', 'clientName'])
            ->get();

        $cycleStart = $start_date->copy();
        $targetWeekStart = null;
        $targetWeekEnd = null;

        for ($w = 1; $w <= 4; $w++) {
            $weekStart = $cycleStart->copy();
            $weekEnd = $cycleStart->copy()->addDays(6);
            if ($w == $weekNum) {
                $targetWeekStart = $weekStart;
                $targetWeekEnd = $weekEnd;
                break;
            }
            $cycleStart->addDays(7);
        }

        $grossSales = 0;
        $commission = 0;

        foreach ($schedules as $schedule) {
            $scheduleDate = Carbon::parse($schedule->start_date);
            if ($scheduleDate->between($targetWeekStart, $targetWeekEnd)) {
                $price = optional($schedule->clientSchedulePayment)->final_price ?? 0;
                $grossSales += $price;
                $commPerc = $schedule->clientName->commission_percentage ?? 0;
                $commission += ($price * $commPerc) / 100;
            }
        }

        $bonus = PayrollBonus::where('staff_id', $staff->id)
            ->where('year', $selectedYear)
            ->where('month_name', $baseMonthName)
            ->where('week_number', $weekNum)
            ->sum('amount');

        $totalGrossPay = $commission + $bonus;

        $data = [
            'staff_name' => $staff->name,
            'week_number' => $weekNum,
            'date_range' => $targetWeekStart->format('M d') . ' - ' . $targetWeekEnd->format('M d'),
            'gross_sales' => $grossSales,
            'commission' => $commission,
            'bonus' => $bonus,
            'total_gross_pay' => $totalGrossPay,
        ];

        $accountantEmail = env('ACCOUNTANT_EMAIL', 'cleaning@yopmail.com');
        Mail::to($accountantEmail)->send(new WeeklyPayrollMail($data));

        return back()->with('message', "Payroll details for Week {$weekNum} emailed to accountant successfully!");
    }
}
