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
        DB::unprepared('DROP PROCEDURE IF EXISTS spContentDashboard;');
        DB::unprepared("CREATE PROCEDURE spContentDashboard ()
        BEGIN    
            DECLARE fromDate DATE;
            SET fromDate = NOW();    
            
            SELECT * FROM content_home_headlines WHERE is_active = 1 ORDER BY seq;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spContentDashboard');
    }
};
