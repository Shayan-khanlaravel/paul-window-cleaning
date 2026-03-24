<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Testimonial;
use App\Http\Requests\TestimonialRequest;
use Spatie\Permission\Models\Permission;

class TestimonialsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:testimonials-list|testimonials-create|testimonials-edit|testimonials-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:testimonials-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:testimonials-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:testimonials-delete', ['only' => ['destroy']]);
        $this->middleware('permission:testimonials-list', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('testimonials.index', ['testimonials' => $testimonials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TestimonialRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TestimonialRequest $request)
    {
        $testimonial = new Testimonial;
        $testimonial->name = $request->input('name');
        $testimonial->message = $request->input('message');
        $testimonial->save();

        return to_route('testimonials.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('testimonials.show', ['testimonial' => $testimonial]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('testimonials.edit', ['testimonial' => $testimonial]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TestimonialRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TestimonialRequest $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->name = $request->input('name');
        $testimonial->message = $request->input('message');
        $testimonial->save();

        return to_route('testimonials.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return to_route('testimonials.index');
    }

    /**
     * Remove multiple testimonials from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyBulk(\Illuminate\Http\Request $request)
    {
        $ids = $request->input('ids');

        if ($ids && is_array($ids)) {
            Testimonial::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected testimonials deleted successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No testimonials selected for deletion.'
        ], 400);
    }
}
