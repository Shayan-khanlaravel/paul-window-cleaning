<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CmsContact;
use App\Http\Requests\CmsContactRequest;
use Spatie\Permission\Models\Permission;

class CmsContactsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cmscontacts-list|cmscontacts-create|cmscontacts-edit|cmscontacts-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cmscontacts-create', ['only' => ['create','store']]);
         $this->middleware('permission:cmscontacts-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cmscontacts-delete', ['only' => ['destroy']]);
         $this->middleware('permission:cmscontacts-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cmscontacts= CmsContact::all();
        return view('cmscontacts.index', ['cmscontacts'=>$cmscontacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('cmscontacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CmsContactRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CmsContactRequest $request)
    {
        $cmscontact = new CmsContact;
		$cmscontact->section_one_heading = $request->input('section_one_heading');
		$cmscontact->section_one_description = $request->input('section_one_description');
		$cmscontact->section_one_icon = $request->input('section_one_icon');
		$cmscontact->section_two_heading = $request->input('section_two_heading');
		$cmscontact->section_two_phone = $request->input('section_two_phone');
		$cmscontact->section_two_icon = $request->input('section_two_icon');
        $cmscontact->save();

        return to_route('cmscontacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $cmscontact = CmsContact::findOrFail($id);
        return view('cmscontacts.show',['cmscontact'=>$cmscontact]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $cmscontact = CmsContact::findOrFail($id);
        return view('cmscontacts.edit',['cmscontact'=>$cmscontact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CmsContactRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CmsContactRequest $request, $id)
    {
        $cmscontact = CmsContact::findOrFail($id);
		$cmscontact->section_one_heading = $request->input('section_one_heading');
		$cmscontact->section_one_description = $request->input('section_one_description');
		$cmscontact->section_one_icon = $request->input('section_one_icon');
		$cmscontact->section_two_heading = $request->input('section_two_heading');
		$cmscontact->section_two_phone = $request->input('section_two_phone');
		$cmscontact->section_two_icon = $request->input('section_two_icon');
        $cmscontact->save();

        return to_route('cmscontacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cmscontact = CmsContact::findOrFail($id);
        $cmscontact->delete();

        return to_route('cmscontacts.index');
    }
}
