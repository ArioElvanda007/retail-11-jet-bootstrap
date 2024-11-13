<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Permission;
use App\Models\Permission_Has_Module;
use App\Models\Module;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    private function can_access()
    {
        return "App\Http\Controllers\Function\GlobalController";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (app($this->can_access())->access('permissions')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.permissions.index", 'name' => "Permissions"]
        ];

        $query = Permission::with('permission_has_modules.modules')->get();
        return view('content.admin.permissions.index', compact('query'), ['breadcrumbs' => $breadcrumbs]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (app($this->can_access())->access('permissions')->access[0]->can_create == 0) {
            return abort(401);
        } 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (app($this->can_access())->access('permissions')->access[0]->can_create == 0) {
            return abort(401);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        if (app($this->can_access())->access('permissions')->access[0]->can_update == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.permissions.index", 'name' => "Permissions"], ['link' => "admin/permissions/edit/$permission->id", 'name' => "Edit Permission"]
        ];

        $query = [
            'id' => $permission->id,
            'name' => $permission->name,
            'modules' => $permission->permission_has_modules->pluck('module_id'),
        ];
        
        $modules = DB::select("
            SELECT 
                A.id, A.name, A.is_active, B.module_id
            FROM 
                modules AS A
            LEFT OUTER JOIN
                permission_has_modules AS B ON A.id = B.module_id
            WHERE B.module_id IS NULL
            UNION ALL
            SELECT 
                A.id, A.name, A.is_active, B.module_id
            FROM 
                modules AS A
            LEFT OUTER JOIN
                permission_has_modules AS B ON A.id = B.module_id
            WHERE B.permission_id = $permission->id            
            ;        
        ");

        // $modules = Module::orderBy('name')->get();
        return view('content.admin.permissions.edit', compact('query', 'modules'), ['breadcrumbs' => $breadcrumbs]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Permission $permission, Request $request)
    {
        if (app($this->can_access())->access('permissions')->access[0]->can_update == 0) {
            return abort(401);
        } 

        Permission_Has_Module::where('permission_id', '=', $permission->id)->delete();
        if (Request::get('modules')) {
            foreach (Request::get('modules') as $key => $value) {
                Permission_Has_Module::create([
                    'permission_id' => $permission->id,
                    'module_id' => $value,
                ]);        
            }            
        }

        return redirect()->route('admin.permissions.index');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (app($this->can_access())->access('permissions')->access[0]->can_delete == 0) {
            return abort(401);
        }
    }
}
