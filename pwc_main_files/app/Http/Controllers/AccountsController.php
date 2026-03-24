<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Account;
use App\Http\Requests\AccountRequest;
use Spatie\Permission\Models\Permission;

class AccountsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:accounts-list|accounts-create|accounts-edit|accounts-delete', ['only' => ['index','store']]);
         $this->middleware('permission:accounts-create', ['only' => ['create','store']]);
         $this->middleware('permission:accounts-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:accounts-delete', ['only' => ['destroy']]);
         $this->middleware('permission:accounts-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $accounts= Account::all();
        return view('accounts.index', ['accounts'=>$accounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AccountRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccountRequest $request)
    {
        $account = new Account;
		$account->title = $request->input('title');
		$account->image = $request->input('image');
		$account->ledger = $request->input('ledger');
		$account->checkbox = $request->input('checkbox');
		$account->select = $request->input('select');
		$account->desc = $request->input('desc');
		$account->user_id = $request->input('user_id');
        $account->save();

        return to_route('accounts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.show',['account'=>$account]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.edit',['account'=>$account]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AccountRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccountRequest $request, $id)
    {
        $account = Account::findOrFail($id);
		$account->title = $request->input('title');
		$account->image = $request->input('image');
		$account->ledger = $request->input('ledger');
		$account->checkbox = $request->input('checkbox');
		$account->select = $request->input('select');
		$account->desc = $request->input('desc');
		$account->user_id = $request->input('user_id');
        $account->save();

        return to_route('accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return to_route('accounts.index');
    }
}
