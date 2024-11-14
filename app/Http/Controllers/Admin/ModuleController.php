<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Module;

class ModuleController extends Controller
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
        if (app($this->can_access())->access('modules')->access->count() == 0 || app($this->can_access())->access('modules')->access[0]->modules->is_active == 0 || app($this->can_access())->access('modules')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.modules.index", 'name' => "Menus"]
        ];

        $query = Module::get();
        return view('content.admin.modules.index', compact('query'), ['breadcrumbs' => $breadcrumbs]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (app($this->can_access())->access('modules')->access->count() == 0 || app($this->can_access())->access('modules')->access[0]->modules->is_active == 0 || app($this->can_access())->access('modules')->access[0]->can_create == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.modules.index", 'name' => "Menus"], ['link' => "admin.modules.create", 'name' => "Create Menu"]
        ];

        return view('content.admin.modules.create', ['breadcrumbs' => $breadcrumbs]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (app($this->can_access())->access('modules')->access->count() == 0 || app($this->can_access())->access('modules')->access[0]->modules->is_active == 0 || app($this->can_access())->access('modules')->access[0]->can_create == 0) {
            return abort(401);
        } 

        Module::create([
            'name' => Request::get('name'),
            'description' => Request::get('description'),
            'is_active' => Request::get('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.modules.index');  
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
    public function edit(Module $module)
    {
        if (app($this->can_access())->access('modules')->access->count() == 0 || app($this->can_access())->access('modules')->access[0]->modules->is_active == 0 || app($this->can_access())->access('modules')->access[0]->can_update == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.modules.index", 'name' => "Menus"], ['link' => "admin/modules/edit/$module->id", 'name' => "Edit Menu"]
        ];

        $query = [
            'id' => $module->id,
            'name' => $module->name,
            'description' => $module->description,
            'is_active' => $module->is_active,
        ];
        return view('content.admin.modules.edit', compact('query'), ['breadcrumbs' => $breadcrumbs]);  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Module $module, Request $request)
    {
        if (app($this->can_access())->access('modules')->access->count() == 0 || app($this->can_access())->access('modules')->access[0]->modules->is_active == 0 || app($this->can_access())->access('modules')->access[0]->can_update == 0) {
            return abort(401);
        } 

        $module->update([
            'name' => Request::get('name'),
            'description' => Request::get('description'),
            'is_active' => Request::get('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.modules.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        if (app($this->can_access())->access('modules')->access->count() == 0 || app($this->can_access())->access('modules')->access[0]->modules->is_active == 0 || app($this->can_access())->access('modules')->access[0]->can_delete == 0) {
            return abort(401);
        } 

        $module->delete();

        return redirect()->route('admin.modules.index');  
    }
}
