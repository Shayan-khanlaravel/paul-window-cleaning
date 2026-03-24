<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ClientImage;
use App\Http\Requests\ClientImageRequest;
use Spatie\Permission\Models\Permission;

class ClientImagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:clientimages-list|clientimages-create|clientimages-edit|clientimages-delete', ['only' => ['index','store']]);
         $this->middleware('permission:clientimages-create', ['only' => ['create','store']]);
         $this->middleware('permission:clientimages-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:clientimages-delete', ['only' => ['destroy']]);
         $this->middleware('permission:clientimages-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clientimages= ClientImage::all();
        return view('clientimages.index', ['clientimages'=>$clientimages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('clientimages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientImageRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientImageRequest $request)
    {
        $clientimage = new ClientImage;
		$clientimage->client_id = $request->input('client_id');
		$clientimage->image = $request->input('image');
        $clientimage->save();

        return to_route('clientimages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $clientimage = ClientImage::findOrFail($id);
        return view('clientimages.show',['clientimage'=>$clientimage]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $clientimage = ClientImage::findOrFail($id);
        return view('clientimages.edit',['clientimage'=>$clientimage]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientImageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientImageRequest $request, $id)
    {
        $clientimage = ClientImage::findOrFail($id);
		$clientimage->client_id = $request->input('client_id');
		$clientimage->image = $request->input('image');
        $clientimage->save();

        return to_route('clientimages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $clientimage = ClientImage::findOrFail($id);
        $clientimage->delete();

        return to_route('clientimages.index');
    }
}
