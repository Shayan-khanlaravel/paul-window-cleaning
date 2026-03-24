<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Http\Requests\SettingRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:settings-list|settings-create|settings-edit|settings-delete', ['only' => ['index','store']]);
         $this->middleware('permission:settings-create', ['only' => ['create','store']]);
         $this->middleware('permission:settings-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:settings-delete', ['only' => ['destroy']]);
         $this->middleware('permission:settings-list', ['only' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $settings= Setting::all();
        return view('settings.index', ['settings'=>$settings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $timezones = timezone_identifiers_list();
        return view('settings.create', compact('timezones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SettingRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SettingRequest $request)
    {
        $requestData = $request->all();
            $requestData['favicon']=$this->storeImageToStorageFolder('AdminDashboard',$request->favicon)??"";                             
            $requestData['logo']=$this->storeImageToStorageFolder('AdminDashboard',$request->logo)??"";                                                          
            Setting::create($requestData);
            //cache()->forget('settings.timezone');

            return redirect()->route('settings.index')->with(['title'=>'Done','message'=>'Setting added successfully','type'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $setting = Setting::findOrFail($id);
        return view('settings.show',['setting'=>$setting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        $timezones = timezone_identifiers_list();
        return view('settings.edit',['setting'=>$setting,'timezones'=>$timezones]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SettingRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingRequest $request, $id)
    {
        $requestData = $request->all();
            $setting = Setting::findOrFail($id);
            $oldFavicon = $setting->favicon; 
            if ($request->hasFile('favicon')) {
                $requestData['favicon']=$this->storeImageToStorageFolder('AdminDashboard',$request->favicon)??"";            
                $this->deleteImage($oldFavicon)??"";
            }else{
                $requestData['favicon'] = $setting->favicon??"";
            }//end if else.     
            $oldLogo = $setting->logo; 
            if ($request->hasFile('logo')) {
                $requestData['logo']=$this->storeImageToStorageFolder('AdminDashboard',$request->logo)??"";            
                $this->deleteImage($oldLogo)??"";
            }else{
                $requestData['logo'] = $setting->logo??"";
            }     
        
            $setting->update($requestData);
            cache()->forget('settings.timezone');
            cache()->remember('settings.timezone', 60, function() use ($requestData) {
                return $requestData['timezone'] ?? config('app.timezone');
            });

            // Update the timezone for the current request
            Config::set('app.timezone', $requestData['timezone']);
        return redirect()->route('settings.index')->with(['title'=>'Done','message'=>'Setting Update successfully','type'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        return to_route('settings.index');
    }
}
