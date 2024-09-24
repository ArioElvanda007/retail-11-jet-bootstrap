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
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportStock;');
        DB::unprepared("CREATE PROCEDURE spReportStock (IN fromDate DATE)
        BEGIN    
            DECLARE toDate DATE;
            DECLARE beginingDate DATE;
            
            SET toDate = DATE_ADD(fromDate, INTERVAL 30 DAY);    
            SET beginingDate = DATE_ADD(fromDate, INTERVAL -1 DAY);
            
            DROP TEMPORARY TABLE IF EXISTS tempAdj;
            CREATE TEMPORARY TABLE tempAdj
			SELECT 
				prod_id, IFNULL(SUM(rate), 0) AS rate, beginingDate AS date_input, 'ADJ' AS type, 'BEGIN' AS category
			FROM 
				stocks
			WHERE DATE(date_input) < DATE(fromDate) 
			GROUP BY prod_id
            UNION ALL
			SELECT 
				prod_id, IFNULL(SUM(rate), 0) AS rate, date_input, 'ADJ' AS type, 'DATA' AS category
			FROM 
				stocks
			WHERE DATE(date_input) BETWEEN DATE(fromDate) AND DATE(toDate) 
			GROUP BY date_input, prod_id
            ;   



		

            
            DROP TEMPORARY TABLE IF EXISTS tempBuy;
            CREATE TEMPORARY TABLE tempBuy
			SELECT 
				B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, beginingDate AS date_input, 'BUY' AS type, 'BEGIN' AS category
			FROM 
				buying AS A
			INNER JOIN
				buying_details AS B ON A.id = B.buying_id WHERE DATE(A.date_input) < DATE(fromDate)
				GROUP BY B.prod_id
			UNION ALL
			SELECT 
				B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, A.date_input, 'BUY' AS type, 'DATA' AS category
			FROM 
				buying AS A
			INNER JOIN
				buying_details AS B ON A.id = B.buying_id WHERE DATE(A.date_input) BETWEEN DATE(fromDate) AND DATE(toDate) 
				GROUP BY B.prod_id, A.date_input

            ;     
            
            
            
            
            
            
            
            DROP TEMPORARY TABLE IF EXISTS tempSell;
            CREATE TEMPORARY TABLE tempSell
            SELECT 
                B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, beginingDate AS date_input, 'SELL' AS type, 'BEGIN' AS category
            FROM 
                selling AS A
            INNER JOIN
                selling_details AS B ON A.id = B.selling_id WHERE DATE(A.date_input) < DATE(fromDate)
                GROUP BY B.prod_id
			UNION ALL
            SELECT 
                B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, A.date_input, 'SELL' AS type, 'DATA' AS category
            FROM 
                selling AS A
            INNER JOIN
                selling_details AS B ON A.id = B.selling_id WHERE DATE(A.date_input) BETWEEN DATE(fromDate) AND DATE(toDate) 
                GROUP BY B.prod_id, A.date_input
            ; 

            
            
            
            
            
            DROP TEMPORARY TABLE IF EXISTS tempResult;
            CREATE TEMPORARY TABLE tempResult            
            SELECT * FROM tempAdj
            UNION ALL
            SELECT * FROM tempBuy
            UNION ALL
            SELECT * FROM tempSell;
            
            
            
            
            
            
            
            
            
            
            
            SELECT 
				A.id, A.code, A.name,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'BEGIN' THEN B.rate ELSE 0 END) AS adj_date00,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 0 DAY)) THEN B.rate ELSE 0 END) AS adj_date01,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN B.rate ELSE 0 END) AS adj_date02,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN B.rate ELSE 0 END) AS adj_date03,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN B.rate ELSE 0 END) AS adj_date04,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN B.rate ELSE 0 END) AS adj_date05,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN B.rate ELSE 0 END) AS adj_date06,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN B.rate ELSE 0 END) AS adj_date07,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN B.rate ELSE 0 END) AS adj_date08,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN B.rate ELSE 0 END) AS adj_date09,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN B.rate ELSE 0 END) AS adj_date10,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN B.rate ELSE 0 END) AS adj_date11,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN B.rate ELSE 0 END) AS adj_date12,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN B.rate ELSE 0 END) AS adj_date13,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN B.rate ELSE 0 END) AS adj_date14,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN B.rate ELSE 0 END) AS adj_date15,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN B.rate ELSE 0 END) AS adj_date16,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN B.rate ELSE 0 END) AS adj_date17,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN B.rate ELSE 0 END) AS adj_date18,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN B.rate ELSE 0 END) AS adj_date19,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN B.rate ELSE 0 END) AS adj_date20,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN B.rate ELSE 0 END) AS adj_date21,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN B.rate ELSE 0 END) AS adj_date22,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN B.rate ELSE 0 END) AS adj_date23,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN B.rate ELSE 0 END) AS adj_date24,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN B.rate ELSE 0 END) AS adj_date25,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN B.rate ELSE 0 END) AS adj_date26,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN B.rate ELSE 0 END) AS adj_date27,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN B.rate ELSE 0 END) AS adj_date28,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN B.rate ELSE 0 END) AS adj_date29,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN B.rate ELSE 0 END) AS adj_date30,
				SUM(CASE WHEN B.type = 'ADJ' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN B.rate ELSE 0 END) AS adj_date31,
                
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'BEGIN' THEN B.rate ELSE 0 END) AS buy_date00,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 0 DAY)) THEN B.rate ELSE 0 END) AS buy_date01,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN B.rate ELSE 0 END) AS buy_date02,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN B.rate ELSE 0 END) AS buy_date03,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN B.rate ELSE 0 END) AS buy_date04,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN B.rate ELSE 0 END) AS buy_date05,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN B.rate ELSE 0 END) AS buy_date06,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN B.rate ELSE 0 END) AS buy_date07,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN B.rate ELSE 0 END) AS buy_date08,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN B.rate ELSE 0 END) AS buy_date09,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN B.rate ELSE 0 END) AS buy_date10,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN B.rate ELSE 0 END) AS buy_date11,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN B.rate ELSE 0 END) AS buy_date12,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN B.rate ELSE 0 END) AS buy_date13,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN B.rate ELSE 0 END) AS buy_date14,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN B.rate ELSE 0 END) AS buy_date15,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN B.rate ELSE 0 END) AS buy_date16,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN B.rate ELSE 0 END) AS buy_date17,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN B.rate ELSE 0 END) AS buy_date18,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN B.rate ELSE 0 END) AS buy_date19,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN B.rate ELSE 0 END) AS buy_date20,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN B.rate ELSE 0 END) AS buy_date21,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN B.rate ELSE 0 END) AS buy_date22,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN B.rate ELSE 0 END) AS buy_date23,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN B.rate ELSE 0 END) AS buy_date24,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN B.rate ELSE 0 END) AS buy_date25,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN B.rate ELSE 0 END) AS buy_date26,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN B.rate ELSE 0 END) AS buy_date27,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN B.rate ELSE 0 END) AS buy_date28,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN B.rate ELSE 0 END) AS buy_date29,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN B.rate ELSE 0 END) AS buy_date30,
				SUM(CASE WHEN B.type = 'BUY' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN B.rate ELSE 0 END) AS buy_date31,
                
                
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'BEGIN' THEN B.rate ELSE 0 END) AS sell_date00,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 0 DAY)) THEN B.rate ELSE 0 END) AS sell_date01,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN B.rate ELSE 0 END) AS sell_date02,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN B.rate ELSE 0 END) AS sell_date03,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN B.rate ELSE 0 END) AS sell_date04,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN B.rate ELSE 0 END) AS sell_date05,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN B.rate ELSE 0 END) AS sell_date06,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN B.rate ELSE 0 END) AS sell_date07,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN B.rate ELSE 0 END) AS sell_date08,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN B.rate ELSE 0 END) AS sell_date09,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN B.rate ELSE 0 END) AS sell_date10,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN B.rate ELSE 0 END) AS sell_date11,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN B.rate ELSE 0 END) AS sell_date12,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN B.rate ELSE 0 END) AS sell_date13,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN B.rate ELSE 0 END) AS sell_date14,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN B.rate ELSE 0 END) AS sell_date15,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN B.rate ELSE 0 END) AS sell_date16,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN B.rate ELSE 0 END) AS sell_date17,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN B.rate ELSE 0 END) AS sell_date18,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN B.rate ELSE 0 END) AS sell_date19,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN B.rate ELSE 0 END) AS sell_date20,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN B.rate ELSE 0 END) AS sell_date21,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN B.rate ELSE 0 END) AS sell_date22,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN B.rate ELSE 0 END) AS sell_date23,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN B.rate ELSE 0 END) AS sell_date24,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN B.rate ELSE 0 END) AS sell_date25,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN B.rate ELSE 0 END) AS sell_date26,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN B.rate ELSE 0 END) AS sell_date27,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN B.rate ELSE 0 END) AS sell_date28,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN B.rate ELSE 0 END) AS sell_date29,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN B.rate ELSE 0 END) AS sell_date30,
				SUM(CASE WHEN B.type = 'SELL' AND B.category = 'DATA' AND DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN B.rate ELSE 0 END) AS sell_date31
            FROM
				products AS A
			LEFT OUTER JOIN
				tempResult AS B ON A.id = B.prod_id
			GROUP BY A.id, A.code, A.name
			;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportStock;');
    }
};
