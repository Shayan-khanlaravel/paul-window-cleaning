<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ClientTime;
use App\Http\Requests\ClientTimeRequest;
use Spatie\Permission\Models\Permission;

class ClientTimesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:clienttimes-list|clienttimes-create|clienttimes-edit|clienttimes-delete', ['only' => ['index','store']]);
         $this->middleware('permission:clienttimes-create', ['only' => ['create','store']]);
         $this->middleware('permission:clienttimes-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:clienttimes-delete', ['only' => ['destroy']]);
         $this->middleware('permission:clienttimes-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clienttimes= ClientTime::all();
        return view('clienttimes.index', ['clienttimes'=>$clienttimes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('clienttimes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientTimeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientTimeRequest $request)
    {
        $clienttime = new ClientTime;
		$clienttime->client_id = $request->input('client_id');
		$clienttime->start_hour = $request->input('start_hour');
		$clienttime->end_hour = $request->input('end_hour');
        $clienttime->save();

        return to_route('clienttimes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $clienttime = ClientTime::findOrFail($id);
        return view('clienttimes.show',['clienttime'=>$clienttime]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $clienttime = ClientTime::findOrFail($id);
        return view('clienttimes.edit',['clienttime'=>$clienttime]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientTimeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientTimeRequest $request, $id)
    {
        $clienttime = ClientTime::findOrFail($id);
		$clienttime->client_id = $request->input('client_id');
		$clienttime->start_hour = $request->input('start_hour');
		$clienttime->end_hour = $request->input('end_hour');
        $clienttime->save();

        return to_route('clienttimes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $clienttime = ClientTime::findOrFail($id);
        $clienttime->delete();

        return to_route('clienttimes.index');
    }
}
