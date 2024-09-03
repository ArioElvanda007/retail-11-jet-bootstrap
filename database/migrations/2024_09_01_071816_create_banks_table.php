<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\BankSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('account_number', 25);
            $table->string('account_name', 30);
            $table->string('branch_office', 50);
            $table->string('behalf_of', 30);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => BankSeeder::class,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
