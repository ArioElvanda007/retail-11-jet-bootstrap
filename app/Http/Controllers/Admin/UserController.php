<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Access;
use App\Models\User;
use App\Models\Model_Has_Role;
use App\Models\Role_Has_Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;

class UserController extends Controller
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
        if (app($this->can_access())->access('users')->access[0]->modules->is_active == 0 || app($this->can_access())->access('users')->access[0]->can_view == 0) {
            return abort(401);
        }

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
        if (app($this->can_access())->access('users')->access[0]->modules->is_active == 0 || app($this->can_access())->access('users')->access[0]->can_create == 0) {
            return abort(401);
        } 

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
        if (app($this->can_access())->access('users')->access[0]->modules->is_active == 0 || app($this->can_access())->access('users')->access[0]->can_create == 0) {
            return abort(401);
        }

        $validator = Validator::make(Request::all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.create')->withErrors($validator)->withInput();
        }

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
        else {
            $role = Role::where('name', '=', 'admin')->first();
            if ($role) {
                Model_Has_Role::create([
                    'role_id' => $role->id,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);
            }
        }        

        // set access
        foreach (Request::get('temps') as $key => $value) {
            $chk_view = 0;
            $chk_create = 0;
            $chk_update = 0;
            $chk_delete = 0;

            if (isset($value['can_view'])) { $chk_view = 1; } else { $chk_view = 0; }
            if (isset($value['can_create'])) { $chk_create = 1; } else { $chk_create = 0; }
            if (isset($value['can_update'])) { $chk_update = 1; } else { $chk_update = 0; }
            if (isset($value['can_delete'])) { $chk_delete = 1; } else { $chk_delete = 0; }

            if ($chk_view == 1 || $chk_create == 1 || $chk_update == 1 || $chk_delete == 1) {
                $role_has_permissions = Role_Has_Permission::where('permission_id', '=', $value['permission_id'])->get();
                foreach ($role_has_permissions as $key2 => $role_has_permission) {
                    foreach (Request::get('roles') as $key => $data_role) {
                        if ($data_role == $role_has_permission->role_id) {
                            Access::create([
                                'user_id' => $user->id,
                                'role_id' => $role_has_permission->role_id,
                                'permission_id' => $value['permission_id'],
                                'module_id' => $value['module_id'],
                                'can_view' => $chk_view,
                                'can_create' => $chk_create,
                                'can_update' => $chk_update,
                                'can_delete' => $chk_delete,
                            ]);            
                        }
                    }
                }
            }
        }

        if (Request::get('is_send') == 1) {
            // send mail
            event(new Registered($user));
        } else {
            $user->update(['email_verified_at' => Carbon::now()]);
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
        if (app($this->can_access())->access('users')->access[0]->modules->is_active == 0 || app($this->can_access())->access('users')->access[0]->can_update == 0) {
            return abort(401);
        } 

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
        $access = Access::where('user_id', '=', $user->id)->count();
        return view('content.admin.users.edit', compact('query', 'roles', 'access'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {
        if (app($this->can_access())->access('users')->access[0]->modules->is_active == 0 || app($this->can_access())->access('users')->access[0]->can_update == 0) {
            return abort(401);
        }

        $validator = Validator::make(Request::all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.edit', $user->id)->withErrors($validator)->withInput();
        }

        $user->update(Request::only('name', 'email'));

        if (Request::get('password')) {
            $user->update(['password' => Request::get('password')]);
        }

        // reset
        Model_Has_Role::where('model_id', '=', $user->id)->delete();

        // re - insert
        if (Request::get('roles')) {
            foreach (Request::get('roles') as $key => $value) {
                Model_Has_Role::create([
                    'role_id' => $value,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);
            }
        }
        else {
            $role = Role::where('name', '=', 'admin')->first();
            if ($role) {
                Model_Has_Role::create([
                    'role_id' => $role->id,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);
            }
        }  

        // set access
        Access::where('user_id', '=', $user->id)->delete();
        foreach (Request::get('temps') as $key => $value) {
            $chk_view = 0;
            $chk_create = 0;
            $chk_update = 0;
            $chk_delete = 0;

            if (isset($value['can_view'])) { $chk_view = 1; } else { $chk_view = 0; }
            if (isset($value['can_create'])) { $chk_create = 1; } else { $chk_create = 0; }
            if (isset($value['can_update'])) { $chk_update = 1; } else { $chk_update = 0; }
            if (isset($value['can_delete'])) { $chk_delete = 1; } else { $chk_delete = 0; }

            if ($chk_view == 1 || $chk_create == 1 || $chk_update == 1 || $chk_delete == 1) {
                $role_has_permissions = Role_Has_Permission::where('permission_id', '=', $value['permission_id'])->get();
                foreach ($role_has_permissions as $key2 => $role_has_permission) {
                    foreach (Request::get('roles') as $key => $data_role) {
                        if ($data_role == $role_has_permission->role_id) {
                            Access::create([
                                'user_id' => $user->id,
                                'role_id' => $role_has_permission->role_id,
                                'permission_id' => $value['permission_id'],
                                'module_id' => $value['module_id'],
                                'can_view' => $chk_view,
                                'can_create' => $chk_create,
                                'can_update' => $chk_update,
                                'can_delete' => $chk_delete,
                            ]);            
                        }
                    }
                }
            }
        }

        if (Request::get('is_send') == 1) {
            event(new Registered($user));
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (app($this->can_access())->access('users')->access[0]->modules->is_active == 0 || app($this->can_access())->access('users')->access[0]->can_delete == 0) {
            return abort(401);
        } 

        if ($user->name == 'Admin' || $user->name == 'admin') {
            return redirect()->back();
        }

        Access::where('user_id', '=', $user->id)->delete();
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    public function resend(User $user)
    {
        event(new Registered($user));
        return redirect()->route('admin.users.index')->with('message', 'resend success');;       
    }  
    
    public function verify(User $user)
    {
        if ($user->email_verified_at == null) {
            $user->update(['email_verified_at' => Carbon::now()]);
            return redirect()->route('admin.users.index')->with('message', 'verify success');;           
        }
        else
        {
            $user->update(['email_verified_at' => null]);
            return redirect()->route('admin.users.index')->with('message', 'unverify success');;           
        }
    }      
}
