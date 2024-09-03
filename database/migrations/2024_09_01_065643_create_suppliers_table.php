<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\SupplierSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('address', 100)->nullable();
            $table->string('email', 30)->nullable();
            $table->string('telephone', 25);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        
        Artisan::call('db:seed', [
            '--class' => SupplierSeeder::class,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
