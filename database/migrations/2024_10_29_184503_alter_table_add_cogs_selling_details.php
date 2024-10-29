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
        Schema::table('selling_details', function (Blueprint $table) {
            $table->decimal('cogs', 18, 4)->default(0)->after('prod_id');
        }); 

        DB::update('
            UPDATE 
                selling_details AS D 
            INNER JOIN
            (
                SELECT 
                    A.selling_id, B.id, B.price_buy
                FROM 
                    selling_details AS A
                LEFT OUTER JOIN
                    products AS B ON A.prod_id = B.id
            ) AS C ON C.selling_id = D.selling_id
            SET D.cogs = C.price_buy
            ;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selling_details', function (Blueprint $table) {
            $table->dropColumn('cogs');
        });
    }
};
