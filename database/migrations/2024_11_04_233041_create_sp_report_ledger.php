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
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportLedger;');
        DB::unprepared("CREATE PROCEDURE spReportLedger (IN fromDate DATE, IN toDate DATE, IN opt integer)
        BEGIN    
            DROP TEMPORARY TABLE IF EXISTS tempAcc;
            CREATE TEMPORARY TABLE tempAcc
            SELECT 
                id, seq, code, name, description, position, 0 AS debet, 0 AS credit, 0 AS balance
            FROM 
                accounts
            ;

            -- from cashflows
            UPDATE tempAcc AS D
            LEFT OUTER JOIN
            (
                SELECT 
                    A.account_id, 
                    CASE
                        WHEN B.position = 'DEBET' THEN 
                            CASE
                                WHEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0) > 0 THEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0)
                                WHEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0) < 0 THEN (IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0)) * -1
                                ELSE 0
                            END
                        WHEN B.position = 'CREDIT' THEN 0
                        ELSE CASE
                            WHEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0) > 0 THEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0)
                            ELSE 0
                        END
                    END AS debet,
                    CASE
                        WHEN B.position = 'DEBET' THEN 0
                        WHEN B.position = 'CREDIT' THEN 
                            CASE
                                WHEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0) > 0 THEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0)
                                WHEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0) < 0 THEN (IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0)) * -1
                                ELSE 0
                            END        
                        ELSE CASE
                            WHEN IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0) < 0 THEN (IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0)) * -1
                            ELSE 0
                        END
                    END AS credit
                FROM 
                    cashflows AS A
                LEFT OUTER JOIN
                    tempAcc AS B ON A.account_id = B.id
                WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
                GROUP BY A.account_id	
            ) AS C ON D.id = C.account_id
            SET D.debet = C.debet, D.credit = C.credit
            ;




            -- from purchase
            UPDATE tempAcc SET debet = 
            (
                SELECT 
                    IFNULL(SUM((B.rate * B.amount) - B.discount), 0) AS amount
                FROM 
                    buying AS A
                INNER JOIN
                    buying_details AS B ON A.id = B.buying_id
                WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            ) WHERE name = 'PURCHASE' AND position = 'DEBET'
            ;

            UPDATE tempAcc SET credit = 
            (
                SELECT 
                    IFNULL(SUM((B.rate * B.amount) - B.discount), 0) AS amount
                FROM 
                    buying AS A
                INNER JOIN
                    buying_details AS B ON A.id = B.buying_id
                WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            ) WHERE name = 'PURCHASE' AND position = 'CREDIT'
            ;






            -- from sales
            UPDATE tempAcc SET debet = 
            (
                SELECT 
                    IFNULL(SUM((B.rate * B.amount) - B.discount), 0) AS amount
                FROM 
                    selling AS A
                INNER JOIN
                    selling_details AS B ON A.id = B.selling_id
                WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            ) WHERE name = 'SALES' AND position = 'DEBET'
            ;

            UPDATE tempAcc SET credit = 
            (
                SELECT 
                    IFNULL(SUM((B.rate * B.amount) - B.discount), 0) AS amount
                FROM 
                    selling AS A
                INNER JOIN
                    selling_details AS B ON A.id = B.selling_id
                WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            ) WHERE name = 'SALES' AND position = 'CREDIT'
            ;





            -- from cogs
            UPDATE tempAcc SET debet = 
            (
                SELECT 
                    IFNULL(SUM((B.rate * B.cogs)), 0) AS amount
                FROM 
                    selling AS A
                INNER JOIN
                    selling_details AS B ON A.id = B.selling_id
                WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            ) WHERE name = 'HPP (Harga Pokok Penjualan)' AND position = 'DEBET'
            ;

            UPDATE tempAcc SET credit = 
            (
                SELECT 
                    IFNULL(SUM((B.rate * B.cogs)), 0) AS amount
                FROM 
                    selling AS A
                INNER JOIN
                    selling_details AS B ON A.id = B.selling_id
                WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            ) WHERE name = 'HPP (Harga Pokok Penjualan)' AND position = 'CREDIT'
            ;





			IF opt = 1 THEN --show ledger
				SELECT * FROM tempAcc ORDER BY seq;            
            END IF;

			IF opt = 2 THEN --show modal vs kewajiban
				DELETE FROM tempAcc WHERE name NOT IN('MODAL', 'KEWAJIBAN');
				SELECT * FROM tempAcc ORDER BY seq;            
            END IF; 
            
			IF opt = 3 THEN --show laba rugi
				DELETE FROM tempAcc WHERE name NOT IN('PURCHASE', 'SALES', 'HPP (Harga Pokok Penjualan)', 'CASHFLOW');
				SELECT * FROM tempAcc ORDER BY seq;            
            END IF;             
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spReportLedger');
    }
};
