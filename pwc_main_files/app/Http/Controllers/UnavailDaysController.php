<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\UnavailDay;
use App\Http\Requests\UnavailDayRequest;
use Spatie\Permission\Models\Permission;

class UnavailDaysController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:unavaildays-list|unavaildays-create|unavaildays-edit|unavaildays-delete', ['only' => ['index','store']]);
         $this->middleware('permission:unavaildays-create', ['only' => ['create','store']]);
         $this->middleware('permission:unavaildays-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:unavaildays-delete', ['only' => ['destroy']]);
         $this->middleware('permission:unavaildays-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $unavaildays= UnavailDay::all();
        return view('unavaildays.index', ['unavaildays'=>$unavaildays]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('unavaildays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UnavailDayRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UnavailDayRequest $request)
    {
        $unavailday = new UnavailDay;
		$unavailday->client_id = $request->input('client_id');
		$unavailday->day = $request->input('day');
        $unavailday->save();

        return to_route('unavaildays.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $unavailday = UnavailDay::findOrFail($id);
        return view('unavaildays.show',['unavailday'=>$unavailday]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $unavailday = UnavailDay::findOrFail($id);
        return view('unavaildays.edit',['unavailday'=>$unavailday]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UnavailDayRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UnavailDayRequest $request, $id)
    {
        $unavailday = UnavailDay::findOrFail($id);
		$unavailday->client_id = $request->input('client_id');
		$unavailday->day = $request->input('day');
        $unavailday->save();

        return to_route('unavaildays.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $unavailday = UnavailDay::findOrFail($id);
        $unavailday->delete();

        return to_route('unavaildays.index');
    }
}
