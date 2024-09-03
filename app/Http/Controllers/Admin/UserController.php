<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Model_Has_Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.users.index", 'name' => "Users"]
        ];

        $query = User::with(['roles'])->get();
        return view('content.admin.users.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.users.index", 'name' => "Users"], ['link' => "admin.users.create", 'name' => "Create User"]
        ];

        $roles = Role::orderBy('name')->get();
        return view('content.admin.users.create', compact('roles'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => Request::get('name'),
            'email' => Request::get('email'),
            'password' => Request::get('password'),
        ]);

        if (Request::get('roles')) {
            foreach (Request::get('roles') as $key => $value) {
                Model_Has_Role::create([
                    'role_id' => $value,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('admin.users.index');        
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
    public function edit(User $user)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.users.index", 'name' => "Users"], ['link' => "admin/users/edit/$user->id", 'name' => "Edit"]
        ];

        $query = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('id'),
        ];
        $roles = Role::orderBy('name')->get();
        return view('content.admin.users.edit', compact('query', 'roles'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {
        $user->update(Request::only('name', 'email'));

        if (Request::get('password')) {
            $user->update(['password' => Request::get('password')]);
        }

        if (Request::get('roles')) {
            // reset
            Model_Has_Role::where('model_id', '=', $user->id)->delete();

            // re - insert
            foreach (Request::get('roles') as $key => $value) {
                Model_Has_Role::create([
                    'role_id' => $value,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->name == 'Admin' || $user->name == 'admin') {
            return redirect()->back();
        }

        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
