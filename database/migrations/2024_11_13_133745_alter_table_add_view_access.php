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
        Schema::table('access', function (Blueprint $table) {
            $table->tinyInteger('can_view')->default(1)->after('module_id');
        }); 

        DB::update("UPDATE access SET can_view = 1;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('access', function (Blueprint $table) {
            $table->dropColumn('can_view');
        });
    }
};
