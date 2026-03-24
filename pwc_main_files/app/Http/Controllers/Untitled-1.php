<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{AssignRoute, Notification, StaffRoute, AssignWeek, ClientRoute, ClientSchedule};
use App\Http\Requests\StaffRouteRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StaffRoutesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:staffroutes-list|staffroutes-create|staffroutes-edit|staffroutes-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:staffroutes-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:staffroutes-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:staffroutes-delete', ['only' => ['destroy']]);
        $this->middleware('permission:staffroutes-list', ['only' => ['show']]);
    }

    public function index()
    {
        // 1. First check the user
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // 2. Dates and Weeks logic (as before)
        $currentYear = now()->year;
        $currentMonth = now()->format('F');
        $nextMonth = now()->addMonthNoOverflow()->format('F');
        $baseMonthName = "$currentMonth - $nextMonth";
        $firstMondayOfYear = \Carbon\Carbon::parse("first Monday of January $currentYear");

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

        $monthStartDate = $customStartDates[$baseMonthName] ?? $firstMondayOfYear;

        $weeks = collect();
        $tempDate = $monthStartDate->copy();
        for ($i = 0; $i < 4; $i++) {
            $weeks->push([
                'start_date' => $tempDate->copy(),
                'end_date' => $tempDate->copy()->addDays(6),
            ]);
            $tempDate->addDays(7);
        }

        $today = \Carbon\Carbon::now();
        $currentWeek = $weeks->first(fn($w) => $today->between($w['start_date'], $w['end_date'])) ?: $weeks->first();
        $currentWeekStart = $currentWeek['start_date'];
        $currentWeekEnd = $currentWeek['end_date'];

        // 3. MAIN QUERY WITH STRICT AUTH CHECK
        $query = StaffRoute::with([
            'clientRoute' => function ($q) {
                $q->whereHas('clients', fn($cq) => $cq->where('status', 1));
            },
            'clientRoute.clientSchedule.clientName'
        ]);

        // Role check: If NOT Admin, apply filter
        if (!$user->hasRole('admin')) {
            // Get route IDs from AssignRoute model for this staff member
            // Ensure 'staff_id' column matches the user's ID
            $assignedRouteIds = \App\Models\AssignRoute::where('staff_id', $user->id)
                ->pluck('route_id')
                ->toArray();

            // If staff has no assigned routes, show empty result
            if (empty($assignedRouteIds)) {
                $staffroutes = collect();
            } else {
                $query->whereIn('id', $assignedRouteIds)->where('status', 1);
                $staffroutes = $query->orderBy('created_at', 'DESC')->get();
            }
        } else {
            // If Admin, show all
            $staffroutes = $query->orderBy('created_at', 'DESC')->get();
        }

        // 4. Data Mapping
        $staffroutes = $staffroutes->map(function ($route) use ($currentWeekStart, $currentWeekEnd) {
            $weekSchedules = $route->clientRoute->flatMap(function ($cr) use ($currentWeekStart, $currentWeekEnd) {
                return $cr->clientSchedule->filter(function ($cs) use ($currentWeekStart, $currentWeekEnd) {
                    $start = \Carbon\Carbon::parse($cs->start_date);
                    $end = \Carbon\Carbon::parse($cs->end_date);

                    // Simplified overlap logic
                    return ($start <= $currentWeekEnd && $end >= $currentWeekStart);
                });
            });

            $route->jobs_pending = $weekSchedules->filter(fn($s) => empty($s->status) || $s->status === 'pending')->count();
            $route->jobs_total = $weekSchedules->count();
            $route->jobs_completed = $weekSchedules->filter(fn($s) => $s->status === 'completed')->count();

            return $route;
        });

        return view('staffroutes.index', compact('staffroutes'));
    }

    public function create()
    {
        return view('staffroutes.create');
    }

    public function store(StaffRouteRequest $request)
    {
        $staffroute = new StaffRoute;
        $staffroute->name = $request['name'];
        $staffroute->save();
        Notification::create([
            'user_id' => auth()->user()->id,
            'action_id' => $staffroute->id,
            'title' => 'New Staff Route Created',
            'type' => 'staff_route_created',
            'message' => 'Staff Route "' . $staffroute->name . '" has been created.',
        ]);
        return redirect()->route('staffroutes.index')->with(['title' => 'Done', 'message' => 'Route Created Successfully', 'type' => 'success']);
    }

    // public function show($id, Request $request)
    // {
    //     $staffRoute = StaffRoute::with([
    //         'clientRoute' => function ($query) {
    //             $query->whereHas('clients', function ($clientQuery) {
    //                 $clientQuery->where('status', 1);
    //             });
    //         },
    //         'clientRoute.clientSchedule.clientSchedulePrice.clientPaymentPrice'
    //     ])->findOrFail($id);

    //     //      $selectedMonth = $request->input('month', "January - February $currentYear");
    //     $currentYear = now()->year;
    //     $currentMonth = now()->format('F');
    //     $nextMonth = now()->addMonthNoOverflow()->format('F');

    //     $selectedMonth = $request->input('month', "$currentMonth - $nextMonth $currentYear");

    //     preg_match('/\d{4}/', $selectedMonth, $yearMatch);

    //     $selectedYear = $yearMatch[0] ?? $currentYear;

    //     $allMonths = collect([
    //         '1' => 'January - February',
    //         '2' => 'February - March',
    //         '3' => 'March',
    //         '4' => 'March - April',
    //         '5' => 'April - May',
    //         '6' => 'May - June',
    //         '7' => 'June - July',
    //         '8' => 'July - August',
    //         '9' => 'August - September',
    //         '10' => 'September - October',
    //         '11' => 'October - November',
    //         '12' => 'November - December',
    //         '13' => 'December - January'
    //     ]);

    //     $months = $allMonths->map(fn($month) => "$month $selectedYear");

    //     $firstMondayOfYear = Carbon::parse("first Monday of January $selectedYear");

    //     $customStartDates = [
    //         "January - February" => $firstMondayOfYear->copy()->addDays(0),
    //         "February - March" => $firstMondayOfYear->copy()->addWeeks(4),
    //         "March" => $firstMondayOfYear->copy()->addWeeks(8),
    //         "March - April" => $firstMondayOfYear->copy()->addWeeks(12),
    //         "April - May" => $firstMondayOfYear->copy()->addWeeks(16),
    //         "May - June" => $firstMondayOfYear->copy()->addWeeks(20),
    //         "June - July" => $firstMondayOfYear->copy()->addWeeks(24),
    //         "July - August" => $firstMondayOfYear->copy()->addWeeks(28),
    //         "August - September" => $firstMondayOfYear->copy()->addWeeks(32),
    //         "September - October" => $firstMondayOfYear->copy()->addWeeks(36),
    //         "October - November" => $firstMondayOfYear->copy()->addWeeks(40),
    //         "November - December" => $firstMondayOfYear->copy()->addWeeks(44),
    //         "December - January" => $firstMondayOfYear->copy()->addWeeks(48),
    //     ];
    //     $baseMonthName = trim(str_replace($selectedYear, '', $selectedMonth));

    //     if (!array_key_exists($baseMonthName, $customStartDates)) {
    //         $baseMonthName = "January - February";
    //         $selectedYear = $currentYear;
    //     }

    //     $firstDayOfMonth = $customStartDates[$baseMonthName];

    //     $weeks = collect();

    //     for ($i = 0; $i < 4; $i++) {
    //         $endOfWeek = $firstDayOfMonth->copy()->addDays(6);

    //         $weeks->push([
    //             'week_number' => $i + 1,
    //             'start_date' => $firstDayOfMonth->format('d F Y'),
    //             'end_date' => $endOfWeek->format('d F Y'),
    //             'routes' => [],
    //         ]);

    //         $firstDayOfMonth->addDays(7);
    //     }

    //     $mergedSchedules = $weeks->map(function ($week) use ($staffRoute) {
    //         $weekStartDate = Carbon::parse($week['start_date']);
    //         $weekEndDate = Carbon::parse($week['end_date']);

    //         $filteredRoutes = $staffRoute->clientRoute->flatMap(function ($clientRoute) use ($weekStartDate, $weekEndDate) {
    //             return $clientRoute->clientSchedule->filter(function ($clientSchedule) use ($weekStartDate, $weekEndDate) {
    //                 $scheduleStartDate = Carbon::parse($clientSchedule->start_date);
    //                 $scheduleEndDate = Carbon::parse($clientSchedule->end_date);
    //                 $serviceFrequency = optional($clientSchedule->clientName)->service_frequency;

    //                 // Monthly/BiMonthly: show only if schedule's exact date falls in this week
    //                 if ($serviceFrequency == 'monthly' || $serviceFrequency == 'biMonthly') {
    //                     $scheduleDay = $scheduleStartDate->day;
    //                     $scheduleMonth = $scheduleStartDate->month;
    //                     $scheduleYear = $scheduleStartDate->year;

    //                     for ($d = $weekStartDate->copy(); $d->lte($weekEndDate); $d->addDay()) {
    //                         if ($d->day == $scheduleDay && $d->month == $scheduleMonth && $d->year == $scheduleYear) {
    //                             return true;
    //                         }
    //                     }
    //                     return false;
    //                 }

    //                 return ($scheduleStartDate->gte($weekStartDate) && $scheduleStartDate->lte($weekEndDate)) ||
    //                     ($scheduleEndDate->gte($weekStartDate) && $scheduleEndDate->lte($weekEndDate)) ||
    //                     ($scheduleStartDate->lte($weekStartDate) && $scheduleEndDate->gte($weekEndDate));
    //             })->map(function ($clientSchedule) use ($clientRoute) {
    //                 $displayNote = $clientSchedule->note;

    //                 if ($clientSchedule->note_week_no > 0) {
    //                     $recurringType = optional($clientSchedule->clientName)->recurring_type;

    //                     $currentWeekNumber = $clientSchedule->week;

    //                     $baseSchedule = $clientRoute->clientSchedule
    //                         ->where('client_id', $clientSchedule->client_id)
    //                         ->where('note_week_no', 0) 
    //                         ->where('week', $currentWeekNumber)
    //                         ->first();

    //                     $baseNoteType = optional($baseSchedule)->note_type;
    //                     $shouldMerge = true;

    //                     if ($recurringType === 'non_recurring') {
    //                         $shouldMerge = ($baseNoteType === '4_weeks');
    //                     }

    //                     if ($shouldMerge && $baseSchedule && !empty($baseSchedule->note)) {
    //                         $displayNote = $baseSchedule->note . ', ' . $clientSchedule->note;
    //                     }
    //                 }
    //                 return [
    //                     'client_hours' => optional($clientSchedule->clientHour)
    //                         ->map(fn($scheduleHour) => [
    //                             'start_hour' => optional($scheduleHour)->start_hour,
    //                             'end_hour' => optional($scheduleHour)->end_hour,
    //                         ]),
    //                     'client_start_week' => optional($clientSchedule)->start_date,
    //                     'client_end_week' => optional($clientSchedule)->end_date,
    //                     'client_id' => optional($clientSchedule->clientName)->id,
    //                     'client_price_list' => optional($clientSchedule->clientName)->clientPrice ?? [],
    //                     'schedule_id' => optional($clientSchedule)->id,
    //                     'clientSchedule' => optional($clientSchedule)->status,
    //                     'created_at' => optional($clientSchedule)->created_at,
    //                     'client_name' => optional(optional(optional($clientSchedule)->clientName))->name ?? optional(optional(optional($clientSchedule)->clientName)->user)->name ?? null,
    //                     'client_unavailable_days' => optional(optional($clientSchedule)->clientName)->clientDay ?? [],
    //                     'client_job' => optional(optional($clientSchedule)->clientName)->description ?? null,
    //                     'payment_type' => $clientSchedule->clientName->payment_type ?? null,
    //                     'service_frequency' => optional($clientSchedule->clientName)->service_frequency ?? null,
    //                     'invoice_amount' => $this->calculateInvoiceAmount($clientSchedule),
    //                     'multiPrice' => $this->getMultiPriceWithExtra($clientSchedule),
    //                     'extra_work_price' => $clientSchedule->extra_work_price ?? null,
    //                     'extra_work' => $clientSchedule->extra_work ?? null,
    //                     'address' => $clientSchedule->clientName->address ?? null,
    //                     'house_no' => $clientSchedule->clientName->house_no ?? null,
    //                     'city' => $clientSchedule->clientName->city ?? null,
    //                     'state' => $clientSchedule->clientName->state ?? null,
    //                     'zip_code' => $clientSchedule->clientName->postal ?? null,
    //                     'note' => $displayNote,
    //                     'position' => optional($clientSchedule->clientName)->position,
    //                     'is_completed' => $clientSchedule->status,
    //                     'is_increase' => $clientSchedule->is_increase,
    //                 ];
    //             });
    //         });

    //         $filteredRoutes = $filteredRoutes->sortBy(function ($route) {
    //             return $route['position'] ?? PHP_INT_MAX;
    //         });
    //         $week['routes'] = $filteredRoutes;

    //         return $week;
    //     });

    //     $routeMonths = $months->values();
    //     $currentMonthIndex = $routeMonths->search($selectedMonth);
    //     $previousMonth = $routeMonths->get(($currentMonthIndex - 1 + $routeMonths->count()) % $routeMonths->count());
    //     $nextMonth = $routeMonths->get(($currentMonthIndex + 1) % $routeMonths->count());

    //     if ($currentMonthIndex == 12) {
    //         $nextYear = (int) $selectedYear + 1;
    //         $nextMonth = "January - February $nextYear";
    //     }
    //     if ($currentMonthIndex == 0) {
    //         $previousYear = (int) $selectedYear - 1;
    //         $previousMonth = "December - January $previousYear";
    //     }

    //     $nextYearValue = (int) $selectedYear + 1;
    //     $nextYearFirstMonth = "January - February $nextYearValue";
    //     $weeks->push([
    //         'week_number' => $i + 1,
    //         'week' => 'week' . $i,
    //         'month' => strtolower($firstDayOfMonth->format('F')),
    //         'year' => $firstDayOfMonth->format('Y'),
    //         'start_date' => $firstDayOfMonth->format('d F Y'),
    //         'end_date' => $endOfWeek->format('d F Y'),
    //         'routes' => [],
    //     ]);
    //     return view('staffroutes.show', compact('staffRoute', 'months', 'selectedMonth', 'mergedSchedules', 'previousMonth', 'nextMonth', 'nextYearFirstMonth'));
    // }
    public function show($id, Request $request)
    {
        $staffRoute = StaffRoute::with([
            'clientRoute' => function ($query) {
                $query->whereHas('clients', function ($clientQuery) {
                    $clientQuery->where('status', 1);
                });
            },
            'clientRoute.clientSchedule.clientSchedulePrice.clientPaymentPrice'
        ])->findOrFail($id);

        $currentYear  = now()->year;
        $currentMonth = now()->format('F');
        $nextMonth    = now()->addMonthNoOverflow()->format('F');

        $selectedMonth = $request->input('month', "$currentMonth - $nextMonth $currentYear");

        preg_match('/\d{4}/', $selectedMonth, $yearMatch);
        $selectedYear = $yearMatch[0] ?? $currentYear;

        $allMonths = collect([
            '1'  => 'January - February',
            '2'  => 'February - March',
            '3'  => 'March',
            '4'  => 'March - April',
            '5'  => 'April - May',
            '6'  => 'May - June',
            '7'  => 'June - July',
            '8'  => 'July - August',
            '9'  => 'August - September',
            '10' => 'September - October',
            '11' => 'October - November',
            '12' => 'November - December',
            '13' => 'December - January'
        ]);

        $months = $allMonths->map(fn($month) => "$month $selectedYear");

        $firstMondayOfYear = \Carbon\Carbon::parse("first Monday of January $selectedYear");

        $customStartDates = [
            "January - February"  => $firstMondayOfYear->copy()->addDays(0),
            "February - March"    => $firstMondayOfYear->copy()->addWeeks(4),
            "March"               => $firstMondayOfYear->copy()->addWeeks(8),
            "March - April"       => $firstMondayOfYear->copy()->addWeeks(12),
            "April - May"         => $firstMondayOfYear->copy()->addWeeks(16),
            "May - June"          => $firstMondayOfYear->copy()->addWeeks(20),
            "June - July"         => $firstMondayOfYear->copy()->addWeeks(24),
            "July - August"       => $firstMondayOfYear->copy()->addWeeks(28),
            "August - September"  => $firstMondayOfYear->copy()->addWeeks(32),
            "September - October" => $firstMondayOfYear->copy()->addWeeks(36),
            "October - November"  => $firstMondayOfYear->copy()->addWeeks(40),
            "November - December" => $firstMondayOfYear->copy()->addWeeks(44),
            "December - January"  => $firstMondayOfYear->copy()->addWeeks(48),
        ];

        $baseMonthName = trim(str_replace($selectedYear, '', $selectedMonth));

        if (!array_key_exists($baseMonthName, $customStartDates)) {
            $baseMonthName = "January - February";
            $selectedYear  = $currentYear;
        }

        $firstDayOfMonth = $customStartDates[$baseMonthName];
        $weeks = collect();

        for ($i = 0; $i < 4; $i++) {
            $endOfWeek = $firstDayOfMonth->copy()->addDays(6);
            $weeks->push([
                'week_number' => $i + 1,
                'start_date'  => $firstDayOfMonth->format('d F Y'),
                'end_date'    => $endOfWeek->format('d F Y'),
                'routes'      => [],
            ]);
            $firstDayOfMonth->addDays(7);
        }

        $mergedSchedules = $weeks->map(function ($week) use ($staffRoute) {
            $weekStartDate = \Carbon\Carbon::parse($week['start_date']);
            $weekEndDate   = \Carbon\Carbon::parse($week['end_date']);

            $filteredRoutes = $staffRoute->clientRoute->flatMap(function ($clientRoute) use ($weekStartDate, $weekEndDate) {
                return $clientRoute->clientSchedule->filter(function ($clientSchedule) use ($weekStartDate, $weekEndDate) {
                    $scheduleStartDate = \Carbon\Carbon::parse($clientSchedule->start_date);
                    $scheduleEndDate   = \Carbon\Carbon::parse($clientSchedule->end_date);
                    $serviceFrequency  = optional($clientSchedule->clientName)->service_frequency;

                    if ($serviceFrequency == 'monthly' || $serviceFrequency == 'biMonthly') {
                        for ($d = $weekStartDate->copy(); $d->lte($weekEndDate); $d->addDay()) {
                            if (
                                $d->day   == $scheduleStartDate->day &&
                                $d->month == $scheduleStartDate->month &&
                                $d->year  == $scheduleStartDate->year
                            ) {
                                return true;
                            }
                        }
                        return false;
                    }

                    return ($scheduleStartDate->gte($weekStartDate) && $scheduleStartDate->lte($weekEndDate)) ||
                        ($scheduleEndDate->gte($weekStartDate)   && $scheduleEndDate->lte($weekEndDate))   ||
                        ($scheduleStartDate->lte($weekStartDate) && $scheduleEndDate->gte($weekEndDate));
                })->map(function ($clientSchedule) use ($clientRoute, $weekStartDate, $weekEndDate) {

                    $recurringType = optional($clientSchedule->clientName)->recurring_type;

                    $intervalMap = [
                        '4_weeks'  => 4,
                        '8_weeks'  => 8,
                        '12_weeks' => 12,
                        '24_weeks' => 24,
                        '52_weeks' => 52,
                    ];

                    $checkOccurrence = function ($noteDate, $intervalWeeks) use ($weekStartDate, $weekEndDate) {
                        $currentDate = \Carbon\Carbon::parse($noteDate);
                        while ($currentDate->lte($weekEndDate->copy()->addYear())) {
                            if ($currentDate->gte($weekStartDate) && $currentDate->lte($weekEndDate)) {
                                return true;
                            }
                            if ($currentDate->gt($weekEndDate)) break;
                            $currentDate->addWeeks($intervalWeeks);
                        }
                        return false;
                    };

                    // Note 1 (base) lo
                    $baseSchedule = $clientRoute->clientSchedule
                        ->where('client_id', $clientSchedule->client_id)
                        ->where('note_week_no', 0)
                        ->where('week', $clientSchedule->week)
                        ->first();

                    $note1Is4Weeks = optional($baseSchedule)->note_type === '4_weeks';
                    $shouldMerge   = ($recurringType !== 'non_recurring');

                    $shouldMergeNote1Only = ($recurringType === 'non_recurring') && $note1Is4Weeks;

                    // ============================================================
                    // NOTE DISPLAY LOGIC
                    // ============================================================
                    $displayNote = $clientSchedule->note;

                    if ($shouldMerge) {
                        $mergedNotes = [];
                        $allPotentialNotes = $clientRoute->clientSchedule
                            ->where('client_id', $clientSchedule->client_id)
                            ->sortBy('note_week_no');

                        foreach ($allPotentialNotes as $sch) {
                            $interval  = $intervalMap[$sch->note_type] ?? 4;
                            $checkDate = !empty($sch->note_date) ? $sch->note_date : $sch->start_date;
                            if (empty($checkDate)) continue;

                            if ($checkOccurrence($checkDate, $interval)) {
                                if (!empty($sch->note)) {
                                    $mergedNotes[] = $sch->note;
                                }
                            }
                        }

                        $mergedNotes = array_unique($mergedNotes);
                        if (!empty($mergedNotes)) {
                            $displayNote = implode(', ', $mergedNotes);
                        }
                    } elseif ($shouldMergeNote1Only) {
                        $mergedNotes = [];

                        if ($baseSchedule) {
                            $note1CheckDate = !empty($baseSchedule->note_date)
                                ? $baseSchedule->note_date
                                : $baseSchedule->start_date;

                            $note1Interval = $intervalMap[$baseSchedule->note_type] ?? 4;

                            if (!empty($note1CheckDate) && $checkOccurrence($note1CheckDate, $note1Interval)) {
                                if (!empty($baseSchedule->note)) {
                                    $mergedNotes[] = $baseSchedule->note; // Note 1 add karo
                                }
                            }
                        }

                        // Current note bhi add karo (agar Note 1 nahi hai)
                        if ($clientSchedule->note_week_no !== 0 && !empty($clientSchedule->note)) {
                            $mergedNotes[] = $clientSchedule->note;
                        }

                        $mergedNotes = array_unique($mergedNotes);
                        if (!empty($mergedNotes)) {
                            $displayNote = implode(', ', $mergedNotes);
                        }
                    }

                    if ($clientSchedule->note_week_no === 0) {
                        $finalMultiPrice    = $this->getMultiPriceWithExtra($clientSchedule);
                        $finalInvoiceAmount = $this->calculateInvoiceAmount($clientSchedule);
                    } elseif ($shouldMerge) {
                        $allMergedMultiPrice = [];
                        $addedNoteWeekNos    = [];

                        if (
                            $baseSchedule &&
                            $baseSchedule->clientSchedulePrice &&
                            $baseSchedule->clientSchedulePrice->count() > 0
                        ) {
                            $addedNoteWeekNos[] = 0;
                            foreach ($baseSchedule->clientSchedulePrice as $sp) {
                                $allMergedMultiPrice[] = [
                                    'name'  => optional($sp->clientPaymentPrice)->name,
                                    'value' => optional($sp->clientPaymentPrice)->value,
                                ];
                            }
                        }

                        $otherNotesForPrice = $clientRoute->clientSchedule
                            ->where('client_id', $clientSchedule->client_id)
                            ->where('note_week_no', '>', 0)
                            ->sortBy('note_week_no');

                        foreach ($otherNotesForPrice as $otherNote) {
                            if (empty($otherNote->note_date)) continue;
                            if (in_array($otherNote->note_week_no, $addedNoteWeekNos)) continue;

                            $interval = $intervalMap[$otherNote->note_type] ?? 4;

                            if ($checkOccurrence($otherNote->note_date, $interval)) {
                                $addedNoteWeekNos[] = $otherNote->note_week_no;

                                if ($otherNote->extra_work && $otherNote->extra_work_price) {
                                    $names  = json_decode($otherNote->extra_work, true);
                                    $values = json_decode($otherNote->extra_work_price, true);

                                    if (is_array($names) && is_array($values)) {
                                        foreach ($names as $idx => $name) {
                                            $allMergedMultiPrice[] = [
                                                'name'  => $name,
                                                'value' => (float)($values[$idx] ?? 0),
                                            ];
                                        }
                                    }
                                }
                            }
                        }

                        $finalMultiPrice    = $allMergedMultiPrice;
                        $finalInvoiceAmount = array_sum(array_map(fn($p) => (float)($p['value'] ?? 0), $allMergedMultiPrice));
                    } else {
                        $extraPrices = [];
                        $extraAmount = 0;

                        if ($clientSchedule->extra_work && $clientSchedule->extra_work_price) {
                            $names  = json_decode($clientSchedule->extra_work, true);
                            $values = json_decode($clientSchedule->extra_work_price, true);

                            if (is_array($names) && is_array($values)) {
                                foreach ($names as $idx => $name) {
                                    $extraPrices[] = [
                                        'name'  => $name,
                                        'value' => (float)($values[$idx] ?? 0),
                                    ];
                                    $extraAmount += (float)($values[$idx] ?? 0);
                                }
                            }
                        }

                        $finalMultiPrice    = $extraPrices;
                        $finalInvoiceAmount = $extraAmount;
                    }

                    return [
                        'client_hours' => optional($clientSchedule->clientHour)
                            ->map(fn($scheduleHour) => [
                                'start_hour' => optional($scheduleHour)->start_hour,
                                'end_hour'   => optional($scheduleHour)->end_hour,
                            ]),
                        'client_start_week'       => optional($clientSchedule)->start_date,
                        'client_end_week'         => optional($clientSchedule)->end_date,
                        'client_id'               => optional($clientSchedule->clientName)->id,
                        'client_price_list'       => optional($clientSchedule->clientName)->clientPrice ?? [],
                        'schedule_id'             => optional($clientSchedule)->id,
                        'clientSchedule'          => optional($clientSchedule)->status,
                        'created_at'              => optional($clientSchedule)->created_at,
                        'client_name'             => optional(optional($clientSchedule->clientName))->name
                            ?? optional(optional($clientSchedule->clientName)->user)->name
                            ?? null,
                        'client_unavailable_days' => optional($clientSchedule->clientName)->clientDay ?? [],
                        'client_job'              => optional($clientSchedule->clientName)->description ?? null,
                        'payment_type'            => $clientSchedule->clientName->payment_type ?? null,
                        'service_frequency'       => optional($clientSchedule->clientName)->service_frequency ?? null,
                        'invoice_amount'          => $finalInvoiceAmount,
                        'multiPrice'              => $finalMultiPrice,
                        'extra_work_price'        => $clientSchedule->extra_work_price ?? null,
                        'extra_work'              => $clientSchedule->extra_work ?? null,
                        'address'                 => $clientSchedule->clientName->address ?? null,
                        'house_no'                => $clientSchedule->clientName->house_no ?? null,
                        'city'                    => $clientSchedule->clientName->city ?? null,
                        'state'                   => $clientSchedule->clientName->state ?? null,
                        'zip_code'                => $clientSchedule->clientName->postal ?? null,
                        'note'                    => $displayNote,
                        'position'                => optional($clientSchedule->clientName)->position,
                        'is_completed'            => $clientSchedule->status,
                        'is_increase'             => $clientSchedule->is_increase,
                    ];
                });
            });

            $filteredRoutes = $filteredRoutes->sortBy(fn($route) => $route['position'] ?? PHP_INT_MAX);
            $week['routes'] = $filteredRoutes;
            return $week;
        });

        $routeMonths       = $months->values();
        $currentMonthIndex = $routeMonths->search($selectedMonth);
        $previousMonth     = $routeMonths->get(($currentMonthIndex - 1 + $routeMonths->count()) % $routeMonths->count());
        $nextMonth         = $routeMonths->get(($currentMonthIndex + 1) % $routeMonths->count());

        if ($currentMonthIndex == 12) {
            $nextYear  = (int) $selectedYear + 1;
            $nextMonth = "January - February $nextYear";
        }
        if ($currentMonthIndex == 0) {
            $previousYear  = (int) $selectedYear - 1;
            $previousMonth = "December - January $previousYear";
        }

        $nextYearValue      = (int) $selectedYear + 1;
        $nextYearFirstMonth = "January - February $nextYearValue";

        $weeks->push([
            'week_number' => $i + 1,
            'week'        => 'week' . $i,
            'month'       => strtolower($firstDayOfMonth->format('F')),
            'year'        => $firstDayOfMonth->format('Y'),
            'start_date'  => $firstDayOfMonth->format('d F Y'),
            'end_date'    => $firstDayOfMonth->addDays(6)->format('d F Y'),
            'routes'      => [],
        ]);

        return view('staffroutes.show', compact(
            'staffRoute',
            'months',
            'selectedMonth',
            'mergedSchedules',
            'previousMonth',
            'nextMonth',
            'nextYearFirstMonth'
        ));
    }

    private function calculateInvoiceAmount($clientSchedule)
    {
        $baseTotal = 0;

        if ($clientSchedule->clientSchedulePrice && $clientSchedule->clientSchedulePrice->count() > 0) {
            $baseTotal = $clientSchedule->clientSchedulePrice
                ->map(fn($schedulePrice) => optional($schedulePrice->clientPaymentPrice)->value)
                ->sum();
        }
        return $baseTotal + $this->getExtraWorkPriceSum($clientSchedule->extra_work_price);
    }

    private function getMultiPriceWithExtra($clientSchedule)
    {
        $basePrices = [];

        if ($clientSchedule->clientSchedulePrice && $clientSchedule->clientSchedulePrice->count() > 0) {
            $basePrices = $clientSchedule->clientSchedulePrice
                ->map(fn($schedulePrice) => [
                    'name'  => optional($schedulePrice->clientPaymentPrice)->name,
                    'value' => optional($schedulePrice->clientPaymentPrice)->value
                ])
                ->toArray();
        }

        // Note 2,3,4 ki extra_work prices
        $extraPrices = [];
        if ($clientSchedule->extra_work && $clientSchedule->extra_work_price) {
            $names  = json_decode($clientSchedule->extra_work, true);
            $values = json_decode($clientSchedule->extra_work_price, true);

            if (is_array($names) && is_array($values)) {
                for ($i = 0; $i < count($names); $i++) {
                    $extraPrices[] = [
                        'name'  => $names[$i] ?? null,
                        'value' => $values[$i] ?? null
                    ];
                }
            }
        }

        return array_merge($basePrices, $extraPrices);
    }

    private function getExtraWorkPriceSum($extraWorkPrice)
    {
        if (!$extraWorkPrice) return 0;

        if (is_string($extraWorkPrice) && (str_starts_with($extraWorkPrice, '[') || str_starts_with($extraWorkPrice, '{'))) {
            try {
                $prices = json_decode($extraWorkPrice, true);
                if (is_array($prices)) {
                    return array_sum(array_map('floatval', $prices));
                }
            } catch (\Exception $e) {
            }
        }

        return floatval($extraWorkPrice);
    }

    public function exportSchedule($id, Request $request)
    {
        $staffRoute = StaffRoute::with('clientRoute.clientSchedule.clientSchedulePrice.clientPaymentPrice')->findOrFail($id);

        $currentYear = now()->year;
        $currentMonth = now()->format('F');
        $nextMonth = now()->addMonth()->format('F');

        $selectedMonth = $request->input('selectedMonth', "$currentMonth - $nextMonth $currentYear");
        preg_match('/\d{4}/', $selectedMonth, $yearMatch);
        $selectedYear = $yearMatch[0] ?? $currentYear;

        // Define all months and map them with the selected year
        $allMonths = collect([
            '1' => 'January - February',
            '2' => 'February - March',
            '3' => 'March',
            '4' => 'March - April',
            '5' => 'April - May',
            '6' => 'May - June',
            '7' => 'June - July',
            '8' => 'July - August',
            '9' => 'August - September',
            '10' => 'September - October',
            '11' => 'October - November',
            '12' => 'November - December',
            '13' => 'December - January'
        ]);

        $months = $allMonths->map(fn($month) => "$month $selectedYear");

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

        $exportData = [];

        //        $currentMonthIndex = $months->search($selectedMonth);
        //
        //        $upcomingMonths = $months->slice($currentMonthIndex, 5);
        //        $upcomingMonths->prepend($selectedMonth);
        //
        //        foreach ($upcomingMonths as $month) {
        //            $monthData = $this->getMonthData($month, $staffRoute, $customStartDates);
        //            $exportData[] = $monthData;
        //        }

        $monthData = $this->getMonthData($selectedMonth, $staffRoute, $customStartDates);
        $exportData['data'][] = $monthData['data'];

        return response()->json($exportData);
    }

    public function getMonthData($month, $staffRoute, $customStartDates)
    {
        preg_match('/\d{4}/', $month, $yearMatch);
        $selectedYear = $yearMatch[0] ?? date('Y');
        $baseMonthName = trim(str_replace($selectedYear, '', $month));

        if (!array_key_exists($baseMonthName, $customStartDates)) {
            $baseMonthName = "January - February";
        }

        $firstDayOfMonth = $customStartDates[$baseMonthName]->copy();
        $data = [];

        for ($i = 0; $i < 4; $i++) {
            $weekStartDate = $firstDayOfMonth->copy();
            $weekEndDate = $firstDayOfMonth->copy()->addDays(6);

            $schedules = $staffRoute->clientRoute->flatMap(function ($clientRoute) use ($weekStartDate, $weekEndDate) {
                return $clientRoute->clientSchedule->filter(function ($clientSchedule) use ($weekStartDate, $weekEndDate) {
                    $scheduleStartDate = \Carbon\Carbon::parse($clientSchedule->start_date);
                    $scheduleEndDate = \Carbon\Carbon::parse($clientSchedule->end_date);

                    return ($scheduleStartDate->gte($weekStartDate) && $scheduleStartDate->lte($weekEndDate)) ||
                        ($scheduleEndDate->gte($weekStartDate) && $scheduleEndDate->lte($weekEndDate)) ||
                        ($scheduleStartDate->lte($weekStartDate) && $scheduleEndDate->gte($weekEndDate));
                })->map(function ($clientSchedule) {
                    $amount = $this->calculateInvoiceAmount($clientSchedule);

                    $servicesArray = $this->getMultiPriceWithExtra($clientSchedule);

                    $servicesString = '';
                    if (!empty($servicesArray)) {
                        $servicesString = collect($servicesArray)
                            ->map(function ($service) {
                                return ($service['name'] ?? '') . ($service['value'] ? ' ($' . $service['value'] . ')' : '');
                            })
                            ->filter()
                            ->implode(', ');
                    }

                    return [
                        'Client Name' => $clientSchedule->clientName->name ?? 'N/A',
                        'Pay'         => ucfirst(strtolower($clientSchedule->clientName->payment_type ?? 'N/A')),
                        'Amount'      => $amount,
                        'Service'     => $servicesString,
                        'Address' => ($clientSchedule->clientName->house_no ?? '') . ' ' .
                            ($clientSchedule->clientName->address ?? 'N/A') . ' ' .
                            ($clientSchedule->clientName->city ?? 'N/A') . ' ' .
                            ($clientSchedule->clientName->state ?? 'N/A') . ' ' .
                            ($clientSchedule->clientName->postal ?? 'N/A'),
                        'City'        => $clientSchedule->clientName->city ?? 'N/A',
                        'Note'        => $clientSchedule->note ?? '',
                        'position'    => optional($clientSchedule->clientName)->position,
                    ];
                });
            });
            $sortedRoutes = $schedules->sortBy('position')->values();
            // --- Deposit logic for Export ---
            $weekKey = 'week' . $i;
            $monthKey = strtolower($weekStartDate->format('F'));

            $totalCashReceived = \App\Models\Deposit::where('route_id', $staffRoute->id)
                ->where('week', $weekKey)
                ->where('month', $monthKey)
                ->where('year', $selectedYear)
                ->sum('deposit_amount');

            $data[] = [
                'week_number' => $i + 1,
                'start_date'  => $weekStartDate->format('M j'),
                'end_date'    => $weekEndDate->format('M j, Y'),
                'cash_received_to_date' => $totalCashReceived,
                'routes'      => $sortedRoutes,
            ];

            $firstDayOfMonth->addDays(7);
        }

        return ['data' => $data];
    }


    public function toggleStatus($id)
    {
        try {
            $staffRoute = StaffRoute::findOrFail($id);

            // Toggle status (1 to 0, 0 to 1)
            $staffRoute->status = $staffRoute->status == 1 ? 0 : 1;
            $staffRoute->save();

            return response()->json([
                'success' => true,
                'status' => $staffRoute->status,
                'message' => 'Route status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $staffroute = StaffRoute::findOrFail($id);
        return view('staffroutes.edit', ['staffroute' => $staffroute]);
    }

    public function update(StaffRouteRequest $request, $id)
    {
        $staffroute = StaffRoute::findOrFail($id);
        $staffroute->name = $request->input('name');
        $staffroute->status = $request->input('status');
        $staffroute->save();

        Notification::create([
            'user_id' => auth()->user()->id,
            'action_id' => $staffroute->id,
            'title' => 'Staff Route Updated',
            'type' => 'staff_route_updated',
            'message' => 'Staff Route "' . $staffroute->name . '" has been updated.',
        ]);

        return to_route('staffroutes.index');
    }

    public function destroy($id)
    {
        $staffroute = StaffRoute::findOrFail($id);
        try {
            DB::beginTransaction();
            AssignRoute::where('route_id', $id)->delete();
            $staffroute->delete();
            Notification::create([
                'user_id' => auth()->user()->id,
                'action_id' => $id,
                'title' => 'Staff Route Deleted',
                'type' => 'staff_route_deleted',
                'message' => 'Staff Route "' . $staffroute->name . '" and all its staff assignments have been deleted.',
            ]);
            DB::commit();
            return redirect()->route('staffroutes.index')->with([
                'title' => 'Done',
                'message' => 'Route and all associated staff assignments deleted successfully',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'title' => 'Error',
                'message' => 'Failed to delete route: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }
}
