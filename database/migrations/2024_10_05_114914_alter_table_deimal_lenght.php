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
        Schema::table('buying', function (Blueprint $table) {
            $table->decimal('rate', 18, 4)->default(0)->change();
            $table->decimal('subtotal', 18, 4)->default(0)->change();
            $table->decimal('discount', 18, 4)->default(0)->change();
            $table->decimal('pay', 18, 4)->default(0)->change();
        }); 
        
        Schema::table('buying_details', function (Blueprint $table) {
            $table->decimal('rate', 18, 4)->default(0)->change();
            $table->decimal('amount', 18, 4)->default(0)->change();
            $table->decimal('discount', 18, 4)->default(0)->change();
        }); 
        
        Schema::table('cashflows', function (Blueprint $table) {
            $table->decimal('debet', 18, 4)->default(0)->change();
            $table->decimal('credit', 18, 4)->default(0)->change();
        });         

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_buy', 18, 4)->default(0)->change();
            $table->decimal('price_sell', 18, 4)->default(0)->change();
        });     
        



        Schema::table('selling', function (Blueprint $table) {
            $table->decimal('rate', 18, 4)->default(0)->change();
            $table->decimal('subtotal', 18, 4)->default(0)->change();
            $table->decimal('discount', 18, 4)->default(0)->change();
            $table->decimal('pay', 18, 4)->default(0)->change();
        });     
        
        Schema::table('selling_details', function (Blueprint $table) {
            $table->decimal('rate', 18, 4)->default(0)->change();
            $table->decimal('amount', 18, 4)->default(0)->change();
            $table->decimal('discount', 18, 4)->default(0)->change();
        });



        Schema::table('stocks', function (Blueprint $table) {
            $table->decimal('stock', 18, 4)->default(0)->change();
            $table->decimal('rate', 18, 4)->default(0)->change();
            $table->decimal('adjust', 18, 4)->default(0)->change();
        });      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buying', function (Blueprint $table) {
            $table->decimal('rate', 8, 2)->default(0)->change();
            $table->decimal('subtotal', 8, 2)->default(0)->change();
            $table->decimal('discount', 8, 2)->default(0)->change();
            $table->decimal('pay', 8, 2)->default(0)->change();
        });          

        Schema::table('buying_details', function (Blueprint $table) {
            $table->decimal('rate', 8, 2)->default(0)->change();
            $table->decimal('amount', 8, 2)->default(0)->change();
            $table->decimal('discount', 8, 2)->default(0)->change();
        });    
        
        Schema::table('cashflows', function (Blueprint $table) {
            $table->decimal('debet', 8, 2)->default(0)->change();
            $table->decimal('credit', 8, 2)->default(0)->change();
        });  
        
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_buy', 8, 2)->default(0)->change();
            $table->decimal('price_sell', 8, 2)->default(0)->change();
        });    
        
        

        Schema::table('selling', function (Blueprint $table) {
            $table->decimal('rate', 8, 2)->default(0)->change();
            $table->decimal('subtotal', 8, 2)->default(0)->change();
            $table->decimal('discount', 8, 2)->default(0)->change();
            $table->decimal('pay', 8, 2)->default(0)->change();
        });     
        
        Schema::table('selling_details', function (Blueprint $table) {
            $table->decimal('rate', 8, 2)->default(0)->change();
            $table->decimal('amount', 8, 2)->default(0)->change();
            $table->decimal('discount', 8, 2)->default(0)->change();
        });   
        
        

        Schema::table('stocks', function (Blueprint $table) {
            $table->decimal('stock', 8, 2)->default(0)->change();
            $table->decimal('rate', 8, 2)->default(0)->change();
            $table->decimal('adjust', 8, 2)->default(0)->change();
        });        
    }
};
