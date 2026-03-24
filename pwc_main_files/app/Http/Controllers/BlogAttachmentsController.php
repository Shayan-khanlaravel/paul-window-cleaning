<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\BlogAttachment;
use App\Http\Requests\BlogAttachmentRequest;
use Spatie\Permission\Models\Permission;

class BlogAttachmentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:blogattachments-list|blogattachments-create|blogattachments-edit|blogattachments-delete', ['only' => ['index','store']]);
         $this->middleware('permission:blogattachments-create', ['only' => ['create','store']]);
         $this->middleware('permission:blogattachments-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:blogattachments-delete', ['only' => ['destroy']]);
         $this->middleware('permission:blogattachments-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $blogattachments= BlogAttachment::all();
        return view('blogattachments.index', ['blogattachments'=>$blogattachments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('blogattachments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlogAttachmentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogAttachmentRequest $request)
    {
        $blogattachment = new BlogAttachment;
		$blogattachment->blog_id = $request->input('blog_id');
		$blogattachment->image = $request->input('image');
        $blogattachment->save();

        return to_route('blogattachments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $blogattachment = BlogAttachment::findOrFail($id);
        return view('blogattachments.show',['blogattachment'=>$blogattachment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $blogattachment = BlogAttachment::findOrFail($id);
        return view('blogattachments.edit',['blogattachment'=>$blogattachment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogAttachmentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogAttachmentRequest $request, $id)
    {
        $blogattachment = BlogAttachment::findOrFail($id);
		$blogattachment->blog_id = $request->input('blog_id');
		$blogattachment->image = $request->input('image');
        $blogattachment->save();

        return to_route('blogattachments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $blogattachment = BlogAttachment::findOrFail($id);
        $blogattachment->delete();

        return to_route('blogattachments.index');
    }
}
