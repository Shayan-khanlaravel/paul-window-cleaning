<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * Semi-monthly payroll period helper.
 *
 * Each calendar month is split into two fixed brackets:
 *   Half 1 : 1st  -> 15th
 *   Half 2 : 16th -> last day of month (28 / 29 / 30 / 31 - handled automatically)
 *
 * A period is identified by a compact key: "YYYY-MM-H"  e.g. "2026-01-1", "2026-01-2".
 * This helper is the single source of truth for all payroll date-range math and
 * is safe to reuse from controllers, services, jobs, or commands.
 */
class PayrollPeriod
{
    /**
     * Start/end Carbon dates for a given semi-monthly bracket.
     * Handles variable month-end days automatically via endOfMonth().
     *
     * @return array{0: Carbon, 1: Carbon}  [start, end]
     */
    public static function range(int $year, int $month, int $half): array
    {
        $monthStart = Carbon::create($year, $month, 1)->startOfDay();

        if ($half === 1) {
            $start = $monthStart->copy();                 // 1st
            $end   = $monthStart->copy()->day(15);        // 15th
        } else {
            $start = $monthStart->copy()->day(16);        // 16th
            $end   = $monthStart->copy()->endOfMonth();   // 28/29/30/31
        }

        return [$start->startOfDay(), $end->endOfDay()];
    }

    /**
     * Compact period key, e.g. "2026-01-1".
     */
    public static function key(int $year, int $month, int $half): string
    {
        return sprintf('%04d-%02d-%d', $year, $month, $half);
    }

    /**
     * Human-readable label, e.g. "Jan 1 – 15, 2026" or "Jan 16 – 31, 2026".
     */
    public static function label(int $year, int $month, int $half): string
    {
        [$start, $end] = self::range($year, $month, $half);

        return $start->format('M j') . ' – ' . $end->format('j, Y');
    }

    /**
     * The month name for a period, e.g. "January". Stored on payroll_bonuses.month_name.
     */
    public static function monthName(int $year, int $month): string
    {
        return Carbon::create($year, $month, 1)->format('F');
    }

    /**
     * Resolve a period key (or null) to [year, month, half].
     * Falls back to the period containing "today" when the key is missing/invalid.
     *
     * @return array{year:int, month:int, half:int}
     */
    public static function parse(?string $key): array
    {
        if ($key && preg_match('/^(\d{4})-(\d{1,2})-([12])$/', trim($key), $m)) {
            return [
                'year'  => (int) $m[1],
                'month' => (int) $m[2],
                'half'  => (int) $m[3],
            ];
        }

        $today = Carbon::today();

        return [
            'year'  => $today->year,
            'month' => $today->month,
            'half'  => $today->day <= 15 ? 1 : 2,
        ];
    }

    /**
     * All 24 periods of a year, ready for a dropdown.
     *
     * @return array<int, array{value:string, label:string, month:int, half:int}>
     */
    public static function forYear(int $year): array
    {
        $periods = [];

        for ($month = 1; $month <= 12; $month++) {
            foreach ([1, 2] as $half) {
                $periods[] = [
                    'value' => self::key($year, $month, $half),
                    'label' => self::label($year, $month, $half),
                    'month' => $month,
                    'half'  => $half,
                ];
            }
        }

        return $periods;
    }

    /**
     * Previous bracket key (wraps across month and year boundaries).
     */
    public static function previousKey(int $year, int $month, int $half): string
    {
        if ($half === 2) {
            return self::key($year, $month, 1);
        }

        $prev = Carbon::create($year, $month, 1)->subMonthNoOverflow();

        return self::key($prev->year, $prev->month, 2);
    }

    /**
     * Next bracket key (wraps across month and year boundaries).
     */
    public static function nextKey(int $year, int $month, int $half): string
    {
        if ($half === 1) {
            return self::key($year, $month, 2);
        }

        $next = Carbon::create($year, $month, 1)->addMonthNoOverflow();

        return self::key($next->year, $next->month, 1);
    }
}
