<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\AccountSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('seq')->default(0);
            $table->string('code', 25);
            $table->string('name', 25);
            $table->string('position', 6)->nullable(); //DEBET or CREDIT
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => AccountSeeder::class,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
