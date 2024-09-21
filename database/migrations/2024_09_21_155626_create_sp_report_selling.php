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
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportSelling;');
        DB::unprepared("CREATE PROCEDURE spReportSelling (IN fromDate DATE)
        BEGIN    
            DECLARE toDate DATE;
            SET toDate = DATE_ADD(fromDate, INTERVAL 30 DAY);    

            SELECT 
                A.id, A.code, A.name,  
                SUM(CASE WHEN DATE(D.date_input) = DATE(fromDate) THEN D.rate ELSE 0 END) AS sell_date01,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN D.rate ELSE 0 END) AS sell_date02,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN D.rate ELSE 0 END) AS sell_date03,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN D.rate ELSE 0 END) AS sell_date04,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN D.rate ELSE 0 END) AS sell_date05,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN D.rate ELSE 0 END) AS sell_date06,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN D.rate ELSE 0 END) AS sell_date07,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN D.rate ELSE 0 END) AS sell_date08,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN D.rate ELSE 0 END) AS sell_date09,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN D.rate ELSE 0 END) AS sell_date10,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN D.rate ELSE 0 END) AS sell_date11,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN D.rate ELSE 0 END) AS sell_date12,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN D.rate ELSE 0 END) AS sell_date13,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN D.rate ELSE 0 END) AS sell_date14,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN D.rate ELSE 0 END) AS sell_date15,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN D.rate ELSE 0 END) AS sell_date16,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN D.rate ELSE 0 END) AS sell_date17,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN D.rate ELSE 0 END) AS sell_date18,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN D.rate ELSE 0 END) AS sell_date19,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN D.rate ELSE 0 END) AS sell_date20,       
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN D.rate ELSE 0 END) AS sell_date21,       
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN D.rate ELSE 0 END) AS sell_date22,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN D.rate ELSE 0 END) AS sell_date23,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN D.rate ELSE 0 END) AS sell_date24,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN D.rate ELSE 0 END) AS sell_date25,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN D.rate ELSE 0 END) AS sell_date26,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN D.rate ELSE 0 END) AS sell_date27,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN D.rate ELSE 0 END) AS sell_date28,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN D.rate ELSE 0 END) AS sell_date29,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN D.rate ELSE 0 END) AS sell_date30,
                SUM(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN D.rate ELSE 0 END) AS sell_date31
            FROM 
                products AS A
            LEFT OUTER JOIN
			(
				SELECT 
					C.prod_id, IFNULL(SUM(C.rate) * SUM(C.amount), 0) AS rate, B.date_input
				FROM 
					selling AS B
				INNER JOIN
					selling_details AS C ON B.id = C.selling_id WHERE B.date_input BETWEEN fromDate AND toDate 
					GROUP BY C.prod_id, B.date_input                
			) AS D ON A.id = D.prod_id
            GROUP BY A.id, A.code, A.name
            ;
        END");    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportSelling;');
    }
};
