<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AssignWeek;
use App\Http\Requests\AssignWeekRequest;
use Spatie\Permission\Models\Permission;

class AssignWeeksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:assignweeks-list|assignweeks-create|assignweeks-edit|assignweeks-delete', ['only' => ['index','store']]);
         $this->middleware('permission:assignweeks-create', ['only' => ['create','store']]);
         $this->middleware('permission:assignweeks-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:assignweeks-delete', ['only' => ['destroy']]);
         $this->middleware('permission:assignweeks-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $assignweeks= AssignWeek::all();
        return view('assignweeks.index', ['assignweeks'=>$assignweeks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('assignweeks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AssignWeekRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AssignWeekRequest $request)
    {
        $assignweek = new AssignWeek;
		$assignweek->client_id = $request->input('client_id');
		$assignweek->assign_week = $request->input('assign_week');
		$assignweek->week = $request->input('week');
		$assignweek->note = $request->input('note');
        $assignweek->save();

        return to_route('assignweeks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $assignweek = AssignWeek::findOrFail($id);
        return view('assignweeks.show',['assignweek'=>$assignweek]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $assignweek = AssignWeek::findOrFail($id);
        return view('assignweeks.edit',['assignweek'=>$assignweek]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AssignWeekRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AssignWeekRequest $request, $id)
    {
        $assignweek = AssignWeek::findOrFail($id);
		$assignweek->client_id = $request->input('client_id');
		$assignweek->assign_week = $request->input('assign_week');
		$assignweek->week = $request->input('week');
		$assignweek->note = $request->input('note');
        $assignweek->save();

        return to_route('assignweeks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $assignweek = AssignWeek::findOrFail($id);
        $assignweek->delete();

        return to_route('assignweeks.index');
    }
}
