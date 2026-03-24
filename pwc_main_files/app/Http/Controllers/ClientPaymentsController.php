<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ClientPayment;
use App\Http\Requests\ClientPaymentRequest;
use Spatie\Permission\Models\Permission;

class ClientPaymentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:clientpayments-list|clientpayments-create|clientpayments-edit|clientpayments-delete', ['only' => ['index','store']]);
         $this->middleware('permission:clientpayments-create', ['only' => ['create','store']]);
         $this->middleware('permission:clientpayments-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:clientpayments-delete', ['only' => ['destroy']]);
         $this->middleware('permission:clientpayments-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clientpayments= ClientPayment::all();
        return view('clientpayments.index', ['clientpayments'=>$clientpayments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('clientpayments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientPaymentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientPaymentRequest $request)
    {
        $clientpayment = new ClientPayment;
		$clientpayment->client_id = $request->input('client_id');
		$clientpayment->option = $request->input('option');
		$clientpayment->option_two = $request->input('option_two');
		$clientpayment->option_three = $request->input('option_three');
		$clientpayment->option_four = $request->input('option_four');
		$clientpayment->reason = $request->input('reason');
		$clientpayment->scope = $request->input('scope');
		$clientpayment->amount = $request->input('amount');
		$clientpayment->price_charge_one = $request->input('price_charge_one');
		$clientpayment->price_charge_two = $request->input('price_charge_two');
		$clientpayment->final_price = $request->input('final_price');
        $clientpayment->save();

        return to_route('clientpayments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $clientpayment = ClientPayment::findOrFail($id);
        return view('clientpayments.show',['clientpayment'=>$clientpayment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $clientpayment = ClientPayment::findOrFail($id);
        return view('clientpayments.edit',['clientpayment'=>$clientpayment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientPaymentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientPaymentRequest $request, $id)
    {
        $clientpayment = ClientPayment::findOrFail($id);
		$clientpayment->client_id = $request->input('client_id');
		$clientpayment->option = $request->input('option');
		$clientpayment->option_two = $request->input('option_two');
		$clientpayment->option_three = $request->input('option_three');
		$clientpayment->option_four = $request->input('option_four');
		$clientpayment->reason = $request->input('reason');
		$clientpayment->scope = $request->input('scope');
		$clientpayment->amount = $request->input('amount');
		$clientpayment->price_charge_one = $request->input('price_charge_one');
		$clientpayment->price_charge_two = $request->input('price_charge_two');
		$clientpayment->final_price = $request->input('final_price');
        $clientpayment->save();

        return to_route('clientpayments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $clientpayment = ClientPayment::findOrFail($id);
        $clientpayment->delete();

        return to_route('clientpayments.index');
    }
}
