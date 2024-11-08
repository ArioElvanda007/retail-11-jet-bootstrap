<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\ModuleSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('description')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('permission_has_modules', function (Blueprint $table) {
            $table->bigInteger('permission_id');
            $table->bigInteger('module_id');
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => ModuleSeeder::class,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
        Schema::dropIfExists('permission_has_modules');
    }
};
