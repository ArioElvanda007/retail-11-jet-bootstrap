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
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportCashflow;');
        DB::unprepared("CREATE PROCEDURE spReportCashflow (IN fromDate DATE)
        BEGIN    
            DECLARE toDate DATE;
            SET toDate = DATE_ADD(fromDate, INTERVAL 30 DAY);    

            SELECT 
                title,  
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 0 DAY)) THEN debet ELSE 0 END) AS debet_date01,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN debet ELSE 0 END) AS debet_date02,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN debet ELSE 0 END) AS debet_date03,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN debet ELSE 0 END) AS debet_date04,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN debet ELSE 0 END) AS debet_date05,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN debet ELSE 0 END) AS debet_date06,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN debet ELSE 0 END) AS debet_date07,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN debet ELSE 0 END) AS debet_date08,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN debet ELSE 0 END) AS debet_date09,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN debet ELSE 0 END) AS debet_date10,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN debet ELSE 0 END) AS debet_date11,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN debet ELSE 0 END) AS debet_date12,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN debet ELSE 0 END) AS debet_date13,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN debet ELSE 0 END) AS debet_date14,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN debet ELSE 0 END) AS debet_date15,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN debet ELSE 0 END) AS debet_date16,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN debet ELSE 0 END) AS debet_date17,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN debet ELSE 0 END) AS debet_date18,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN debet ELSE 0 END) AS debet_date19,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN debet ELSE 0 END) AS debet_date20,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN debet ELSE 0 END) AS debet_date21,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN debet ELSE 0 END) AS debet_date22,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN debet ELSE 0 END) AS debet_date23,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN debet ELSE 0 END) AS debet_date24,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN debet ELSE 0 END) AS debet_date25,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN debet ELSE 0 END) AS debet_date26,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN debet ELSE 0 END) AS debet_date27,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN debet ELSE 0 END) AS debet_date28,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN debet ELSE 0 END) AS debet_date29,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN debet ELSE 0 END) AS debet_date30,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN debet ELSE 0 END) AS debet_date31,

				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 0 DAY)) THEN credit ELSE 0 END) AS credit_date01,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN credit ELSE 0 END) AS credit_date02,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN credit ELSE 0 END) AS credit_date03,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN credit ELSE 0 END) AS credit_date04,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN credit ELSE 0 END) AS credit_date05,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN credit ELSE 0 END) AS credit_date06,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN credit ELSE 0 END) AS credit_date07,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN credit ELSE 0 END) AS credit_date08,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN credit ELSE 0 END) AS credit_date09,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN credit ELSE 0 END) AS credit_date10,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN credit ELSE 0 END) AS credit_date11,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN credit ELSE 0 END) AS credit_date12,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN credit ELSE 0 END) AS credit_date13,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN credit ELSE 0 END) AS credit_date14,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN credit ELSE 0 END) AS credit_date15,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN credit ELSE 0 END) AS credit_date16,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN credit ELSE 0 END) AS credit_date17,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN credit ELSE 0 END) AS credit_date18,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN credit ELSE 0 END) AS credit_date19,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN credit ELSE 0 END) AS credit_date20,
                SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN credit ELSE 0 END) AS credit_date21,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN credit ELSE 0 END) AS credit_date22,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN credit ELSE 0 END) AS credit_date23,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN credit ELSE 0 END) AS credit_date24,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN credit ELSE 0 END) AS credit_date25,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN credit ELSE 0 END) AS credit_date26,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN credit ELSE 0 END) AS credit_date27,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN credit ELSE 0 END) AS credit_date28,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN credit ELSE 0 END) AS credit_date29,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN credit ELSE 0 END) AS credit_date30,
				SUM(CASE WHEN DATE(date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN credit ELSE 0 END) AS credit_date31
            FROM 
                cashflows AS A
			WHERE date_input BETWEEN fromDate AND toDate 
            GROUP BY title
            ;
        END");    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportCashflow;');
    }
};
