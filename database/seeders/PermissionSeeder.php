<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create([
            'name' => 'manage dashboard',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage selling',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage buying',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage stock',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage accounting',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage hr',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'manage report',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);        
    }
}
