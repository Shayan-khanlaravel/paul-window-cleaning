<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ClientSchedulePrice;
use App\Http\Requests\ClientSchedulePriceRequest;
use Spatie\Permission\Models\Permission;

class ClientSchedulePricesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:clientscheduleprices-list|clientscheduleprices-create|clientscheduleprices-edit|clientscheduleprices-delete', ['only' => ['index','store']]);
         $this->middleware('permission:clientscheduleprices-create', ['only' => ['create','store']]);
         $this->middleware('permission:clientscheduleprices-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:clientscheduleprices-delete', ['only' => ['destroy']]);
         $this->middleware('permission:clientscheduleprices-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clientscheduleprices= ClientSchedulePrice::all();
        return view('clientscheduleprices.index', ['clientscheduleprices'=>$clientscheduleprices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('clientscheduleprices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientSchedulePriceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientSchedulePriceRequest $request)
    {
        $clientscheduleprice = new ClientSchedulePrice;
		$clientscheduleprice->client_id = $request->input('client_id');
		$clientscheduleprice->schedule_id = $request->input('schedule_id');
		$clientscheduleprice->price_id = $request->input('price_id');
        $clientscheduleprice->save();

        return to_route('clientscheduleprices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $clientscheduleprice = ClientSchedulePrice::findOrFail($id);
        return view('clientscheduleprices.show',['clientscheduleprice'=>$clientscheduleprice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $clientscheduleprice = ClientSchedulePrice::findOrFail($id);
        return view('clientscheduleprices.edit',['clientscheduleprice'=>$clientscheduleprice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientSchedulePriceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientSchedulePriceRequest $request, $id)
    {
        $clientscheduleprice = ClientSchedulePrice::findOrFail($id);
		$clientscheduleprice->client_id = $request->input('client_id');
		$clientscheduleprice->schedule_id = $request->input('schedule_id');
		$clientscheduleprice->price_id = $request->input('price_id');
        $clientscheduleprice->save();

        return to_route('clientscheduleprices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $clientscheduleprice = ClientSchedulePrice::findOrFail($id);
        $clientscheduleprice->delete();

        return to_route('clientscheduleprices.index');
    }
}
