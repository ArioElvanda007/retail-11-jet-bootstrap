<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\AccessSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('access', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('role_id');
            $table->bigInteger('permission_id');
            $table->bigInteger('module_id');
            $table->tinyInteger('can_create')->default(1);
            $table->tinyInteger('can_update')->default(1);
            $table->tinyInteger('can_delete')->default(1);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => AccessSeeder::class,
        ]);        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access');
    }
};
