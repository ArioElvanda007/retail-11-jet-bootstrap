<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::where('name', '=', 'manage dashboard')->first();
        DB::table('modules')->insert([
            'name' => 'dashboard',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'dashboard')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);






        $permission = Permission::where('name', '=', 'manage selling')->first();
        DB::table('modules')->insert([
            'name' => 'customers',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'customers')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'selling',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'selling')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);







        $permission = Permission::where('name', '=', 'manage buying')->first();
        DB::table('modules')->insert([
            'name' => 'suppliers',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'suppliers')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'buying',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'buying')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);






        $permission = Permission::where('name', '=', 'manage stock')->first();
        DB::table('modules')->insert([
            'name' => 'products',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'products')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'adjustment',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'adjustment')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);







        $permission = Permission::where('name', '=', 'manage accounting')->first();
        DB::table('modules')->insert([
            'name' => 'accounts',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'accounts')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'banks',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'banks')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'cashflows',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'cashflows')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);







        $permission = Permission::where('name', '=', 'manage report')->first();
        DB::table('modules')->insert([
            'name' => 'report stocks',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'report stocks')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'report buying',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'report buying')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'report selling',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'report selling')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'report cashflows',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'report cashflows')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'report accounting',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'report accounting')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'report ledger',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'report ledger')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);







        $permission = Permission::where('name', '=', 'admin')->first();
        DB::table('modules')->insert([
            'name' => 'users',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'users')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'roles',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'roles')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'permissions',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'permissions')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'modules',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'modules')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'name' => 'business',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'business')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);







        $permission = Permission::where('name', '=', 'manage content')->first();
        DB::table('modules')->insert([
            'name' => 'headlines',
            'is_active' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $module = DB::table('modules')->where('name', '=', 'headlines')->first();
        DB::table('permission_has_modules')->insert([
            'permission_id' => $permission->id,
            'module_id' => $module->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
