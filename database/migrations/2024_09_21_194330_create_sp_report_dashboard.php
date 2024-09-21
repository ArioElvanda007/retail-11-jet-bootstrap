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
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportDashboard;');
        DB::unprepared("CREATE PROCEDURE spReportDashboard (IN fromDate DATE)
        BEGIN    
            DECLARE lastMonth DATE;
            DECLARE thisMonth DATE;
            DECLARE yesterdayDate DATE;
            DECLARE todayDate DATE;

            DECLARE lastMonthSales DECIMAL;
            DECLARE thisMonthSales DECIMAL;
            DECLARE yesterdayDateSales DECIMAL;
            DECLARE todayDateSales DECIMAL;
            
            SET lastMonth = DATE_ADD(DATE_FORMAT(fromDate ,'%Y-%m-01'), INTERVAL -1 DAY);    
            SET thisMonth = fromDate;    
            SET yesterdayDate = DATE_ADD(fromDate, INTERVAL -1 DAY);    
            SET todayDate = fromDate;    
                
            SET lastMonthSales = (SELECT IFNULL(SUM(subtotal - discount), 0) AS sales FROM selling WHERE MONTH(date_input) = MONTH(lastMonth) AND YEAR(date_input) = YEAR(lastMonth));
            SET thisMonthSales = (SELECT IFNULL(SUM(subtotal - discount), 0) AS sales FROM selling WHERE MONTH(date_input) = MONTH(thisMonth) AND YEAR(date_input) = YEAR(thisMonth));
            SET yesterdayDateSales = (SELECT IFNULL(SUM(subtotal - discount), 0) AS sales FROM selling WHERE DATE(date_input) = DATE(yesterdayDate));
            SET todayDateSales = (SELECT IFNULL(SUM(subtotal - discount), 0) AS sales FROM selling WHERE DATE(date_input) = DATE(todayDateSales));
            
            SELECT lastMonthSales AS lastMonthSales, thisMonthSales AS thisMonthSales, yesterdayDateSales AS yesterdayDateSales, todayDateSales AS todayDateSales;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportDashboard;');
    }
};
