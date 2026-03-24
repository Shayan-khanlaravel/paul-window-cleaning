<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CmsHome;
use App\Http\Requests\CmsHomeRequest;
use Spatie\Permission\Models\Permission;

class CmsHomesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cmshomes-list|cmshomes-create|cmshomes-edit|cmshomes-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cmshomes-create', ['only' => ['create','store']]);
         $this->middleware('permission:cmshomes-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cmshomes-delete', ['only' => ['destroy']]);
         $this->middleware('permission:cmshomes-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cmshomes= CmsHome::all();
        return view('cmshomes.index', ['cmshomes'=>$cmshomes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('cmshomes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CmsHomeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CmsHomeRequest $request)
    {
        $cmshome = new CmsHome;
		$cmshome->section_one_heading = $request->input('section_one_heading');
		$cmshome->section_one_description = $request->input('section_one_description');
		$cmshome->section_two_heading = $request->input('section_two_heading');
		$cmshome->two_sub_section_one_heading = $request->input('two_sub_section_one_heading');
		$cmshome->two_sub_section_one_title = $request->input('two_sub_section_one_title');
		$cmshome->two_sub_section_two_heading = $request->input('two_sub_section_two_heading');
		$cmshome->two_sub_section_two_title = $request->input('two_sub_section_two_title');
		$cmshome->section_three_heading = $request->input('section_three_heading');
		$cmshome->section_three_description = $request->input('section_three_description');
		$cmshome->three_sub_section_one_heading = $request->input('three_sub_section_one_heading');
		$cmshome->three_sub_section_one_description = $request->input('three_sub_section_one_description');
		$cmshome->three_sub_section_one_link = $request->input('three_sub_section_one_link');
		$cmshome->section_two_image_one = $request->input('section_two_image_one');
		$cmshome->section_two_image_two = $request->input('section_two_image_two');
		$cmshome->two_sub_section_one_icon = $request->input('two_sub_section_one_icon');
		$cmshome->two_sub_section_two_icon = $request->input('two_sub_section_two_icon');
		$cmshome->three_sub_section_one_image = $request->input('three_sub_section_one_image');
        $cmshome->save();

        return to_route('cmshomes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $cmshome = CmsHome::findOrFail($id);
        return view('cmshomes.show',['cmshome'=>$cmshome]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $cmshome = CmsHome::findOrFail($id);
        return view('cmshomes.edit',['cmshome'=>$cmshome]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CmsHomeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CmsHomeRequest $request, $id)
    {
        $cmshome = CmsHome::findOrFail($id);
		$cmshome->section_one_heading = $request->input('section_one_heading');
		$cmshome->section_one_description = $request->input('section_one_description');
		$cmshome->section_two_heading = $request->input('section_two_heading');
		$cmshome->two_sub_section_one_heading = $request->input('two_sub_section_one_heading');
		$cmshome->two_sub_section_one_title = $request->input('two_sub_section_one_title');
		$cmshome->two_sub_section_two_heading = $request->input('two_sub_section_two_heading');
		$cmshome->two_sub_section_two_title = $request->input('two_sub_section_two_title');
		$cmshome->section_three_heading = $request->input('section_three_heading');
		$cmshome->section_three_description = $request->input('section_three_description');
		$cmshome->three_sub_section_one_heading = $request->input('three_sub_section_one_heading');
		$cmshome->three_sub_section_one_description = $request->input('three_sub_section_one_description');
		$cmshome->three_sub_section_one_link = $request->input('three_sub_section_one_link');
		$cmshome->section_two_image_one = $request->input('section_two_image_one');
		$cmshome->section_two_image_two = $request->input('section_two_image_two');
		$cmshome->two_sub_section_one_icon = $request->input('two_sub_section_one_icon');
		$cmshome->two_sub_section_two_icon = $request->input('two_sub_section_two_icon');
		$cmshome->three_sub_section_one_image = $request->input('three_sub_section_one_image');
        $cmshome->save();

        return to_route('cmshomes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cmshome = CmsHome::findOrFail($id);
        $cmshome->delete();

        return to_route('cmshomes.index');
    }
}
