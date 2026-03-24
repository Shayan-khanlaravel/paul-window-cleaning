<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ContactsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:contacts-list|contacts-create|contacts-edit|contacts-delete', ['only' => ['index','store']]);
         $this->middleware('permission:contacts-create', ['only' => ['create','store']]);
         $this->middleware('permission:contacts-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:contacts-delete', ['only' => ['destroy']]);
         $this->middleware('permission:contacts-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {

        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view('contacts.index', ['contacts'=>$contacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactRequest $request)
    {
        $contact = new Contact;
		$contact->name = $request->input('name');
		$contact->email = $request->input('email');
		$contact->phone = $request->input('phone');
		$contact->subject = $request->input('subject');
		$contact->property_status = $request->input('property_status');
		$contact->address = $request->input('address');
		$contact->street_number = $request->input('street_number');
		$contact->city = $request->input('city');
		$contact->zip_code = $request->input('zip_code');
		$contact->message = $request->input('message');
        $contact->save();

        return to_route('contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show',['contact'=>$contact]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit',['contact'=>$contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContactRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
		$contact->name = $request->input('name');
		$contact->email = $request->input('email');
		$contact->phone = $request->input('phone');
		$contact->subject = $request->input('subject');
		$contact->property_status = $request->input('property_status');
		$contact->address = $request->input('address');
		$contact->street_number = $request->input('street_number');
		$contact->city = $request->input('city');
		$contact->zip_code = $request->input('zip_code');
		$contact->message = $request->input('message');
        $contact->save();

        return to_route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return to_route('contacts.index');
    }
    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids && is_array($ids)) {
            Contact::whereIn('id', $ids)->delete();

            return redirect()->route('contacts.index')->with(['title' => 'Done', 'message' => 'Selected Quote Deleted Successfully.', 'type' => 'success',]);

        }

        return back()->with('error', 'No contacts selected for deletion.');
    }


}
