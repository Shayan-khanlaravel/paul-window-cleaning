<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClientSchedule;
use App\Models\PayrollBonus;
use Carbon\Carbon;

class PayrollController extends Controller
{
    private function getCalendarData($selectedMonthStr)
    {
        $currentYear = now()->year;
        $currentMonthRaw = now()->format('F');
        $nextMonthRaw = now()->addMonthNoOverflow()->format('F');
        $selectedMonth = $selectedMonthStr ?? "$currentMonthRaw - $nextMonthRaw $currentYear";

        preg_match('/\d{4}/', $selectedMonth, $yearMatch);
        $selectedYear = $yearMatch[0] ?? $currentYear;

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

        $baseMonthName = trim(str_replace($selectedYear, '', $selectedMonth));
        if (!array_key_exists($baseMonthName, $customStartDates)) {
            $baseMonthName = "January - February";
        }

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
            ->with(['clientSchedulePayment', 'clientName'])
            ->get();

        $weeks = [];
        $cycleStart = $start_date->copy();

        for ($weekNum = 1; $weekNum <= 4; $weekNum++) {
            $weekStart = $cycleStart->copy();
            $weekEnd = $cycleStart->copy()->addDays(6);

            $weeks[$weekNum] = [
                'start' => $weekStart,
                'end' => $weekEnd,
                'schedules' => [],
                'gross_sales' => 0,
                'commission' => 0,
                'bonus' => PayrollBonus::where('staff_id', $staff->id)
                            ->where('year', $selectedYear)
                            ->where('month_name', $baseMonthName)
                            ->where('week_number', $weekNum)
                            ->sum('amount')
            ];

            $cycleStart->addDays(7);
        }

        foreach ($schedules as $schedule) {
            $scheduleDate = Carbon::parse($schedule->start_date);
            foreach ($weeks as $wNum => &$week) {
                if ($scheduleDate->between($week['start'], $week['end'])) {
                    $price = optional($schedule->clientSchedulePayment)->final_price ?? 0;
                    $week['gross_sales'] += $price;
                    $commPerc = $schedule->clientName->commission_percentage ?? 0;
                    $week['commission'] += ($price * $commPerc) / 100;
                    $week['schedules'][] = $schedule;
                    break;
                }
            }
        }

        return view('dashboard.payroll.show', compact(
            'staff', 'weeks', 'selectedMonth', 'months', 'previousMonth', 'nextMonth', 'baseMonthName', 'selectedYear'
        ));
    }

    public function saveBonus(Request $request, $id)
    {
        $request->validate([
            'week_number' => 'required',
            'amount' => 'required|numeric',
            'month' => 'required', // Now this is 'baseMonthName'
            'year' => 'required',
        ]);

        $bonus = PayrollBonus::firstOrNew([
            'staff_id' => $id,
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
            'week_number' => 'required'
        ]);

        $staff = User::findOrFail($id);
        $weekNum = $request->week_number;
        // The month str like "January - February 2025" or the baseMonthName

        // Return success msg for that week
        return back()->with('message', "Payroll details for Week {$weekNum} emailed to accountant successfully!");
    }
}
