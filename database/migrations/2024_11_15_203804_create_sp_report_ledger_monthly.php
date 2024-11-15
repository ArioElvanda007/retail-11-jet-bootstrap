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
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportLedger_Monthly;');
        DB::unprepared("CREATE PROCEDURE spReportLedger_Monthly (IN fromDate DATE, IN opt integer)
        BEGIN    
            DECLARE toDate DATE;
            SET fromDate = DATE_FORMAT(fromDate,'%y-%m-%1'); -- set first day of month
            SET toDate = LAST_DAY(DATE_ADD(fromDate, INTERVAL 11 MONTH)); -- set last day of month
            
            -- from cashflows
            DROP TEMPORARY TABLE IF EXISTS tempReportLedger_Daily;
            CREATE TEMPORARY TABLE tempReportLedger_Daily
            SELECT 
                A.date_input, B.id, B.seq, B.code, B.name, B.description, B.position, -- IFNULL(SUM(A.debet), 0) AS debet, IFNULL(SUM(A.credit), 0) AS credit, 0 AS balance
                IFNULL(SUM(A.debet), 0) - IFNULL(SUM(A.credit), 0) AS amount    
            FROM 
                cashflows AS A
            LEFT OUTER JOIN
                accounts AS B ON A.account_id = B.id
            WHERE DATE(A.date_input) BETWEEN DATE(fromDate) AND DATE(toDate)
            GROUP BY A.date_input, B.id, B.seq, B.code, B.name, B.description, B.position  
            
            
            
            
            
            -- from purchase
            UNION ALL
            SELECT 
                A.date_input, C.id, C.seq, C.code, C.name, C.description, C.position, 
                CASE 
                    WHEN C.position = 'DEBET' THEN IFNULL(SUM((B.rate * B.amount) - B.discount), 0)
                    WHEN C.position = 'CREDIT' THEN IFNULL(SUM((B.rate * B.amount) - B.discount), 0) * -1 ELSE 0 
                END amount
            FROM 
                buying AS A
            INNER JOIN
                buying_details AS B ON A.id = B.buying_id
            CROSS JOIN
                accounts AS C
            WHERE DATE(A.date_input) BETWEEN DATE(fromDate) AND DATE(toDate) AND C.name = 'PURCHASE'
            GROUP BY A.date_input, C.id, C.seq, C.code, C.name, C.description, C.position  
            
            
            
            
            
            
            -- from sales
            UNION ALL
            SELECT 
                A.date_input, C.id, C.seq, C.code, C.name, C.description, C.position, 
                CASE 
                    WHEN C.position = 'DEBET' THEN IFNULL(SUM((B.rate * B.amount) - B.discount), 0)
                    WHEN C.position = 'CREDIT' THEN IFNULL(SUM((B.rate * B.amount) - B.discount), 0) * -1 ELSE 0 
                END amount
            FROM 
                selling AS A
            INNER JOIN
                selling_details AS B ON A.id = B.selling_id
            CROSS JOIN
                accounts AS C
            WHERE DATE(A.date_input) BETWEEN DATE(fromDate) AND DATE(toDate) AND C.name = 'SALES'
            GROUP BY A.date_input, C.id, C.seq, C.code, C.name, C.description, C.position
            
            
            
            
            
            
            
            
            -- from cogs
            UNION ALL
            SELECT 
                A.date_input, C.id, C.seq, C.code, C.name, C.description, C.position, 
                CASE 
                    WHEN C.position = 'DEBET' THEN IFNULL(SUM((B.rate * B.cogs)), 0)
                    WHEN C.position = 'CREDIT' THEN IFNULL(SUM((B.rate * B.cogs)), 0) * -1 ELSE 0 
                END amount
            FROM 
                selling AS A
            INNER JOIN
                selling_details AS B ON A.id = B.selling_id
            CROSS JOIN
                accounts AS C
            WHERE DATE(A.date_input) BETWEEN DATE(fromDate) AND DATE(toDate) AND C.name = 'HPP (Harga Pokok Penjualan)'
            GROUP BY A.date_input, C.id, C.seq, C.code, C.name, C.description, C.position;    
            
            
            
            
                    
            SELECT 
                A.id, A.seq, A.code, A.name, A.description, A.position,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 0 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 0 MONTH)) THEN B.amount ELSE 0 END) AS amount1,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 1 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 1 MONTH)) THEN B.amount ELSE 0 END) AS amount2,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 2 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 2 MONTH)) THEN B.amount ELSE 0 END) AS amount3,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 3 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 3 MONTH)) THEN B.amount ELSE 0 END) AS amount4,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 4 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 4 MONTH)) THEN B.amount ELSE 0 END) AS amount5,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 5 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 5 MONTH)) THEN B.amount ELSE 0 END) AS amount6,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 6 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 6 MONTH)) THEN B.amount ELSE 0 END) AS amount7,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 7 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 7 MONTH)) THEN B.amount ELSE 0 END) AS amount8,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 8 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 8 MONTH)) THEN B.amount ELSE 0 END) AS amount9,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 9 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 9 MONTH)) THEN B.amount ELSE 0 END) AS amount10,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 10 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 10 MONTH)) THEN B.amount ELSE 0 END) AS amount11,
                SUM(CASE WHEN MONTH(B.date_input) = MONTH(DATE_ADD(fromDate, INTERVAL 11 MONTH)) AND YEAR(B.date_input) = YEAR(DATE_ADD(fromDate, INTERVAL 11 MONTH)) THEN B.amount ELSE 0 END) AS amount12
            FROM 
                accounts AS A
            LEFT OUTER JOIN
                tempReportLedger_Daily AS B ON A.id = B.id
            WHERE 
                CASE
                    WHEN opt = 1 THEN A.name IN (SELECT name FROM accounts GROUP BY name)
                    WHEN opt = 2 THEN A.name IN ('MODAL', 'KEWAJIBAN')
                    WHEN opt = 3 THEN A.name IN ('SALES', 'HPP (Harga Pokok Penjualan)', 'CASHFLOW')
                END
            GROUP BY A.seq, A.code, A.name, A.description, A.position
            ;             
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spReportLedger_Monthly');
    }
};
