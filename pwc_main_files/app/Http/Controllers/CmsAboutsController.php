<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CmsAbout;
use App\Http\Requests\CmsAboutRequest;
use Spatie\Permission\Models\Permission;

class CmsAboutsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cmsabouts-list|cmsabouts-create|cmsabouts-edit|cmsabouts-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cmsabouts-create', ['only' => ['create','store']]);
         $this->middleware('permission:cmsabouts-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cmsabouts-delete', ['only' => ['destroy']]);
         $this->middleware('permission:cmsabouts-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cmsabouts= CmsAbout::all();
        return view('cmsabouts.index', ['cmsabouts'=>$cmsabouts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('cmsabouts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CmsAboutRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CmsAboutRequest $request)
    {
        $cmsabout = new CmsAbout;
		$cmsabout->section_one_heading = $request->input('section_one_heading');
		$cmsabout->section_one_description = $request->input('section_one_description');
		$cmsabout->section_two_heading = $request->input('section_two_heading');
		$cmsabout->two_sub_section_one_heading = $request->input('two_sub_section_one_heading');
		$cmsabout->two_sub_section_one_description = $request->input('two_sub_section_one_description');
		$cmsabout->two_sub_section_one_link_one = $request->input('two_sub_section_one_link_one');
		$cmsabout->two_sub_section_one_link_two = $request->input('two_sub_section_one_link_two');
		$cmsabout->two_sub_section_two_heading = $request->input('two_sub_section_two_heading');
		$cmsabout->two_sub_section_two_description = $request->input('two_sub_section_two_description');
		$cmsabout->two_sub_section_two_link_one = $request->input('two_sub_section_two_link_one');
		$cmsabout->two_sub_section_two_link_two = $request->input('two_sub_section_two_link_two');
		$cmsabout->two_sub_section_three_heading = $request->input('two_sub_section_three_heading');
		$cmsabout->two_sub_section_three_description = $request->input('two_sub_section_three_description');
		$cmsabout->two_sub_section_three_link_one = $request->input('two_sub_section_three_link_one');
		$cmsabout->two_sub_section_three_link_two = $request->input('two_sub_section_three_link_two');
		$cmsabout->two_sub_section_four_heading = $request->input('two_sub_section_four_heading');
		$cmsabout->two_sub_section_four_description = $request->input('two_sub_section_four_description');
		$cmsabout->two_sub_section_four_link_one = $request->input('two_sub_section_four_link_one');
		$cmsabout->two_sub_section_four_link_two = $request->input('two_sub_section_four_link_two');
		$cmsabout->two_sub_section_five_heading = $request->input('two_sub_section_five_heading');
		$cmsabout->two_sub_section_five_description = $request->input('two_sub_section_five_description');
		$cmsabout->two_sub_section_five_link_one = $request->input('two_sub_section_five_link_one');
		$cmsabout->two_sub_section_five_link_two = $request->input('two_sub_section_five_link_two');
		$cmsabout->section_one_image = $request->input('section_one_image');
		$cmsabout->two_sub_section_one_image = $request->input('two_sub_section_one_image');
		$cmsabout->two_sub_section_two_image = $request->input('two_sub_section_two_image');
		$cmsabout->two_sub_section_three_image = $request->input('two_sub_section_three_image');
		$cmsabout->two_sub_section_four_image = $request->input('two_sub_section_four_image');
		$cmsabout->two_sub_section_five_image = $request->input('two_sub_section_five_image');
		$cmsabout->two_sub_section_one_title = $request->input('two_sub_section_one_title');
		$cmsabout->two_sub_section_two_title = $request->input('two_sub_section_two_title');
		$cmsabout->two_sub_section_three_title = $request->input('two_sub_section_three_title');
		$cmsabout->two_sub_section_four_title = $request->input('two_sub_section_four_title');
		$cmsabout->two_sub_section_five_title = $request->input('two_sub_section_five_title');
        $cmsabout->save();

        return to_route('cmsabouts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $cmsabout = CmsAbout::findOrFail($id);
        return view('cmsabouts.show',['cmsabout'=>$cmsabout]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $cmsabout = CmsAbout::findOrFail($id);
        return view('cmsabouts.edit',['cmsabout'=>$cmsabout]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CmsAboutRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CmsAboutRequest $request, $id)
    {
        $cmsabout = CmsAbout::findOrFail($id);
		$cmsabout->section_one_heading = $request->input('section_one_heading');
		$cmsabout->section_one_description = $request->input('section_one_description');
		$cmsabout->section_two_heading = $request->input('section_two_heading');
		$cmsabout->two_sub_section_one_heading = $request->input('two_sub_section_one_heading');
		$cmsabout->two_sub_section_one_description = $request->input('two_sub_section_one_description');
		$cmsabout->two_sub_section_one_link_one = $request->input('two_sub_section_one_link_one');
		$cmsabout->two_sub_section_one_link_two = $request->input('two_sub_section_one_link_two');
		$cmsabout->two_sub_section_two_heading = $request->input('two_sub_section_two_heading');
		$cmsabout->two_sub_section_two_description = $request->input('two_sub_section_two_description');
		$cmsabout->two_sub_section_two_link_one = $request->input('two_sub_section_two_link_one');
		$cmsabout->two_sub_section_two_link_two = $request->input('two_sub_section_two_link_two');
		$cmsabout->two_sub_section_three_heading = $request->input('two_sub_section_three_heading');
		$cmsabout->two_sub_section_three_description = $request->input('two_sub_section_three_description');
		$cmsabout->two_sub_section_three_link_one = $request->input('two_sub_section_three_link_one');
		$cmsabout->two_sub_section_three_link_two = $request->input('two_sub_section_three_link_two');
		$cmsabout->two_sub_section_four_heading = $request->input('two_sub_section_four_heading');
		$cmsabout->two_sub_section_four_description = $request->input('two_sub_section_four_description');
		$cmsabout->two_sub_section_four_link_one = $request->input('two_sub_section_four_link_one');
		$cmsabout->two_sub_section_four_link_two = $request->input('two_sub_section_four_link_two');
		$cmsabout->two_sub_section_five_heading = $request->input('two_sub_section_five_heading');
		$cmsabout->two_sub_section_five_description = $request->input('two_sub_section_five_description');
		$cmsabout->two_sub_section_five_link_one = $request->input('two_sub_section_five_link_one');
		$cmsabout->two_sub_section_five_link_two = $request->input('two_sub_section_five_link_two');
		$cmsabout->section_one_image = $request->input('section_one_image');
		$cmsabout->two_sub_section_one_image = $request->input('two_sub_section_one_image');
		$cmsabout->two_sub_section_two_image = $request->input('two_sub_section_two_image');
		$cmsabout->two_sub_section_three_image = $request->input('two_sub_section_three_image');
		$cmsabout->two_sub_section_four_image = $request->input('two_sub_section_four_image');
		$cmsabout->two_sub_section_five_image = $request->input('two_sub_section_five_image');
		$cmsabout->two_sub_section_one_title = $request->input('two_sub_section_one_title');
		$cmsabout->two_sub_section_two_title = $request->input('two_sub_section_two_title');
		$cmsabout->two_sub_section_three_title = $request->input('two_sub_section_three_title');
		$cmsabout->two_sub_section_four_title = $request->input('two_sub_section_four_title');
		$cmsabout->two_sub_section_five_title = $request->input('two_sub_section_five_title');
        $cmsabout->save();

        return to_route('cmsabouts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cmsabout = CmsAbout::findOrFail($id);
        $cmsabout->delete();

        return to_route('cmsabouts.index');
    }
}
