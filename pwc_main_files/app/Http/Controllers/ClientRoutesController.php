<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ClientRoute;
use App\Http\Requests\ClientRouteRequest;
use Spatie\Permission\Models\Permission;

class ClientRoutesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:clientroutes-list|clientroutes-create|clientroutes-edit|clientroutes-delete', ['only' => ['index','store']]);
         $this->middleware('permission:clientroutes-create', ['only' => ['create','store']]);
         $this->middleware('permission:clientroutes-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:clientroutes-delete', ['only' => ['destroy']]);
         $this->middleware('permission:clientroutes-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clientroutes= ClientRoute::all();
        return view('clientroutes.index', ['clientroutes'=>$clientroutes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('clientroutes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientRouteRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientRouteRequest $request)
    {
        $clientroute = new ClientRoute;
		$clientroute->client_id = $request->input('client_id');
		$clientroute->route_id = $request->input('route_id');
        $clientroute->save();

        return to_route('clientroutes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $clientroute = ClientRoute::findOrFail($id);
        return view('clientroutes.show',['clientroute'=>$clientroute]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $clientroute = ClientRoute::findOrFail($id);
        return view('clientroutes.edit',['clientroute'=>$clientroute]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientRouteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientRouteRequest $request, $id)
    {
        $clientroute = ClientRoute::findOrFail($id);
		$clientroute->client_id = $request->input('client_id');
		$clientroute->route_id = $request->input('route_id');
        $clientroute->save();

        return to_route('clientroutes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $clientroute = ClientRoute::findOrFail($id);
        $clientroute->delete();

        return to_route('clientroutes.index');
    }
}
