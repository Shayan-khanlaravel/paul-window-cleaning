<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;
use Illuminate\Support\Facades\Gate; // Import the Gate facade
    
class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        // ...
    }

    public function index(Request $request)
    {
        if (Gate::allows('role-list')) {
            $permissions = Permission::pluck('id', 'id')->all();
            $roles = Role::get();
            return view('theme.user-management.roles.list', compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function create(): View
    {
        if (Gate::allows('role-create')) {
            $permission = Permission::get();
            return view('theme.user-management.roles.create', compact('permission'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        if (Gate::allows('role-create')) {
            // Your existing store method logic
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    // ... other methods ...

    public function destroy($id): RedirectResponse
    {
        if (Gate::allows('role-delete')) {
            // Your existing destroy method logic
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}