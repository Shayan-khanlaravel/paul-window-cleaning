<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\StaffRequirement;
use App\Http\Requests\StaffRequirementRequest;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class StaffRequirementsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:staffrequirements-list|staffrequirements-create|staffrequirements-edit|staffrequirements-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:staffrequirements-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:staffrequirements-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:staffrequirements-delete', ['only' => ['destroy']]);
        $this->middleware('permission:staffrequirements-list', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $staffrequirements = StaffRequirement::all();
        return view('staffrequirements.index', ['staffrequirements' => $staffrequirements]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('staffrequirements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StaffRequirementRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StaffRequirementRequest $request)
    {
        //        return $request->all();
        $items = [
            'soap' => $request->input('items.soap'),
            'business_card' => $request->input('items.business_card'),
            'blade' => $request->input('items.blade'),
            'other' => $request->input('items.other'),
        ];

        foreach ($items as $key => $item) {
            if (isset($item['quantity']) && $item['quantity'] > 0) {
                StaffRequirement::create([
                    'staff_id' => auth()->id(),
                    'name' => ($key),
                    'quantity' => $item['quantity'],
                    'description' => $key === 'other' ? $item['description'] : null,
                    'status' => 'pending',
                    'timestamp' => $request->timestamp,
                ]);
            }
        }

        Notification::create([
            'user_id' => 2,
            'action_id' => 2,
            'title' => 'Staff ' . Auth::user()->name . ' New Requirement',
            'message' => 'A new requirement has been submitted.',
            'type' => 'new_requirement',
        ]);

        return redirect()->route('dashboard_index')->with(['title' => 'Done', 'message' => 'Requirement Submit Successfully', 'type' => 'success',]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $staffrequirement = StaffRequirement::findOrFail($id);
        return view('staffrequirements.show', ['staffrequirement' => $staffrequirement]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $staffrequirement = StaffRequirement::findOrFail($id);
        return view('staffrequirements.edit', ['staffrequirement' => $staffrequirement]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StaffRequirementRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StaffRequirementRequest $request, $id)
    {
        $staffrequirement = StaffRequirement::findOrFail($id);
        $staffrequirement->staff_id = $request->input('staff_id');
        $staffrequirement->name = $request->input('name');
        $staffrequirement->quantity = $request->input('quantity');
        $staffrequirement->description = $request->input('description');
        $staffrequirement->status = $request->input('status');
        $staffrequirement->save();

        return to_route('staffrequirements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $staffrequirement = StaffRequirement::findOrFail($id);
        $staffrequirement->delete();

        return to_route('staffrequirements.index');
    }
}
