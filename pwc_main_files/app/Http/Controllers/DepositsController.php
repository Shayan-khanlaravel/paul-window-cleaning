<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{Deposit, StaffRoute, ClientSchedule, ClientPayment, Client, ClientRoute, AssignRoute, Notification};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DepositsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Deposit::with(['route', 'staff']);

            // Filter by staff_id for staff users (not admin)
            $user = Auth::user();
            if ($user && !$user->hasRole('admin')) {
                // Filter deposits to only show those created by this staff user
                $query->where('staff_id', $user->id);
            }

            // Filter by route
            if ($request->filled('route_id')) {
                $query->where('route_id', $request->route_id);
            }

            // Filter by month
            if ($request->filled('month')) {
                $query->where('month', $request->month);
            }

            // Filter by year
            if ($request->filled('year')) {
                $query->where('year', $request->year);
            }

            // Filter by deposit status
            if ($request->filled('is_deposit')) {
                $query->where('is_deposit', $request->is_deposit);
            }

            $deposits = $query->orderBy('created_at', 'desc')->paginate(20);

            // Get routes - for staff, only show their assigned routes; for admin, show all
            if ($user && !$user->hasRole('admin')) {
                $assignedRouteIds = AssignRoute::where('staff_id', $user->id)
                    ->pluck('route_id')
                    ->toArray();
                $routes = StaffRoute::where('status', 1)
                    ->whereIn('id', $assignedRouteIds)
                    ->get();
            } else {
                $routes = StaffRoute::where('status', 1)->get();
            }

            return view('dashboard.deposits', compact('deposits', 'routes'));
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'title' => 'Error',
                'message' => 'Failed to load deposits: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function create(Request $request)
    {
        try {
            $user = Auth::user();
            // Get routes - for staff, only show their assigned routes; for admin, show all
            if ($user && !$user->hasRole('admin')) {
                $assignedRouteIds = AssignRoute::where('staff_id', $user->id)
                    ->pluck('route_id')
                    ->toArray();
                $routes = StaffRoute::where('status', 1)
                    ->whereIn('id', $assignedRouteIds)
                    ->get();
            } else {
                $routes = StaffRoute::where('status', 1)->get();
            }

            // Pre-fill data if coming from route show page
            $routeId = $request->route_id;
            $week = $request->week;
            $month = $request->month;
            $year = $request->year;
            $totalAmount = $request->total_amount;

            return view('deposits.create', compact('routes', 'routeId', 'week', 'month', 'year', 'totalAmount'));
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'title' => 'Error',
                'message' => 'Failed to load create form: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    private function calculateExpectedCash($routeId, $week, $month, $year)
    {
        try {
            $staffRoute = StaffRoute::with([
                'clientRoute.clientSchedule.clientSchedulePrice.clientPaymentPrice',
                'clientRoute.clientSchedule.clientName'
            ])->findOrFail($routeId);

            $weekNumber = (int) preg_replace('/[^0-9]/', '', $week);
            $selectedMonth = trim($month);

            // Check if year is already present in the month string
            if (!preg_match('/\d{4}/', $selectedMonth)) {
                // Year not present, add it
                $selectedMonth = trim($selectedMonth) . " " . $year;
            }
            // Now $selectedMonth = "March - April 2026" or "March 2026"

            // Get month start date - EXACT copy from StaffRoutesController show method
            $firstMondayOfYear = Carbon::parse("first Monday of January $year");

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

            // Extract base month name exactly like StaffRoutesController
            $baseMonthName = trim(str_replace($year, '', $selectedMonth));

            // If the month name is not in customStartDates, default to January - February
            if (!array_key_exists($baseMonthName, $customStartDates)) {
                \Log::warning('Month not found in customStartDates', [
                    'baseMonthName' => $baseMonthName,
                    'selectedMonth' => $selectedMonth
                ]);
                $baseMonthName = "January - February";
            }

            $firstDayOfMonth = $customStartDates[$baseMonthName];

            // Build weeks EXACTLY like StaffRoutesController show method
            $weeks = collect();
            $tempFirstDay = $firstDayOfMonth->copy();

            for ($i = 0; $i < 4; $i++) {
                $endOfWeek = $tempFirstDay->copy()->addDays(6);

                $weeks->push([
                    'week_number' => $i + 1, // week_number starts from 1 in show method
                    'start_date' => $tempFirstDay->format('d F Y'),
                    'end_date' => $endOfWeek->format('d F Y'),
                    'routes' => [],
                ]);

                $tempFirstDay->addDays(7);
            }

            // Get the specific week (week0 = index 0 = week_number 1)
            $targetWeekIndex = $weekNumber; // week0=0, week1=1, week2=2, week3=3
            $targetWeek = $weeks->get($targetWeekIndex);

            if (!$targetWeek) {
                return 0;
            }

            // Build mergedSchedules EXACTLY like StaffRoutesController show method
            $weekStartDate = Carbon::parse($targetWeek['start_date']);
            $weekEndDate = Carbon::parse($targetWeek['end_date']);

            $filteredRoutes = $staffRoute->clientRoute->flatMap(function ($clientRoute) use ($weekStartDate, $weekEndDate) {
                return $clientRoute->clientSchedule->filter(function ($clientSchedule) use ($weekStartDate, $weekEndDate) {
                    $scheduleStartDate = Carbon::parse($clientSchedule->start_date);
                    $scheduleEndDate = Carbon::parse($clientSchedule->end_date);
                    $serviceFrequency = optional($clientSchedule->clientName)->service_frequency;

                    // Monthly/BiMonthly: check if schedule's exact date falls in this week
                    if ($serviceFrequency == 'monthly' || $serviceFrequency == 'biMonthly') {
                        $scheduleDay = $scheduleStartDate->day;
                        $scheduleMonth = $scheduleStartDate->month;
                        $scheduleYear = $scheduleStartDate->year;

                        for ($d = $weekStartDate->copy(); $d->lte($weekEndDate); $d->addDay()) {
                            if ($d->day == $scheduleDay && $d->month == $scheduleMonth && $d->year == $scheduleYear) {
                                return true;
                            }
                        }
                        return false;
                    }

                    // Weekly/Regular: check if schedule overlaps with week
                    return ($scheduleStartDate->gte($weekStartDate) && $scheduleStartDate->lte($weekEndDate)) ||
                        ($scheduleEndDate->gte($weekStartDate) && $scheduleEndDate->lte($weekEndDate)) ||
                        ($scheduleStartDate->lte($weekStartDate) && $scheduleEndDate->gte($weekEndDate));
                })->map(function ($clientSchedule) {
                    // EXACT same mapping as StaffRoutesController show method
                    $priceSum = optional($clientSchedule->clientSchedulePrice)
                        ->map(fn($schedulePrice) => (float) (optional($schedulePrice->clientPaymentPrice)->value ?? 0))
                        ->sum();

                    // Handle extra_work_price - it's stored as JSON array ["29", "50"] etc
                    $extraWorkPrice = 0;
                    if (!empty($clientSchedule->extra_work_price)) {
                        // Decode JSON if it's a string
                        $extraPrices = is_string($clientSchedule->extra_work_price)
                            ? json_decode($clientSchedule->extra_work_price, true)
                            : $clientSchedule->extra_work_price;

                        // Sum all extra work prices
                        if (is_array($extraPrices)) {
                            $extraWorkPrice = array_sum(array_map('floatval', $extraPrices));
                        } else {
                            $extraWorkPrice = (float) $extraPrices;
                        }
                    }

                    return [
                        'clientSchedule' => optional($clientSchedule)->status ?? '',
                        'payment_type' => optional($clientSchedule->clientName)->payment_type ?? null,
                        'invoice_amount' => $priceSum + $extraWorkPrice,
                    ];
                });
            });

            $pendingRoutes = collect($filteredRoutes)->filter(function ($route) {
                return $route['clientSchedule'] === 'completed' || empty($route['clientSchedule']);
            });

            $expectedCash = 0;
            foreach ($pendingRoutes as $route) {
                if ($route['payment_type'] === 'cash') {
                    $expectedCash += $route['invoice_amount'];
                }
            }

            // Ensure we return a numeric value
            return (float) $expectedCash;
        } catch (\Exception $e) {
            Log::error('Error calculating expected cash: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return 0;
        }
    }

    /**
     * Get expected cash via API
     */
    public function getExpectedCash(Request $request)
    {
        // Force JSON response - set headers before any processing
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');

        try {
            $routeId = $request->input('route_id');
            $week = $request->input('week');
            $month = $request->input('month');
            $year = $request->input('year');

            // For staff users, verify they have access to this route
            $user = Auth::user();
            if ($user && !$user->hasRole('admin')) {
                $assignedRouteIds = AssignRoute::where('staff_id', $user->id)
                    ->pluck('route_id')
                    ->toArray();

                if (!in_array($routeId, $assignedRouteIds)) {
                    return response()->json([
                        'success' => false,
                        'expected_cash' => 0,
                        'already_deposited' => 0,
                        'remaining' => 0,
                        'message' => 'You do not have access to this route'
                    ], 403)->header('Content-Type', 'application/json');
                }
            }

            if (!$routeId || !$week || !$month || !$year) {
                $response = response()->json([
                    'success' => false,
                    'expected_cash' => 0,
                    'already_deposited' => 0,
                    'remaining' => 0,
                    'message' => 'Missing required parameters: route_id, week, month, and year are required'
                ], 400);
                $response->header('Content-Type', 'application/json');
                return $response;
            }

            $expectedCash = $this->calculateExpectedCash($routeId, $week, $month, $year);

            // Ensure it's a number
            if (!is_numeric($expectedCash)) {
                \Log::error('Expected cash is not numeric', [
                    'value' => $expectedCash,
                    'type' => gettype($expectedCash)
                ]);
                $expectedCash = 0;
            }

            // Get already deposited amount for this week/month/year/route
            $alreadyDeposited = Deposit::where('route_id', $routeId)
                ->where('week', $week)
                ->where('month', $month)
                ->where('year', $year)
                ->sum('deposit_amount');

            // Ensure it's a number
            if (!is_numeric($alreadyDeposited)) {
                \Log::error('Already deposited is not numeric', [
                    'value' => $alreadyDeposited,
                    'type' => gettype($alreadyDeposited)
                ]);
                $alreadyDeposited = 0;
            }

            // Convert to float for safe calculation
            $expectedCash = (float) $expectedCash;
            $alreadyDeposited = (float) $alreadyDeposited;
            $remaining = max(0, $expectedCash - $alreadyDeposited);

            \Log::info('getExpectedCash result', [
                'route_id' => $routeId,
                'week' => $week,
                'month' => $month,
                'year' => $year,
                'expected_cash' => $expectedCash,
                'already_deposited' => $alreadyDeposited,
                'remaining' => $remaining
            ]);

            $response = response()->json([
                'success' => true,
                'expected_cash' => round($expectedCash, 2),
                'already_deposited' => round($alreadyDeposited, 2),
                'remaining' => round($remaining, 2)
            ]);
            $response->header('Content-Type', 'application/json');
            $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
            return $response;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Model not found in getExpectedCash: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'expected_cash' => 0,
                'already_deposited' => 0,
                'remaining' => 0,
                'message' => 'Route not found'
            ], 404)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error in getExpectedCash: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'expected_cash' => 0,
                'already_deposited' => 0,
                'remaining' => 0,
                'message' => 'Error calculating expected cash: ' . $e->getMessage()
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    public function store(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->expectsJson();

        try {
            $user = Auth::user();

            // For staff users, verify they have access to the selected route
            if ($user && !$user->hasRole('admin')) {
                $assignedRouteIds = AssignRoute::where('staff_id', $user->id)
                    ->pluck('route_id')
                    ->toArray();

                $requestedRouteId = $request->input('route_id');
                if (!in_array($requestedRouteId, $assignedRouteIds)) {
                    if ($isAjax) {
                        return response()->json([
                            'message' => 'You do not have access to this route',
                            'errors' => [
                                'route_id' => ['You do not have access to the selected route']
                            ]
                        ], 403);
                    }
                    return redirect()->back()->withErrors([
                        'route_id' => 'You do not have access to this route'
                    ])->withInput()->with([
                        'title' => 'Error',
                        'message' => 'You do not have access to the selected route',
                        'type' => 'error'
                    ]);
                }
            }

            $validated = $request->validate([
                'route_id' => 'required|exists:staff_routes,id',
                'week' => 'required|string',
                'month' => 'required|string',
                'year' => 'required|integer|min:2020|max:2100',
                'total_amount' => 'required|numeric|min:0',
                'deposit_amount' => 'required|numeric|min:0',
                'is_deposit' => 'nullable|boolean',
                'deposit_date' => 'nullable|date',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Calculate expected cash for validation
            $expectedCash = $this->calculateExpectedCash(
                $validated['route_id'],
                $validated['week'],
                $validated['month'],
                $validated['year']
            );

            // Get already deposited amount for this week/month/year/route (excluding current deposit if editing)
            $alreadyDeposited = Deposit::where('route_id', $validated['route_id'])
                ->where('week', $validated['week'])
                ->where('month', $validated['month'])
                ->where('year', $validated['year'])
                ->sum('deposit_amount');

            $remaining = max(0, $expectedCash - $alreadyDeposited);

            // Auto-set total_amount to expected cash (for display only)
            $validated['total_amount'] = $expectedCash;

            // Auto-set staff_id for staff users (admin can set manually if needed)
            if ($user && !$user->hasRole('admin')) {
                $validated['staff_id'] = $user->id;
            } else {
                // For admin, if staff_id is provided, use it; otherwise set to null
                $validated['staff_id'] = $request->input('staff_id', null);
            }

            // Validate that deposit_amount doesn't exceed remaining expected cash
            if ($validated['deposit_amount'] > $remaining) {
                if ($isAjax) {
                    return response()->json([
                        'message' => 'Deposit amount exceeds remaining expected cash for this week',
                        'errors' => [
                            'deposit_amount' => ["Deposit amount cannot exceed remaining expected cash of $" . number_format($remaining, 2) . " for this week. (Total Expected: $" . number_format($expectedCash, 2) . ", Already Deposited: $" . number_format($alreadyDeposited, 2) . ")"]
                        ]
                    ], 422);
                }

                return redirect()->back()->withErrors([
                    'deposit_amount' => "Deposit amount cannot exceed expected cash of $" . number_format($expectedCash, 2) . " for this week."
                ])->withInput()->with([
                    'title' => 'Validation Error',
                    'message' => 'Deposit amount exceeds expected cash for this week',
                    'type' => 'error'
                ]);
            }

            // Set is_deposit to false if not checked
            $validated['is_deposit'] = $request->has('is_deposit') ? true : false;

            Deposit::create($validated);

            Notification::create([
                'user_id' => 2,
                'action_id' => 2,
                'title' => Auth::user()->name . ' New Deposit Created',
                'message' => 'A new deposit has been created.',
                'type' => 'new_deposit',
            ]);

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Deposit created successfully'
                ]);
            }

            return redirect()->route('deposits.index')->with([
                'title' => 'Success',
                'message' => 'Deposit created successfully',
                'type' => 'success'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput()->with([
                'title' => 'Validation Error',
                'message' => 'Please check the form and try again',
                'type' => 'error'
            ]);
        } catch (\Exception $e) {
            if ($isAjax) {
                return response()->json([
                    'message' => 'Failed to create deposit: ' . $e->getMessage(),
                    'errors' => []
                ], 500);
            }

            return redirect()->back()->withInput()->with([
                'title' => 'Error',
                'message' => 'Failed to create deposit: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Get deposit data for editing (AJAX)
     */
    public function getDepositData($id)
    {
        try {
            $deposit = Deposit::with(['route'])->findOrFail($id);
            $user = Auth::user();

            // For staff users, check if this deposit belongs to them
            if ($user && !$user->hasRole('admin')) {
                if ($deposit->staff_id != $user->id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You do not have permission to edit this deposit.'
                    ], 403)->header('Content-Type', 'application/json');
                }
            }

            return response()->json([
                'success' => true,
                'deposit' => [
                    'id' => $deposit->id,
                    'route_id' => $deposit->route_id,
                    'week' => $deposit->week,
                    'month' => $deposit->month,
                    'year' => $deposit->year,
                    'deposit_amount' => $deposit->deposit_amount,
                    'deposit_date' => $deposit->deposit_date ? $deposit->deposit_date->format('Y-m-d') : '',
                    'notes' => $deposit->notes,
                ]
            ])->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load deposit data: ' . $e->getMessage()
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $deposit = Deposit::findOrFail($id);
            $user = Auth::user();

            // For staff users, check if this deposit belongs to them
            if ($user && !$user->hasRole('admin')) {
                if ($deposit->staff_id != $user->id) {
                    return redirect()->route('deposits.index')->with([
                        'title' => 'Error',
                        'message' => 'You do not have permission to update this deposit.',
                        'type' => 'error'
                    ]);
                }
            }

            $validated = $request->validate([
                'route_id' => 'required|exists:staff_routes,id',
                'week' => 'required|string',
                'month' => 'required|string',
                'year' => 'required|integer|min:2020|max:2100',
                'total_amount' => 'required|numeric|min:0',
                'deposit_amount' => 'required|numeric|min:0',
                'is_deposit' => 'nullable|boolean',
                'deposit_date' => 'nullable|date',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Calculate expected cash for validation
            $expectedCash = $this->calculateExpectedCash(
                $validated['route_id'],
                $validated['week'],
                $validated['month'],
                $validated['year']
            );

            // Get already deposited amount for this week/month/year/route (excluding current deposit)
            $alreadyDeposited = Deposit::where('route_id', $validated['route_id'])
                ->where('week', $validated['week'])
                ->where('month', $validated['month'])
                ->where('year', $validated['year'])
                ->where('id', '!=', $id)
                ->sum('deposit_amount');

            // Calculate remaining expected cash
            $remaining = max(0, $expectedCash - $alreadyDeposited);

            // Auto-set total_amount to expected cash (for display only)
            $validated['total_amount'] = $expectedCash;

            // Validate that deposit_amount doesn't exceed remaining expected cash
            if ($validated['deposit_amount'] > $remaining) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'message' => 'Deposit amount exceeds remaining expected cash for this week',
                        'errors' => [
                            'deposit_amount' => ["Deposit amount cannot exceed remaining expected cash of $" . number_format($remaining, 2) . " for this week. (Total Expected: $" . number_format($expectedCash, 2) . ", Already Deposited: $" . number_format($alreadyDeposited, 2) . ")"]
                        ]
                    ], 422);
                }

                return redirect()->back()->withErrors([
                    'deposit_amount' => "Deposit amount cannot exceed remaining expected cash of $" . number_format($remaining, 2) . " for this week. (Total Expected: $" . number_format($expectedCash, 2) . ", Already Deposited: $" . number_format($alreadyDeposited, 2) . ")"
                ])->withInput()->with([
                    'title' => 'Validation Error',
                    'message' => 'Deposit amount exceeds remaining expected cash for this week',
                    'type' => 'error'
                ]);
            }

            // Set is_deposit to false if not checked
            $validated['is_deposit'] = $request->has('is_deposit') ? true : false;

            $deposit->update($validated);

            return redirect()->route('deposits.index')->with([
                'title' => 'Success',
                'message' => 'Deposit updated successfully',
                'type' => 'success'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('deposits.index')->with([
                'title' => 'Error',
                'message' => 'Deposit not found',
                'type' => 'error'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with([
                'title' => 'Validation Error',
                'message' => 'Please check the form and try again',
                'type' => 'error'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'title' => 'Error',
                'message' => 'Failed to update deposit: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified deposit.
     */
    public function destroy($id)
    {
        try {
            $deposit = Deposit::findOrFail($id);
            $user = Auth::user();

            // For staff users, check if this deposit belongs to them
            if ($user && !$user->hasRole('admin')) {
                if ($deposit->staff_id != $user->id) {
                    if (request()->ajax() || request()->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You do not have permission to delete this deposit.'
                        ], 403)->header('Content-Type', 'application/json');
                    }
                    return redirect()->route('deposits.index')->with([
                        'title' => 'Error',
                        'message' => 'You do not have permission to delete this deposit.',
                        'type' => 'error'
                    ]);
                }
            }

            $deposit->delete();
            Notification::create([
                'user_id' => 2,
                'action_id' => 2,
                'title' => Auth::user()->name . ' has deleted a Deposit',
                'message' => 'A deposit has been deleted.',
                'type' => 'deposit_deleted',
            ]);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Deposit deleted successfully'
                ])->header('Content-Type', 'application/json');
            }

            return redirect()->route('deposits.index')->with([
                'title' => 'Success',
                'message' => 'Deposit deleted successfully',
                'type' => 'success'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('deposits.index')->with([
                'title' => 'Error',
                'message' => 'Deposit not found',
                'type' => 'error'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'title' => 'Error',
                'message' => 'Failed to delete deposit: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Update deposit status (is_deposit checkbox)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $deposit = Deposit::findOrFail($id);
            $user = Auth::user();

            // Only admin can update deposit status
            if (!$user || !$user->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to update deposit status'
                ], 403)->header('Content-Type', 'application/json');
            }

            $deposit->is_deposit = $request->input('is_deposit', 0);
            if ($deposit->is_deposit && !$deposit->deposit_date) {
                $deposit->deposit_date = now();
            }
            $deposit->save();
            Notification::create([
                'user_id' => $deposit->staff_id,
                'action_id' => $deposit->staff_id,
                'title' => 'Deposit Status Updated',
                'message' => 'The status of a deposit has been updated.',
                'type' => 'deposit_status_updated',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Deposit status updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating deposit status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating deposit status: ' . $e->getMessage()
            ], 500);
        }
    }
}
