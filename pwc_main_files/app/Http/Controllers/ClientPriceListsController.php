<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ClientPriceList;
use App\Http\Requests\ClientPriceListRequest;
use Spatie\Permission\Models\Permission;

class ClientPriceListsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:clientpricelists-list|clientpricelists-create|clientpricelists-edit|clientpricelists-delete', ['only' => ['index','store']]);
         $this->middleware('permission:clientpricelists-create', ['only' => ['create','store']]);
         $this->middleware('permission:clientpricelists-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:clientpricelists-delete', ['only' => ['destroy']]);
         $this->middleware('permission:clientpricelists-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clientpricelists= ClientPriceList::all();
        return view('clientpricelists.index', ['clientpricelists'=>$clientpricelists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('clientpricelists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientPriceListRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientPriceListRequest $request)
    {
        $clientpricelist = new ClientPriceList;
		$clientpricelist->client_id = $request->input('client_id');
		$clientpricelist->name = $request->input('name');
		$clientpricelist->value = $request->input('value');
        $clientpricelist->save();

        return to_route('clientpricelists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $clientpricelist = ClientPriceList::findOrFail($id);
        return view('clientpricelists.show',['clientpricelist'=>$clientpricelist]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $clientpricelist = ClientPriceList::findOrFail($id);
        return view('clientpricelists.edit',['clientpricelist'=>$clientpricelist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientPriceListRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientPriceListRequest $request, $id)
    {
        $clientpricelist = ClientPriceList::findOrFail($id);
		$clientpricelist->client_id = $request->input('client_id');
		$clientpricelist->name = $request->input('name');
		$clientpricelist->value = $request->input('value');
        $clientpricelist->save();

        return to_route('clientpricelists.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $clientpricelist = ClientPriceList::findOrFail($id);
        $clientpricelist->delete();

        return to_route('clientpricelists.index');
    }
}
