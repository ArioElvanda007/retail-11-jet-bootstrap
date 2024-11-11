<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_module_load;');
        DB::unprepared("CREATE PROCEDURE sp_module_load (IN typeData VARCHAR(25), IN parameter INT)
        BEGIN    
            IF typeData = 'create' 
            THEN
                SELECT 
                    E.id AS permission_id, E.name AS permission_name, G.id AS module_id, IFNULL(G.name, '') AS module_name, 
                    CASE WHEN E.name = 'manage report' OR E.name = 'manage dashboard' OR G.id IS NULL THEN 1 ELSE 0 END access_lock,
                    0 AS can_create, 0 AS can_update, 0 AS can_delete
                FROM 
                    roles AS C
                LEFT OUTER JOIN
                    role_has_permissions AS D ON C.id = D.role_id
                LEFT OUTER JOIN
                    permissions AS E ON D.permission_id = E.id
                LEFT OUTER JOIN
                    permission_has_modules AS F ON E.id = F.permission_id
                LEFT OUTER JOIN
                    modules AS G ON F.module_id = G.id
                WHERE C.id IN (SELECT id FROM roles WHERE id IN (parameter))
                GROUP BY E.id, G.id;
            END IF;  







            IF typeData = 'edit'
            THEN
                DROP TEMPORARY TABLE IF EXISTS tempUsers;
                CREATE TEMPORARY TABLE tempUsers
                SELECT 
                    A.id, B.role_id, B.permission_id, B.module_id, B.can_create, B.can_update, B.can_delete, C.name
                FROM 
                    users AS A
                LEFT OUTER JOIN
                    access AS B ON A.id = B.user_id
                LEFT OUTER JOIN
                    roles AS C ON B.role_id = C.id
                WHERE A.id = parameter;





                SELECT 
                    E.id AS permission_id, E.name AS permission_name, G.id AS module_id, IFNULL(G.name, '') AS module_name, 
                    CASE WHEN E.name = 'manage report' OR E.name = 'manage dashboard' OR G.id IS NULL THEN 1 ELSE 0 END access_lock,      
                    CASE WHEN H.can_create IS NULL THEN 0 ELSE H.can_create END can_create,
                    CASE WHEN H.can_update IS NULL THEN 0 ELSE H.can_update END can_update,
                    CASE WHEN H.can_delete IS NULL THEN 0 ELSE H.can_delete END can_delete
                FROM 
                    roles AS C
                LEFT OUTER JOIN
                    role_has_permissions AS D ON C.id = D.role_id
                LEFT OUTER JOIN
                    permissions AS E ON D.permission_id = E.id
                LEFT OUTER JOIN
                    permission_has_modules AS F ON E.id = F.permission_id
                LEFT OUTER JOIN
                    modules AS G ON F.module_id = G.id
                LEFT OUTER JOIN
                    tempUsers AS H ON G.id = H.module_id
                WHERE C.id IN (SELECT role_id FROM tempUsers GROUP BY role_id)
                GROUP BY E.id, G.id, E.name, G.name;
            END IF;        
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_module_load');
    }
};
