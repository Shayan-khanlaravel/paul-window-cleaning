<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AssignRoute;
use App\Http\Requests\AssignRouteRequest;
use Spatie\Permission\Models\Permission;

class AssignRoutesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:assignroutes-list|assignroutes-create|assignroutes-edit|assignroutes-delete', ['only' => ['index','store']]);
         $this->middleware('permission:assignroutes-create', ['only' => ['create','store']]);
         $this->middleware('permission:assignroutes-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:assignroutes-delete', ['only' => ['destroy']]);
         $this->middleware('permission:assignroutes-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $assignroutes= AssignRoute::all();
        return view('assignroutes.index', ['assignroutes'=>$assignroutes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('assignroutes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AssignRouteRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
//    public function store(AssignRouteRequest $request)
//    {
//        $assignroute = new AssignRoute;
//		$assignroute->route_id = $request->input('route_id');
//		$assignroute->staff_id = $request->input('staff_id');
//        $assignroute->save();
//
//        return redirect()->back()->with(['title'=>'Done','message'=>'Route Assigned Successfully','type'=>'success']);
//    }
    public function store(AssignRouteRequest $request)
    {
        $routeIds = $request->input('route_id');
        $staffId = $request->input('staff_id');

        if (!empty($routeIds) && !empty($staffId)) {
            $existingRoutes = AssignRoute::where('staff_id', $staffId)->get();

            foreach ($existingRoutes as $existingRoute) {
                if (!in_array($existingRoute->route_id, $routeIds)) {
                    $existingRoute->delete();
                }
            }

            foreach ($routeIds as $routeId) {
                if (!AssignRoute::where('staff_id', $staffId)->where('route_id', $routeId)->exists()) {
                    AssignRoute::create([
                        'route_id' => $routeId,
                        'staff_id' => $staffId
                    ]);
                }
            }

            return redirect()->back()->with(['title' => 'Done', 'message' => 'Routes assigned successfully!', 'type' => 'success']);
        }

        return redirect()->back()->with(['title' => 'Error', 'message' => 'No routes selected for assignment!', 'type' => 'error']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $assignroute = AssignRoute::findOrFail($id);
        return view('assignroutes.show',['assignroute'=>$assignroute]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $assignroute = AssignRoute::findOrFail($id);
        return view('assignroutes.edit',['assignroute'=>$assignroute]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AssignRouteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AssignRouteRequest $request, $id)
    {
        $assignroute = AssignRoute::findOrFail($id);
		$assignroute->route_id = $request->input('route_id');
		$assignroute->staff_id = $request->input('staff_id');
        $assignroute->save();

        return to_route('assignroutes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $assignroute = AssignRoute::findOrFail($id);
        $assignroute->delete();

        return to_route('assignroutes.index');
    }
}
