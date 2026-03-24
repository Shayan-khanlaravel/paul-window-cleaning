<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crud;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\AllPermission;
use Illuminate\Support\Str;
use Artisan;
use Auth;
use Illuminate\Support\Facades\View;
class CrudGeneratorController extends Controller{
	function __construct()
	{
		$this->middleware('permission:crud-list|crud-create', ['only' => ['crudGenerator','crudGeneratorProcess']]);
         $this->middleware('permission:crud-create', ['only' => ['crudGeneratorProcess']]);

	}
	public function crudGenerator(){
		return view('theme.crud-generator.generator');
    }//end crudGenerator function.
    public function crudGeneratorProcess(Request $request){
    	// return base_path();
    	extract($request->all());
    	// return $request->all();
    	if(! defined('STDIN')) define('STDIN', fopen("php://stdin","r"));
    	$crudName = $model_name;
    	if (Crud::where('name',$crudName)->count()>0) {
    		return redirect()->back()->with(['title'=>'Warning','message'=>$crudName .' already exists, try again with other name','type'=>'warning']);;    		
    	}else{
    		try {
    			$columns = "";
    			foreach ($column_name as $key => $value) {
    				$columns.=$value.":".$data_type[$key].":".$input_type[$key].":".$is_required[$key].",";
		    	}//end foreach.
		    	$columns = rtrim($columns,',');
		    	$result = Artisan::call('make:crud', ['crud_name' => $crudName,'columns' => $columns]);
		    	Artisan::call("migrate");
		    	Crud::create(['name'=>$crudName,'url'=>Str::plural(strtolower($crudName))]);
		    	$permissionsToInsert = [
		    		['name' => Str::plural(strtolower($crudName)).'-list', 'guard_name' => 'web'],
		    		['name' => Str::plural(strtolower($crudName)).'-create', 'guard_name' => 'web'],
		    		['name' => Str::plural(strtolower($crudName)).'-edit', 'guard_name' => 'web'],
		    		['name' => Str::plural(strtolower($crudName)).'-delete', 'guard_name' => 'web']
		    	];
		    	Permission::insert($permissionsToInsert);
		    	// $permissionNames = array_column($permissionsToInsert, 'name');
		    	// $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id')->toArray();
		    	// $admin_role = Role::findByName('developer', 'web');
		    	// foreach ($permissionIds as $permissionId) {
		    	// 	$permission = Permission::findById($permissionId);
		    	// 	$admin_role->givePermissionTo($permission);
		    	// }
		    	// $admin_role->givePermissionTo($permissionIds);
		    	return redirect()->back()->with(['title'=>'Done','message'=>$crudName.' Created successfully.','type'=>'success']);
		    } catch (\Exception $e) {
		    	return $e->getMessage();
		    	return redirect()->back()->with(['title'=>'OOPS','message'=>'Unable to create `'.$crudName .'` , try again','type'=>'error']);    		
	    	}//end try catch.


    	}//end if else

    }//end crudGeneratorProcess function.
}//end class.
