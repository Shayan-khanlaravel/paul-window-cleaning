<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ContactCleaning;
use App\Http\Requests\ContactCleaningRequest;
use Spatie\Permission\Models\Permission;

class ContactCleaningsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:contactcleanings-list|contactcleanings-create|contactcleanings-edit|contactcleanings-delete', ['only' => ['index','store']]);
         $this->middleware('permission:contactcleanings-create', ['only' => ['create','store']]);
         $this->middleware('permission:contactcleanings-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:contactcleanings-delete', ['only' => ['destroy']]);
         $this->middleware('permission:contactcleanings-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $contactcleanings= ContactCleaning::all();
        return view('contactcleanings.index', ['contactcleanings'=>$contactcleanings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('contactcleanings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactCleaningRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactCleaningRequest $request)
    {
        $contactcleaning = new ContactCleaning;
		$contactcleaning->contact_id = $request->input('contact_id');
		$contactcleaning->cleaning_side = $request->input('cleaning_side');
        $contactcleaning->save();

        return to_route('contactcleanings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $contactcleaning = ContactCleaning::findOrFail($id);
        return view('contactcleanings.show',['contactcleaning'=>$contactcleaning]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $contactcleaning = ContactCleaning::findOrFail($id);
        return view('contactcleanings.edit',['contactcleaning'=>$contactcleaning]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContactCleaningRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContactCleaningRequest $request, $id)
    {
        $contactcleaning = ContactCleaning::findOrFail($id);
		$contactcleaning->contact_id = $request->input('contact_id');
		$contactcleaning->cleaning_side = $request->input('cleaning_side');
        $contactcleaning->save();

        return to_route('contactcleanings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $contactcleaning = ContactCleaning::findOrFail($id);
        $contactcleaning->delete();

        return to_route('contactcleanings.index');
    }
}
