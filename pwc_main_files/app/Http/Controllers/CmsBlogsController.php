<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CmsBlog;
use App\Http\Requests\CmsBlogRequest;
use Spatie\Permission\Models\Permission;

class CmsBlogsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cmsblogs-list|cmsblogs-create|cmsblogs-edit|cmsblogs-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cmsblogs-create', ['only' => ['create','store']]);
         $this->middleware('permission:cmsblogs-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cmsblogs-delete', ['only' => ['destroy']]);
         $this->middleware('permission:cmsblogs-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cmsblogs= CmsBlog::all();
        return view('cmsblogs.index', ['cmsblogs'=>$cmsblogs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('cmsblogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CmsBlogRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CmsBlogRequest $request)
    {
        $cmsblog = new CmsBlog;
		$cmsblog->section_id = $request->input('section_id');
		$cmsblog->heading = $request->input('heading');
		$cmsblog->description = $request->input('description');
		$cmsblog->image = $request->input('image');
        $cmsblog->save();

        return to_route('cmsblogs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $cmsblog = CmsBlog::findOrFail($id);
        return view('cmsblogs.show',['cmsblog'=>$cmsblog]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $cmsblog = CmsBlog::findOrFail($id);
        return view('cmsblogs.edit',['cmsblog'=>$cmsblog]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CmsBlogRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CmsBlogRequest $request, $id)
    {
        $cmsblog = CmsBlog::findOrFail($id);
		$cmsblog->section_id = $request->input('section_id');
		$cmsblog->heading = $request->input('heading');
		$cmsblog->description = $request->input('description');
		$cmsblog->image = $request->input('image');
        $cmsblog->save();

        return to_route('cmsblogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cmsblog = CmsBlog::findOrFail($id);
        $cmsblog->delete();

        return to_route('cmsblogs.index');
    }
}
