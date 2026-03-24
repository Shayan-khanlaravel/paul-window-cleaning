<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ContactSiding;
use App\Http\Requests\ContactSidingRequest;
use Spatie\Permission\Models\Permission;

class ContactSidingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:contactsidings-list|contactsidings-create|contactsidings-edit|contactsidings-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:contactsidings-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:contactsidings-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:contactsidings-delete', ['only' => ['destroy']]);
        $this->middleware('permission:contactsidings-list', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $contactsidings = ContactSiding::all();
        return view('contactsidings.index', ['contactsidings' => $contactsidings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('contactsidings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactSidingRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactSidingRequest $request)
    {
        $contactsiding = new ContactSiding;
        $contactsiding->contact_id = $request->input('contact_id');
        $contactsiding->type = $request->input('type');
        $contactsiding->save();

        return to_route('contactsidings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $contactsiding = ContactSiding::findOrFail($id);
        return view('contactsidings.show', ['contactsiding' => $contactsiding]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $contactsiding = ContactSiding::findOrFail($id);
        return view('contactsidings.edit', ['contactsiding' => $contactsiding]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContactSidingRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContactSidingRequest $request, $id)
    {
        $contactsiding = ContactSiding::findOrFail($id);
        $contactsiding->contact_id = $request->input('contact_id');
        $contactsiding->type = $request->input('type');
        $contactsiding->save();

        return to_route('contactsidings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $contactsiding = ContactSiding::findOrFail($id);
        $contactsiding->delete();

        return to_route('contactsidings.index');
    }
}
