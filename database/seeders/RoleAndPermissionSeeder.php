<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('name', 'user')->first();
        $role->givePermissionTo('manage dashboard');
        $role->givePermissionTo('manage selling');
        $role->givePermissionTo('manage buying');
        $role->givePermissionTo('manage stock');
        $role->givePermissionTo('manage report');

        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo('manage dashboard');
        $role->givePermissionTo('manage selling');
        $role->givePermissionTo('manage buying');
        $role->givePermissionTo('manage stock');
        $role->givePermissionTo('manage accounting');
        $role->givePermissionTo('manage hr');
        $role->givePermissionTo('manage report');
        $role->givePermissionTo('admin');
    }
}
