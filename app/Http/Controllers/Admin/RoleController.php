<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Role_Has_Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.roles.index", 'name' => "Roles"]
        ];

        $query = Role::with(['role_has_permissions.permissions'])->get();
        return view('content.admin.roles.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.roles.index", 'name' => "Roles"], ['link' => "admin.roles.create", 'name' => "Create Role"]
        ];

        $permissions = Permission::orderBy('name')->get();
        return view('content.admin.roles.create', compact('permissions'), ['breadcrumbs' => $breadcrumbs]);            
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => Request::get('name'),
            'guard_name' => 'web',
        ]);

        if (Request::get('permissions')) {
            foreach (Request::get('permissions') as $key => $value) {
                Role_Has_Permission::create([
                    'permission_id' => $value,
                    'role_id' => $role->id,
                ]);
            }
        }

        return redirect()->route('admin.roles.index');         
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.roles.index", 'name' => "Roles"], ['link' => "admin/users/roles/$role->id", 'name' => "Edit"]
        ];

        $query = [
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('id'),
        ];
        $permissions = Permission::orderBy('name')->get();
        return view('content.admin.roles.edit', compact('query', 'permissions'), ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role->update(Request::only('name'));

        if (Request::get('permissions')) {
            // reset
            Role_Has_Permission::where('role_id', '=', $role->id)->delete();

            // re - insert
            foreach (Request::get('permissions') as $key => $value) {
                Role_Has_Permission::create([
                    'permission_id' => $value,
                    'role_id' => $role->id,
                ]);
            }
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->name == 'admin' || $role->name == 'user') {
            return redirect()->back();
        }

        $role->delete();

        return redirect()->route('admin.roles.index');        
    }
}
