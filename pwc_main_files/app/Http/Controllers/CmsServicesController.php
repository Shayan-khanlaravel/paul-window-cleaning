<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CmsService;
use App\Http\Requests\CmsServiceRequest;
use Spatie\Permission\Models\Permission;

class CmsServicesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cmsservices-list|cmsservices-create|cmsservices-edit|cmsservices-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cmsservices-create', ['only' => ['create','store']]);
         $this->middleware('permission:cmsservices-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cmsservices-delete', ['only' => ['destroy']]);
         $this->middleware('permission:cmsservices-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cmsservices= CmsService::all();
        return view('cmsservices.index', ['cmsservices'=>$cmsservices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('cmsservices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CmsServiceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CmsServiceRequest $request)
    {
        $cmsservice = new CmsService;
		$cmsservice->section_one_heading = $request->input('section_one_heading');
		$cmsservice->section_one_description = $request->input('section_one_description');
		$cmsservice->section_two_heading = $request->input('section_two_heading');
		$cmsservice->section_two_description = $request->input('section_two_description');
		$cmsservice->section_one_image = $request->input('section_one_image');
		$cmsservice->section_two_image = $request->input('section_two_image');
        $cmsservice->save();

        return to_route('cmsservices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $cmsservice = CmsService::findOrFail($id);
        return view('cmsservices.show',['cmsservice'=>$cmsservice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $cmsservice = CmsService::findOrFail($id);
        return view('cmsservices.edit',['cmsservice'=>$cmsservice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CmsServiceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CmsServiceRequest $request, $id)
    {
        $cmsservice = CmsService::findOrFail($id);
		$cmsservice->section_one_heading = $request->input('section_one_heading');
		$cmsservice->section_one_description = $request->input('section_one_description');
		$cmsservice->section_two_heading = $request->input('section_two_heading');
		$cmsservice->section_two_description = $request->input('section_two_description');
		$cmsservice->section_one_image = $request->input('section_one_image');
		$cmsservice->section_two_image = $request->input('section_two_image');
        $cmsservice->save();

        return to_route('cmsservices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cmsservice = CmsService::findOrFail($id);
        $cmsservice->delete();

        return to_route('cmsservices.index');
    }
}
