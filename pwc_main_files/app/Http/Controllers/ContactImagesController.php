<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ContactImage;
use App\Http\Requests\ContactImageRequest;
use Spatie\Permission\Models\Permission;

class ContactImagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:contactimages-list|contactimages-create|contactimages-edit|contactimages-delete', ['only' => ['index','store']]);
         $this->middleware('permission:contactimages-create', ['only' => ['create','store']]);
         $this->middleware('permission:contactimages-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:contactimages-delete', ['only' => ['destroy']]);
         $this->middleware('permission:contactimages-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $contactimages= ContactImage::all();
        return view('contactimages.index', ['contactimages'=>$contactimages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('contactimages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactImageRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactImageRequest $request)
    {
        $contactimage = new ContactImage;
		$contactimage->contact_id = $request->input('contact_id');
		$contactimage->image = $request->input('image');
        $contactimage->save();

        return to_route('contactimages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $contactimage = ContactImage::findOrFail($id);
        return view('contactimages.show',['contactimage'=>$contactimage]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $contactimage = ContactImage::findOrFail($id);
        return view('contactimages.edit',['contactimage'=>$contactimage]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContactImageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContactImageRequest $request, $id)
    {
        $contactimage = ContactImage::findOrFail($id);
		$contactimage->contact_id = $request->input('contact_id');
		$contactimage->image = $request->input('image');
        $contactimage->save();

        return to_route('contactimages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $contactimage = ContactImage::findOrFail($id);
        $contactimage->delete();

        return to_route('contactimages.index');
    }
}
