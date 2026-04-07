<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ClientSchedule;
use App\Models\ClientRoute;
use App\Http\Requests\ClientScheduleRequest;
use App\Models\Notification;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class ClientSchedulesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:clientschedules-list|clientschedules-create|clientschedules-edit|clientschedules-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:clientschedules-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:clientschedules-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:clientschedules-delete', ['only' => ['destroy']]);
        $this->middleware('permission:clientschedules-list', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clientschedules = ClientSchedule::all();
        return view('clientschedules.index', ['clientschedules' => $clientschedules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('clientschedules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientScheduleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientScheduleRequest $request)
    {
        $clientschedule = new ClientSchedule;
        $clientschedule->client_id = $request->input('client_id');
        $clientschedule->month = $request->input('month');
        $clientschedule->week = $request->input('week');
        $clientschedule->start_date = $request->input('start_date');
        $clientschedule->end_date = $request->input('end_date');
        $clientschedule->payment_type = $request->input('payment_type');
        $clientschedule->note = $request->input('note');
        $clientschedule->save();

        return to_route('clientschedules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $clientschedule = ClientSchedule::findOrFail($id);
        return view('clientschedules.show', ['clientschedule' => $clientschedule]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $clientschedule = ClientSchedule::findOrFail($id);
        return view('clientschedules.edit', ['clientschedule' => $clientschedule]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientScheduleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientScheduleRequest $request, $id)
    {
        $clientschedule = ClientSchedule::findOrFail($id);
        $clientschedule->client_id = $request->input('client_id');
        $clientschedule->month = $request->input('month');
        $clientschedule->week = $request->input('week');
        $clientschedule->start_date = $request->input('start_date');
        $clientschedule->end_date = $request->input('end_date');
        $clientschedule->payment_type = $request->input('payment_type');
        $clientschedule->note = $request->input('note');
        $clientschedule->save();

        return to_route('clientschedules.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $clientschedule = ClientSchedule::findOrFail($id);
        $clientschedule->delete();

        return to_route('clientschedules.index');
    }

    public function noteUpdate(ClientScheduleRequest $request)
    {
        $clientschedule = ClientSchedule::findOrFail($request->schedule_id);
        $status = Auth::user()->hasRole('admin') ? '1' : '0';
        $clientschedule->note = $request->note ?? $clientschedule->note;
        $clientschedule->extra_work_price = $request->additional_price ?? $clientschedule->extra_work_price;
        $clientschedule->save();

        // Get client details
        $client = $clientschedule->clientName;
        $clientName = $client->name ?? 'Unknown Client';
        $scheduleDate = \Carbon\Carbon::parse($clientschedule->start_date)->format('M d, Y');

        if ($status == 1) {
            $message = "Note updated for " . $clientName . "\n";
            $message .= "Date: " . $scheduleDate;
            if ($request->additional_price) {
                $message .= "\nExtra: $" . $request->additional_price;
            }

            Notification::create([
                'user_id' => 2,
                'action_id' => $request->schedule_id,
                'title' => $clientName . ' - Note Updated',
                'message' => $message,
                'type' => 'client_schedule_note_updated',
            ]);
        } else {
            $message = "Note update by " . Auth::user()->name . "\n";
            $message .= "Client: " . $clientName . "\n";
            $message .= "Date: " . $scheduleDate;

            Notification::create([
                'user_id' => Auth::id(),
                'action_id' => $request->schedule_id,
                'title' => $clientName . ' - Note Pending',
                'message' => $message,
                'type' => 'client_schedule_note_updated_pending',
            ]);
        }
        return redirect()->back()->with('success', 'Note updated successfully');
    }

    /**
     * Move schedule to next week (Admin only)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function moveToNextWeek(\Illuminate\Http\Request $request)
    {
        // Check if user is admin
        // return $request->all();
        if (!auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can perform this action.'
            ], 403);
        }

        $request->validate([
            'schedule_id' => 'required|exists:client_schedules,id'
        ]);
        $status = Auth::user()->hasRole('admin') ? '1' : '0';
        $clientschedule = ClientSchedule::findOrFail($request->schedule_id);

        // Calculate next week dates (+7 days)
        $currentStartDate = \Carbon\Carbon::parse($clientschedule->start_date);
        $currentEndDate = \Carbon\Carbon::parse($clientschedule->end_date);

        $newStartDate = $currentStartDate->copy()->addDays(7);
        $newEndDate = $currentEndDate->copy()->addDays(7);

        // Check if client already has a schedule in the target week
        $existingSchedule = ClientSchedule::where('client_id', $clientschedule->client_id)
            ->where('id', '!=', $clientschedule->id)
            ->where('start_date', $newStartDate->format('Y-m-d'))
            ->first();

        if ($existingSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot move! This client already has a schedule on ' . $newStartDate->format('M d, Y') . '. Please remove that schedule first or choose a different action.'
            ], 400);
        }

        $newMonth = $newStartDate->format('F');

        // Update the schedule
        $clientschedule->start_date = $newStartDate->format('Y-m-d');
        $clientschedule->end_date = $newEndDate->format('Y-m-d');
        // $clientschedule->week = 'week' . $newWeek;
        $clientschedule->month = $newMonth;
        $clientschedule->is_increase = 1; // Mark as increased
        $clientschedule->save();

        // Get client details
        $client = $clientschedule->clientName;
        $clientName = $client->name ?? 'Unknown Client';
        $oldDate = \Carbon\Carbon::parse($clientschedule->start_date)->format('M d');
        $newDate = $newStartDate->format('M d');

        if ($status == 1) {
            $message = $clientName . " moved to next week\n";
            $message .= $oldDate . " → " . $newDate;

            Notification::create([
                'user_id' => 2,
                'action_id' => $request->schedule_id,
                'title' => $clientName . ' - Next Week',
                'message' => $message,
                'type' => 'client_schedule_moved_next_week',
            ]);
        } else {
            $message = "By " . Auth::user()->name . "\n";
            $message .= $clientName . ": " . $oldDate . " → " . $newDate;

            Notification::create([
                'user_id' => Auth::id(),
                'action_id' => $request->schedule_id,
                'title' => $clientName . ' - Move Pending',
                'message' => $message,
                'type' => 'client_schedule_moved_next_week_pending',
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Schedule moved to next week successfully.',
            'new_start_date' => $newStartDate->format('M d, Y'),
            'new_end_date' => $newEndDate->format('M d, Y')
        ]);
    }

    public function moveToPreviousWeek(\Illuminate\Http\Request $request)
    {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can perform this action.'
            ], 403);
        }

        $request->validate([
            'schedule_id' => 'required|exists:client_schedules,id'
        ]);
        $clientschedule = ClientSchedule::findOrFail($request->schedule_id);
        $status = Auth::user()->hasRole('admin') ? '1' : '0';
        // Calculate previous week dates (-7 days)
        $currentStartDate = \Carbon\Carbon::parse($clientschedule->start_date);
        $currentEndDate = \Carbon\Carbon::parse($clientschedule->end_date);

        $newStartDate = $currentStartDate->copy()->subDays(7);
        $newEndDate = $currentEndDate->copy()->subDays(7);

        // Check if client already has a schedule in the target week
        $existingSchedule = ClientSchedule::where('client_id', $clientschedule->client_id)
            ->where('id', '!=', $clientschedule->id)
            ->where('start_date', $newStartDate->format('Y-m-d'))
            ->first();

        if ($existingSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot move! This client already has a schedule on ' . $newStartDate->format('M d, Y') . '. Please remove that schedule first or choose a different action.'
            ], 400);
        }

        $newMonth = $newStartDate->format('F Y');

        // Update the schedule
        $clientschedule->start_date = $newStartDate->format('Y-m-d');
        $clientschedule->end_date = $newEndDate->format('Y-m-d');
        // $clientschedule->week = 'week' . $newWeek;
        $clientschedule->month = $newMonth;
        $clientschedule->is_increase = 0; // Mark as not increased
        $clientschedule->save();

        // Get client details
        $client = $clientschedule->clientName;
        $clientName = $client->name ?? 'Unknown Client';
        $oldDate = \Carbon\Carbon::parse($clientschedule->start_date)->format('M d');
        $newDate = $newStartDate->format('M d');

        if ($status == 1) {
            $message = $clientName . " moved to previous week\n";
            $message .= $oldDate . " → " . $newDate;

            Notification::create([
                'user_id' => 2,
                'action_id' => $request->schedule_id,
                'title' => $clientName . ' - Previous Week',
                'message' => $message,
                'type' => 'client_schedule_moved_previous_week',
            ]);
        } else {
            $message = "By " . Auth::user()->name . "\n";
            $message .= $clientName . ": " . $oldDate . " → " . $newDate;

            Notification::create([
                'user_id' => Auth::id(),
                'action_id' => $request->schedule_id,
                'title' => $clientName . ' - Move Pending',
                'message' => $message,
                'type' => 'client_schedule_moved_previous_week_pending',
            ]);
        }
        // return $request->all();
        return response()->json([
            'success' => true,
            'message' => 'Schedule moved to previous week successfully.',
            'new_start_date' => $newStartDate->format('M d, Y'),
            'new_end_date' => $newEndDate->format('M d, Y')
        ]);
    }

    /**
     * Bulk move schedules to next or previous week
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkMoveSchedules(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'schedules' => 'required|array|min:1',
            'schedules.*.schedule_id' => 'required|exists:client_schedules,id',
            'direction' => 'required|in:next,previous'
        ]);

        // Both next and previous week moves are allowed
        $direction = $request->direction;
        $schedules = $request->schedules;
        $status = Auth::user()->hasRole('admin') ? '1' : '0';

        $movedCount = 0;
        $skippedCount = 0;
        $errors = [];
        $daysToAdd = $direction === 'next' ? 7 : -7; // Move forward or backward 7 days

        foreach ($schedules as $scheduleData) {
            try {
                $clientSchedule = ClientSchedule::findOrFail($scheduleData['schedule_id']);

                // Calculate new dates
                $currentStartDate = \Carbon\Carbon::parse($clientSchedule->start_date);
                $currentEndDate = \Carbon\Carbon::parse($clientSchedule->end_date);

                $newStartDate = $currentStartDate->copy()->addDays($daysToAdd);
                $newEndDate = $currentEndDate->copy()->addDays($daysToAdd);

                // No need to check for existing schedule - just move it
                // If there's a conflict, it will be handled by the system

                $newMonth = $newStartDate->format('F');

                // Update the schedule
                $clientSchedule->start_date = $newStartDate->format('Y-m-d');
                $clientSchedule->end_date = $newEndDate->format('Y-m-d');
                $clientSchedule->month = $newMonth;

                if ($direction === 'next') {
                    $clientSchedule->is_increase = 1; // Mark as increased
                }

                $clientSchedule->save();

                // Create notification with client details
                $client = $clientSchedule->clientName;
                $clientName = $client->name ?? 'Unknown Client';
                $oldDate = \Carbon\Carbon::parse($clientSchedule->start_date)->format('M d');
                $newDate = $newStartDate->format('M d');

                if ($status == 1) {
                    $message = "Bulk move: " . $oldDate . " → " . $newDate;

                    Notification::create([
                        'user_id' => 2,
                        'action_id' => $clientSchedule->id,
                        'title' => $clientName . ' - Bulk Move',
                        'message' => $message,
                        'type' => 'client_schedule_moved_next_week',
                    ]);
                } else {
                    $message = "By " . Auth::user()->name . "\n" . $oldDate . " → " . $newDate;

                    Notification::create([
                        'user_id' => Auth::id(),
                        'action_id' => $clientSchedule->id,
                        'title' => $clientName . ' - Bulk Pending',
                        'message' => $message,
                        'type' => 'client_schedule_moved_next_week_pending',
                    ]);
                }

                $movedCount++;
            } catch (\Exception $e) {
                $skippedCount++;
                $errors[] = ($scheduleData['client_name'] ?? 'Unknown') . ': ' . $e->getMessage();
            }
        }

        // Build response message
        $message = '';
        if ($movedCount > 0) {
            $message .= "{$movedCount} schedule(s) moved successfully to next week. ";
        }
        if ($skippedCount > 0) {
            $message .= "{$skippedCount} schedule(s) skipped. ";
        }

        return response()->json([
            'success' => $movedCount > 0,
            'message' => trim($message),
            'moved_count' => $movedCount,
            'skipped_count' => $skippedCount,
            'errors' => $errors
        ]);
    }

    public function validateScheduleMove(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:client_schedules,id'
        ]);

        $clientSchedule = ClientSchedule::findOrFail($request->schedule_id);

        // Check service_frequency - monthly and biMonthly cannot be moved
        $serviceFrequency = optional($clientSchedule->clientName)->service_frequency;
        if ($serviceFrequency == 'monthly' || $serviceFrequency == 'biMonthly') {
            return response()->json([
                'can_move_next' => false,
                'next_week_date' => null,
                'error' => 'Monthly & BiMonthly cannot be moved.',
                'service_frequency' => $serviceFrequency
            ]);
        }

        // Calculate next week dates (+7 days)
        $currentStartDate = \Carbon\Carbon::parse($clientSchedule->start_date);
        $nextWeekStartDate = $currentStartDate->copy()->addDays(7);

        // Check if client already has a schedule on the target start date (next week)
        // Only block if there's an exact conflict on the target date
        $hasNextWeekSchedule = ClientSchedule::where('client_id', $clientSchedule->client_id)
            ->where('id', '!=', $clientSchedule->id)
            ->where('start_date', $nextWeekStartDate->format('Y-m-d'))
            ->exists();

        return response()->json([
            'can_move_next' => !$hasNextWeekSchedule,
            'next_week_date' => $nextWeekStartDate->format('M d, Y')
        ]);
    }

    public function moveEntireCalendar(\Illuminate\Http\Request $request)
    {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can perform this action.'
            ], 403);
        }

        $request->validate([
            'week_number' => 'required|integer|min:1|max:4',
            'route_id' => 'required',
            'month' => 'required|string'
        ]);

        $weekNumber = $request->week_number;
        $dbWeek = $weekNumber - 1;
        $routeId = $request->route_id;
        $month = $request->month;
        $status = Auth::user()->hasRole('admin') ? '1' : '0';

        // Get all client routes for this staff route
        $clientRoutes = \App\Models\ClientRoute::where('route_id', $routeId)->pluck('client_id');

        if ($clientRoutes->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No clients found for route ID: ' . $routeId . '. Please check if this route has any assigned clients.'
            ], 404);
        }


        $movedCount = 0;
        $skippedCount = 0;
        $errors = [];

        // 🔥 NEW: Track which clients we've already processed to update their future schedules
        $processedClients = [];

        // Get ALL schedules for ALL weeks FIRST to avoid double-moving
        // DB uses 0-indexed: week0 (UI Week 1), week1 (UI Week 2), week2 (UI Week 3), week3 (UI Week 4)
        $allSchedulesByWeek = [];
        for ($week = 0; $week <= 3; $week++) {
            $weekString = 'week' . $week;
            $allSchedulesByWeek[$week] = ClientSchedule::whereIn('client_id', $clientRoutes)
                ->where('week', $weekString)
                ->get();

            \Log::info('Schedules found for week', [
                'week' => $weekString,
                'count' => $allSchedulesByWeek[$week]->count()
            ]);
        }

        // Now move schedules in reverse order: week3 → week0, week2 → week3, week1 → week2, week0 → week1
        for ($currentWeek = 3; $currentWeek >= 0; $currentWeek--) {
            // Calculate next week: 3→0, 2→3, 1→2, 0→1
            if ($currentWeek == 3) {
                $nextWeek = 0; // week3 → week0
            } else {
                $nextWeek = $currentWeek + 1; // week2→3, week1→2, week0→1
            }

            $currentWeekString = 'week' . $currentWeek;
            $nextWeekString = 'week' . $nextWeek;

            // Use schedules we fetched earlier (before any moves)
            $schedules = $allSchedulesByWeek[$currentWeek];

            \Log::info('Moving schedules', [
                'from_week' => $currentWeekString,
                'to_week' => $nextWeekString,
                'schedules_count' => $schedules->count()
            ]);

            foreach ($schedules as $schedule) {
                try {
                    // Check service_frequency - monthly and biMonthly cannot be moved
                    $serviceFrequency = optional($schedule->clientName)->service_frequency;
                    if ($serviceFrequency == 'monthly' || $serviceFrequency == 'biMonthly') {
                        $skippedCount++;
                        $clientName = optional($schedule->clientName)->name ?? 'Unknown';
                        $errors[] = $clientName . ' has ' . ($serviceFrequency == 'monthly' ? 'Monthly' : 'BiMonthly') . ' service frequency and cannot be moved.';
                        continue;
                    }

                    // Move dates 7 days forward
                    $newStartDate = \Carbon\Carbon::parse($schedule->start_date)->addDays(7);
                    $newEndDate = \Carbon\Carbon::parse($schedule->end_date)->addDays(7);

                    // Move note_date if exists (7 days forward)
                    $newNoteDate = null;
                    if (!empty($schedule->note_date)) {
                        try {
                            $newNoteDate = \Carbon\Carbon::parse($schedule->note_date)->addDays(7)->format('Y-m-d');
                        } catch (\Exception $e) {
                            // Keep original if parsing fails
                            $newNoteDate = $schedule->note_date;
                        }
                    }

                    // Update current schedule
                    $schedule->start_date = $newStartDate->format('Y-m-d');
                    $schedule->end_date = $newEndDate->format('Y-m-d');
                    $schedule->week = $nextWeekString; // week0 → week1, week1 → week2, week2 → week3, week3 → week0
                    if ($newNoteDate !== null) {
                        $schedule->note_date = $newNoteDate;
                    }
                    $schedule->is_increase = 1;
                    $schedule->save();

                    // 🔥 NEW: Update ALL future schedules for this client with the same old week
                    // Only do this once per client per week to avoid redundant updates
                    $clientId = $schedule->client_id;
                    $trackingKey = $clientId . '_' . $currentWeekString;

                    if (!in_array($trackingKey, $processedClients)) {
                        $processedClients[] = $trackingKey;

                        $currentScheduleDate = \Carbon\Carbon::parse($schedule->start_date);

                        // Find all future schedules for this client that have the OLD week number
                        $futureSchedules = ClientSchedule::where('client_id', $clientId)
                            ->where('id', '!=', $schedule->id)
                            ->where('week', $currentWeekString)
                            ->whereDate('start_date', '>', $currentScheduleDate)
                            ->get();

                        // Update each future schedule to the new week
                        foreach ($futureSchedules as $futureSchedule) {
                            $futureStartDate = \Carbon\Carbon::parse($futureSchedule->start_date);
                            $futureEndDate = \Carbon\Carbon::parse($futureSchedule->end_date);

                            $newFutureStartDate = $futureStartDate->addDays(7);
                            $newFutureEndDate = $futureEndDate->addDays(7);

                            $newFutureNoteDate = null;
                            if (!empty($futureSchedule->note_date)) {
                                try {
                                    $newFutureNoteDate = \Carbon\Carbon::parse($futureSchedule->note_date)->addDays(7)->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $newFutureNoteDate = $futureSchedule->note_date;
                                }
                            }

                            $futureSchedule->start_date = $newFutureStartDate->format('Y-m-d');
                            $futureSchedule->end_date = $newFutureEndDate->format('Y-m-d');
                            $futureSchedule->month = $newFutureStartDate->format('F');
                            $futureSchedule->week = $nextWeekString;
                            if ($newFutureNoteDate !== null) {
                                $futureSchedule->note_date = $newFutureNoteDate;
                            }
                            $futureSchedule->save();
                        }
                    }

                    // Create notification with client details
                    $client = $schedule->clientName;
                    $clientName = $client->name ?? 'Unknown Client';
                    $oldDate = \Carbon\Carbon::parse($schedule->start_date)->format('M d');
                    $newDate = $newStartDate->format('M d');

                    if ($status == 1) {
                        $message = "Calendar moved: " . $oldDate . " → " . $newDate;

                        Notification::create([
                            'user_id' => 2,
                            'action_id' => $schedule->id,
                            'title' => $clientName . ' - Calendar Moved',
                            'message' => $message,
                            'type' => 'client_schedule_moved_entire_calendar',
                        ]);
                    } else {
                        $message = "By " . Auth::user()->name . "\n" . $oldDate . " → " . $newDate;

                        Notification::create([
                            'user_id' => Auth::id(),
                            'action_id' => $schedule->id,
                            'title' => $clientName . ' - Calendar Pending',
                            'message' => $message,
                            'type' => 'client_schedule_moved_entire_calendar_pending',
                        ]);
                    }

                    $movedCount++;
                } catch (\Exception $e) {
                    $skippedCount++;
                    $clientName = optional($schedule->clientName)->name ?? 'Unknown';
                    $errors[] = $clientName . ': ' . $e->getMessage();
                }
            }
        }

        // Build response message
        $message = '';
        if ($movedCount > 0) {
            $message .= "{$movedCount} schedule(s) moved successfully across all future months. ";
        }
        if ($skippedCount > 0) {
            $message .= "{$skippedCount} schedule(s) skipped. ";
        }

        return response()->json([
            'success' => $movedCount > 0,
            'message' => trim($message),
            'moved_count' => $movedCount,
            'skipped_count' => $skippedCount,
            'errors' => $errors
        ]);
    }

    public function selectivePermanentMove(\Illuminate\Http\Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can perform this action.'
            ], 403);
        }

        $request->validate([
            'schedules' => 'required_without:select_all|array|min:1',
            'schedules.*.schedule_id' => 'required_without:select_all|exists:client_schedules,id',
            'direction' => 'required|in:next,previous',
            'select_all' => 'nullable|in:true,false',
        ]);

        $direction = $request->direction;
        $selectAll = $request->input('select_all') === 'true';
        $status = Auth::user()->hasRole('admin') ? '1' : '0';
        $daysToMove = ($direction === 'next') ? 7 : -7;

        // =====================
        // SELECT ALL LOGIC
        // =====================
//        if ($selectAll) {
//            $allSchedules = ClientSchedule::orderBy('start_date', 'asc')->get();
//
//            $movedCount = 0;
//            $skippedCount = 0;
//            $errors = [];
//
//            foreach ($allSchedules as $schedule) {
//                // Monthly aur biMonthly skip karo
//                $serviceFrequency = optional($schedule->clientName)->service_frequency;
//                if ($serviceFrequency == 'monthly' || $serviceFrequency == 'biMonthly') {
//                    $skippedCount++;
//                    $clientName = optional($schedule->clientName)->name ?? 'Unknown';
//                    $errors[] = $clientName . ' has ' . ($serviceFrequency == 'monthly' ? 'Monthly' : 'BiMonthly') . ' service frequency and cannot be moved.';
//                    continue;
//                }
//
//                $currentWeekNumber = (int) str_replace('week', '', trim($schedule->week));
//
//                if ($direction === 'next') {
//                    $newWeekNumber = ($currentWeekNumber == 3) ? 0 : $currentWeekNumber + 1;
//                } else {
//                    $newWeekNumber = ($currentWeekNumber == 0) ? 3 : $currentWeekNumber - 1;
//                }
//
//                $newStartDate = \Carbon\Carbon::parse($schedule->start_date)->addDays($daysToMove);
//                $newEndDate = \Carbon\Carbon::parse($schedule->end_date)->addDays($daysToMove);
//
//                $schedule->week = 'week' . $newWeekNumber;
//                $schedule->start_date = $newStartDate->format('Y-m-d');
//                $schedule->end_date = $newEndDate->format('Y-m-d');
//                $schedule->month = $newStartDate->format('F');
//                $schedule->week_month = $newStartDate->format('F');
//                $schedule->is_increase = 1;
//
//                if (!empty($schedule->note_date)) {
//                    try {
//                        $schedule->note_date = \Carbon\Carbon::parse($schedule->note_date)->addDays($daysToMove)->format('Y-m-d');
//                    } catch (\Exception $e) {
//                        // note_date as is
//                    }
//                }
//
//                $schedule->save();
//                $movedCount++;
//            }
//
//            return response()->json([
//                'success' => true,
//                'message' => 'All schedules permanently moved ' . ($direction === 'next' ? 'forward' : 'backward') . ' successfully.',
//                'moved_count' => $movedCount,
//                'skipped_count' => $skippedCount,
//                'errors' => $errors
//            ]);
//        }

        // =====================
        // SELECTIVE MOVE LOGIC
        // =====================
        $schedules = $request->schedules;
        $movedCount = 0;
        $skippedCount = 0;
        $errors = [];

        \Log::info('Selective Permanent Move Request:', [
            'total_schedules' => count($schedules),
            'schedule_ids' => array_column($schedules, 'schedule_id'),
            'schedule_data' => $schedules
        ]);

        foreach ($schedules as $scheduleData) {
            try {
                $schedule = ClientSchedule::findOrFail($scheduleData['schedule_id']);

                \Log::info('Processing Schedule:', [
                    'schedule_id' => $schedule->id,
                    'client_id' => $schedule->client_id,
                    'client_name' => optional($schedule->clientName)->name,
                    'current_week' => $schedule->week,
                    'start_date' => $schedule->start_date
                ]);

                // Check service_frequency - monthly and biMonthly cannot be moved
                $serviceFrequency = optional($schedule->clientName)->service_frequency;
                if ($serviceFrequency == 'monthly' || $serviceFrequency == 'biMonthly') {
                    $skippedCount++;
                    $clientName = optional($schedule->clientName)->name ?? 'Unknown';
                    $errors[] = $clientName . ' has ' . ($serviceFrequency == 'monthly' ? 'Monthly' : 'BiMonthly') . ' service frequency and cannot be moved.';
                    continue;
                }

                $currentWeekNumber = (int) str_replace('week', '', trim($schedule->week));

                if ($direction === 'next') {
                    if ($currentWeekNumber == 3) $newWeekNumber = 0;
                    elseif ($currentWeekNumber == 2) $newWeekNumber = 3;
                    elseif ($currentWeekNumber == 1) $newWeekNumber = 2;
                    else $newWeekNumber = 1;
                } else {
                    if ($currentWeekNumber == 0) $newWeekNumber = 3;
                    elseif ($currentWeekNumber == 1) $newWeekNumber = 0;
                    elseif ($currentWeekNumber == 2) $newWeekNumber = 1;
                    else $newWeekNumber = 2;
                }

                $nextWeekString = 'week' . $newWeekNumber;
                $originalStartDate = \Carbon\Carbon::parse($schedule->start_date);
                $newStartDate = \Carbon\Carbon::parse($schedule->start_date)->addDays($daysToMove);
                $newEndDate = \Carbon\Carbon::parse($schedule->end_date)->addDays($daysToMove);

                $newNoteDate = null;
                if (!empty($schedule->note_date)) {
                    try {
                        $newNoteDate = \Carbon\Carbon::parse($schedule->note_date)->addDays($daysToMove)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $newNoteDate = $schedule->note_date;
                    }
                }

                $schedule->start_date = $newStartDate->format('Y-m-d');
                $schedule->end_date = $newEndDate->format('Y-m-d');
                $schedule->week = $nextWeekString;
                $schedule->month = $newStartDate->format('F');
                $schedule->week_month = $newStartDate->format('F');
                if ($newNoteDate !== null) {
                    $schedule->note_date = $newNoteDate;
                }
                $schedule->is_increase = 1;
                $schedule->save();

                // Move ALL schedules for this client (except current one)
                $clientId = $schedule->client_id;

                $futureSchedules = ClientSchedule::where('client_id', $clientId)
                    ->where('id', '!=', $schedule->id)
                    ->orderBy('start_date', 'asc')
                    ->get();

                foreach ($futureSchedules as $futureSchedule) {
                    $futureCurrentWeekNumber = (int) str_replace('week', '', trim($futureSchedule->week));

                    if ($direction === 'next') {
                        if ($futureCurrentWeekNumber == 3) $futureNextWeekNumber = 0;
                        elseif ($futureCurrentWeekNumber == 2) $futureNextWeekNumber = 3;
                        elseif ($futureCurrentWeekNumber == 1) $futureNextWeekNumber = 2;
                        else $futureNextWeekNumber = 1;
                    } else {
                        if ($futureCurrentWeekNumber == 0) $futureNextWeekNumber = 3;
                        elseif ($futureCurrentWeekNumber == 1) $futureNextWeekNumber = 0;
                        elseif ($futureCurrentWeekNumber == 2) $futureNextWeekNumber = 1;
                        else $futureNextWeekNumber = 2;
                    }

                    $futureNewStartDate = \Carbon\Carbon::parse($futureSchedule->start_date)->addDays($daysToMove);
                    $futureNewEndDate = \Carbon\Carbon::parse($futureSchedule->end_date)->addDays($daysToMove);

                    $futureNewNoteDate = null;
                    if (!empty($futureSchedule->note_date)) {
                        try {
                            $futureNewNoteDate = \Carbon\Carbon::parse($futureSchedule->note_date)->addDays($daysToMove)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $futureNewNoteDate = $futureSchedule->note_date;
                        }
                    }

                    $futureSchedule->start_date = $futureNewStartDate->format('Y-m-d');
                    $futureSchedule->end_date = $futureNewEndDate->format('Y-m-d');
                    $futureSchedule->week = 'week' . $futureNextWeekNumber;
                    $futureSchedule->month = $futureNewStartDate->format('F');
                    $futureSchedule->week_month = $futureNewStartDate->format('F');
                    if ($futureNewNoteDate !== null) {
                        $futureSchedule->note_date = $futureNewNoteDate;
                    }
                    $futureSchedule->is_increase = 1;
                    $futureSchedule->save();
                }

                // Notification
                $client = $schedule->clientName;
                $clientName = $client->name ?? 'Unknown Client';
                $oldDate = $originalStartDate->format('M d');
                $newDate = $newStartDate->format('M d');

                if ($status == 1) {
                    $message = "Permanent: " . $oldDate . " → " . $newDate;
                    Notification::create([
                        'user_id' => 2,
                        'action_id' => $schedule->id,
                        'title' => $clientName . ' - Permanent Move',
                        'message' => $message,
                        'type' => 'client_schedule_permanent_move',
                    ]);
                } else {
                    $message = "By " . Auth::user()->name . "\n" . $oldDate . " → " . $newDate;
                    Notification::create([
                        'user_id' => Auth::id(),
                        'action_id' => $schedule->id,
                        'title' => $clientName . ' - Permanent Pending',
                        'message' => $message,
                        'type' => 'client_schedule_permanent_move_pending',
                    ]);
                }

                $movedCount++;
            } catch (\Exception $e) {
                $skippedCount++;
                $clientName = $scheduleData['client_name'] ?? 'Unknown';
                $errors[] = $clientName . ': ' . $e->getMessage();
            }
        }

        $directionLabel = ($direction === 'next') ? 'forward' : 'backward';
        $message = '';
        if ($movedCount > 0) {
            $message .= "{$movedCount} schedule(s) permanently moved {$directionLabel} successfully across all future months. ";
        }
        if ($skippedCount > 0) {
            $message .= "{$skippedCount} schedule(s) skipped. ";
        }

        return response()->json([
            'success' => $movedCount > 0,
            'message' => trim($message),
            'moved_count' => $movedCount,
            'skipped_count' => $skippedCount,
            'errors' => $errors
        ]);
    }

    public function updateMonthlyDate(\Illuminate\Http\Request $request)
    {
        try {
            $request->validate([
                'schedule_id' => 'required|exists:client_schedules,id',
                'start_date' => 'required|date',
            ]);

            $schedule = ClientSchedule::findOrFail($request->schedule_id);

            // Verify this is a monthly/biMonthly schedule
            $serviceFrequency = optional($schedule->clientName)->service_frequency;
            if ($serviceFrequency !== 'monthly' && $serviceFrequency !== 'biMonthly') {
                return response()->json([
                    'success' => false,
                    'message' => 'This operation is only allowed for monthly/biMonthly schedules.'
                ], 400);
            }

            // Get client_id to update all schedules for this client
            $clientId = $schedule->client_id;

            // Parse the new start date and old start date
            $newStartDate = \Carbon\Carbon::parse($request->start_date);
            $oldStartDate = \Carbon\Carbon::parse($schedule->start_date);

            // Calculate the difference in days (offset)
            $daysDifference = $oldStartDate->diffInDays($newStartDate, false);

            // Calculate which week this date falls into
            $dayOfMonth = $newStartDate->day;

            // Determine week number (0-3)
            if ($dayOfMonth <= 7) {
                $weekNumber = 0;
            } elseif ($dayOfMonth <= 14) {
                $weekNumber = 1;
            } elseif ($dayOfMonth <= 21) {
                $weekNumber = 2;
            } else {
                $weekNumber = 3;
            }

            // Get all schedules for this client
            $allSchedules = ClientSchedule::where('client_id', $clientId)->get();

            $updatedCount = 0;

            // Update each schedule by adding the same number of days
            foreach ($allSchedules as $clientSchedule) {
                // Parse the existing start date
                $existingStartDate = \Carbon\Carbon::parse($clientSchedule->start_date);

                // Add the same number of days to this schedule
                $newScheduleStartDate = $existingStartDate->copy()->addDays($daysDifference);
                $newScheduleEndDate = $newScheduleStartDate->copy()->addDays(7);

                // Update the schedule
                $clientSchedule->start_date = $newScheduleStartDate->format('Y-m-d');
                $clientSchedule->end_date = $newScheduleEndDate->format('Y-m-d');
                $clientSchedule->month = $newScheduleStartDate->format('F');
                $clientSchedule->save();

                $updatedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} schedule(s) for this client. All schedules moved by {$daysDifference} days.",
                'data' => [
                    'updated_count' => $updatedCount,
                    'days_difference' => $daysDifference,
                    'new_day_of_month' => $dayOfMonth,
                    'week' => 'week' . $weekNumber
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating monthly schedule date: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update schedule date. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getWeekMonthFromDate($date)
    {
        return "January";
    }
}
