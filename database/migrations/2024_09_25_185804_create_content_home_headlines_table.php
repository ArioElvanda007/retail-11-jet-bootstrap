<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use illuminate\Support\Facades\Artisan;
use Database\Seeders\ContentPermissionSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_home_headlines', function (Blueprint $table) {
            $table->id();
            $table->integer('seq')->default(1);
            $table->binary('image')->nullable();
            $table->string('title', 50);
            $table->string('description', 300)->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => ContentPermissionSeeder::class,
        ]);        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_home_headlines');
    }
};
