<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ThemeController extends Controller{
    function __construct()
    {

    }
    public function dashboard(){
        //dd(auth()->user()->getAllPermissions());
    	return view('theme.index');
    }//end dashboard function.
    public function permissions(){
    	return view('theme.user-management.permissions');
    }//end permissions function.
    public function routes(){
        //dd(auth()->user()->getAllPermissions());
        return view('dashboard.admin.routes');
    }





}
