<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('selling', function (Blueprint $table) {
            $table->id();
            $table->string('code', 25);
            $table->string('title')->nullable();
            $table->datetime('date_input');
            $table->datetime('due_date');
            $table->decimal('rate')->default(0);
            $table->decimal('subtotal')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('pay')->default(0);
            $table->bigInteger('customer_id');
            $table->bigInteger('bank_id');
            $table->text('note')->nullable();
            $table->bigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('selling_details', function (Blueprint $table) {
            $table->bigInteger('selling_id');
            $table->bigInteger('prod_id');
            $table->decimal('rate')->default(1);
            $table->decimal('amount')->default(0);
            $table->decimal('discount')->default(0);
            $table->timestamps();
        });          
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selling');
        Schema::dropIfExists('selling_details');
    }
};
