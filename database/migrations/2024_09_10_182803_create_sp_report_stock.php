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
            SET toDate = DATE_ADD(fromDate, INTERVAL 30 DAY);    

            DROP TEMPORARY TABLE IF EXISTS tempAdj;
            CREATE TEMPORARY TABLE tempAdj
			SELECT 
				prod_id, IFNULL(SUM(rate), 0) AS rate, date_input
			FROM 
				stocks
			WHERE date_input BETWEEN fromDate AND toDate 
			GROUP BY date_input, prod_id
            ;   


            DROP TEMPORARY TABLE IF EXISTS tempAdjBegin;
            CREATE TEMPORARY TABLE tempAdjBegin
			SELECT 
				prod_id, IFNULL(SUM(rate), 0) AS rate, date_input
			FROM 
				stocks
			WHERE date_input < fromDate 
			GROUP BY date_input, prod_id
            ;


            
            DROP TEMPORARY TABLE IF EXISTS tempBuy;
            CREATE TEMPORARY TABLE tempBuy
            SELECT 
                B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, A.date_input
            FROM 
                buying AS A
            INNER JOIN
                buying_details AS B ON A.id = B.buying_id WHERE A.date_input BETWEEN fromDate AND toDate 
                GROUP BY B.prod_id, A.date_input
            ;     
            
            
            DROP TEMPORARY TABLE IF EXISTS tempBuyBegin;
            CREATE TEMPORARY TABLE tempBuyBegin
            SELECT 
                B.prod_id, IFNULL(SUM(B.rate), 0) AS rate
            FROM 
                buying AS A
            INNER JOIN
                buying_details AS B ON A.id = B.buying_id WHERE A.date_input < fromDate
                GROUP BY B.prod_id
            ; 
                    
            DROP TEMPORARY TABLE IF EXISTS tempSell;
            CREATE TEMPORARY TABLE tempSell
            SELECT 
                B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, A.date_input
            FROM 
                selling AS A
            INNER JOIN
                selling_details AS B ON A.id = B.selling_id WHERE A.date_input BETWEEN fromDate AND toDate 
                GROUP BY B.prod_id, A.date_input
            ; 

            DROP TEMPORARY TABLE IF EXISTS tempSellBegin;
            CREATE TEMPORARY TABLE tempSellBegin
            SELECT 
                B.prod_id, IFNULL(SUM(B.rate), 0) AS rate
            FROM 
                selling AS A
            INNER JOIN
                selling_details AS B ON A.id = B.selling_id WHERE A.date_input < fromDate
                GROUP BY B.prod_id
            ;     
            
            SELECT 
                A.id, A.code, A.name,  
                ifnull(G.rate, 0) AS adj_date00,
                MAX(CASE WHEN DATE(B.date_input) = DATE(fromDate) THEN B.rate ELSE 0 END) AS adj_date01,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN B.rate ELSE 0 END) AS adj_date02,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN B.rate ELSE 0 END) AS adj_date03,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN B.rate ELSE 0 END) AS adj_date04,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN B.rate ELSE 0 END) AS adj_date05,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN B.rate ELSE 0 END) AS adj_date06,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN B.rate ELSE 0 END) AS adj_date07,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN B.rate ELSE 0 END) AS adj_date08,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN B.rate ELSE 0 END) AS adj_date09,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN B.rate ELSE 0 END) AS adj_date10,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN B.rate ELSE 0 END) AS adj_date11,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN B.rate ELSE 0 END) AS adj_date12,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN B.rate ELSE 0 END) AS adj_date13,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN B.rate ELSE 0 END) AS adj_date14,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN B.rate ELSE 0 END) AS adj_date15,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN B.rate ELSE 0 END) AS adj_date16,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN B.rate ELSE 0 END) AS adj_date17,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN B.rate ELSE 0 END) AS adj_date18,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN B.rate ELSE 0 END) AS adj_date19,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN B.rate ELSE 0 END) AS adj_date20,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN B.rate ELSE 0 END) AS adj_date21,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN B.rate ELSE 0 END) AS adj_date22,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN B.rate ELSE 0 END) AS adj_date23,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN B.rate ELSE 0 END) AS adj_date24,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN B.rate ELSE 0 END) AS adj_date25,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN B.rate ELSE 0 END) AS adj_date26,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN B.rate ELSE 0 END) AS adj_date27,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN B.rate ELSE 0 END) AS adj_date28,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN B.rate ELSE 0 END) AS adj_date29,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN B.rate ELSE 0 END) AS adj_date30,
                MAX(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN B.rate ELSE 0 END) AS adj_date31,

                ifnull(E.rate, 0) AS buy_date00,
                MAX(CASE WHEN DATE(C.date_input) = DATE(fromDate) THEN C.rate ELSE 0 END) AS buy_date01,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN C.rate ELSE 0 END) AS buy_date02,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN C.rate ELSE 0 END) AS buy_date03,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN C.rate ELSE 0 END) AS buy_date04,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN C.rate ELSE 0 END) AS buy_date05,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN C.rate ELSE 0 END) AS buy_date06,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN C.rate ELSE 0 END) AS buy_date07,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN C.rate ELSE 0 END) AS buy_date08,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN C.rate ELSE 0 END) AS buy_date09,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN C.rate ELSE 0 END) AS buy_date10,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN C.rate ELSE 0 END) AS buy_date11,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN C.rate ELSE 0 END) AS buy_date12,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN C.rate ELSE 0 END) AS buy_date13,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN C.rate ELSE 0 END) AS buy_date14,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN C.rate ELSE 0 END) AS buy_date15,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN C.rate ELSE 0 END) AS buy_date16,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN C.rate ELSE 0 END) AS buy_date17,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN C.rate ELSE 0 END) AS buy_date18,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN C.rate ELSE 0 END) AS buy_date19,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN C.rate ELSE 0 END) AS buy_date20,       
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN C.rate ELSE 0 END) AS buy_date21,       
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN C.rate ELSE 0 END) AS buy_date22,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN C.rate ELSE 0 END) AS buy_date23,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN C.rate ELSE 0 END) AS buy_date24,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN C.rate ELSE 0 END) AS buy_date25,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN C.rate ELSE 0 END) AS buy_date26,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN C.rate ELSE 0 END) AS buy_date27,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN C.rate ELSE 0 END) AS buy_date28,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN C.rate ELSE 0 END) AS buy_date29,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN C.rate ELSE 0 END) AS buy_date30,
                MAX(CASE WHEN DATE(C.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN C.rate ELSE 0 END) AS buy_date31,
                
                ifnull(F.rate, 0) AS sell_date00,
                MAX(CASE WHEN DATE(D.date_input) = DATE(fromDate) THEN D.rate ELSE 0 END) AS sell_date01,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN D.rate ELSE 0 END) AS sell_date02,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN D.rate ELSE 0 END) AS sell_date03,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN D.rate ELSE 0 END) AS sell_date04,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN D.rate ELSE 0 END) AS sell_date05,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN D.rate ELSE 0 END) AS sell_date06,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN D.rate ELSE 0 END) AS sell_date07,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN D.rate ELSE 0 END) AS sell_date08,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN D.rate ELSE 0 END) AS sell_date09,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN D.rate ELSE 0 END) AS sell_date10,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN D.rate ELSE 0 END) AS sell_date11,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN D.rate ELSE 0 END) AS sell_date12,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN D.rate ELSE 0 END) AS sell_date13,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN D.rate ELSE 0 END) AS sell_date14,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN D.rate ELSE 0 END) AS sell_date15,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN D.rate ELSE 0 END) AS sell_date16,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN D.rate ELSE 0 END) AS sell_date17,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN D.rate ELSE 0 END) AS sell_date18,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN D.rate ELSE 0 END) AS sell_date19,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN D.rate ELSE 0 END) AS sell_date20,       
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN D.rate ELSE 0 END) AS sell_date21,       
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN D.rate ELSE 0 END) AS sell_date22,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN D.rate ELSE 0 END) AS sell_date23,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN D.rate ELSE 0 END) AS sell_date24,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN D.rate ELSE 0 END) AS sell_date25,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN D.rate ELSE 0 END) AS sell_date26,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN D.rate ELSE 0 END) AS sell_date27,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN D.rate ELSE 0 END) AS sell_date28,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN D.rate ELSE 0 END) AS sell_date29,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN D.rate ELSE 0 END) AS sell_date30,
                MAX(CASE WHEN DATE(D.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN D.rate ELSE 0 END) AS sell_date31
                
            FROM 
                products AS A
            LEFT OUTER JOIN
                tempAdj AS B ON A.id = B.prod_id
            LEFT OUTER JOIN
                tempBuy AS C ON A.id = C.prod_id
            LEFT OUTER JOIN
                tempSell AS D ON A.id = D.prod_id
            LEFT OUTER JOIN
                tempBuyBegin AS E ON A.id = E.prod_id    
            LEFT OUTER JOIN
                tempSellBegin AS F ON A.id = F.prod_id   
            LEFT OUTER JOIN
				tempAdjBegin AS G ON A.id = G.prod_id
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
