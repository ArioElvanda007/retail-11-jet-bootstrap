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
        Schema::table('cashflows', function (Blueprint $table) {
            $table->bigInteger('account_id')->nullable()->after('date_input');
        }); 

        DB::update("UPDATE cashflows SET account_id = (SELECT id FROM accounts WHERE name = 'CASHFLOW');");
        DB::update("UPDATE cashflows SET account_id = (SELECT id FROM accounts WHERE name = 'MODAL') WHERE title = 'Modal Awal';");
        DB::update("UPDATE cashflows SET account_id = (SELECT id FROM accounts WHERE name = 'KEWAJIBAN') WHERE title = 'Cicilan Bank';");
        DB::update("UPDATE cashflows SET account_id = (SELECT id FROM accounts WHERE name = 'SAVING') WHERE title = 'Saving';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selling_details', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });
    }
};
