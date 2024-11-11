<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin role *********************
        $query = DB::select(
            "SELECT 
                A.id, A.name, C.id AS role_id, C.name AS role_name, E.id AS permission_id, E.name AS permission_name, G.id AS module_id, G.name AS module_name
            FROM 
                users AS A
            LEFT OUTER JOIN
                model_has_roles AS B ON A.id = B.model_id
            LEFT OUTER JOIN
                roles AS C ON B.role_id = C.id
            LEFT OUTER JOIN
                role_has_permissions AS D ON C.id = D.role_id
            LEFT OUTER JOIN
                permissions AS E ON D.permission_id = E.id
            LEFT OUTER JOIN
                permission_has_modules AS F ON E.id = F.permission_id
            LEFT OUTER JOIN
                modules AS G ON F.module_id = G.id
            GROUP BY A.id, C.id, E.id, G.id;"
        );

        foreach ($query as $key => $value) {
            if ($value->id != null && $value->role_id != null && $value->permission_id != null && $value->module_id != null) {
                DB::table('access')->insert([
                    'user_id' => $value->id,
                    'role_id' => $value->role_id,
                    'permission_id' => $value->permission_id,
                    'module_id' => $value->module_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);                
            }
        }           

        DB::update("UPDATE access SET can_update = 0, can_delete = 0 WHERE role_id = (SELECT id FROM roles WHERE name = 'user');");

        DB::update("UPDATE access SET can_create = 0, can_update = 0, can_delete = 0 WHERE permission_id IN (SELECT id FROM permissions WHERE name IN ('manage report', 'manage dashboard'));");
    }
}
