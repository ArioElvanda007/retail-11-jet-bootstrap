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
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportLedger_Daily;');
        DB::unprepared("CREATE PROCEDURE spReportLedger_Daily (IN fromDate DATE, IN opt integer)
        BEGIN    
            DECLARE toDate DATE;	
            SET toDate = DATE_ADD(fromDate, INTERVAL 30 DAY);
            
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
            WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
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
            WHERE DATE(A.date_input) BETWEEN fromDate AND toDate AND C.name = 'PURCHASE'
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
            WHERE DATE(A.date_input) BETWEEN fromDate AND toDate AND C.name = 'SALES'
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
            WHERE DATE(A.date_input) BETWEEN fromDate AND toDate AND C.name = 'HPP (Harga Pokok Penjualan)'
            GROUP BY A.date_input, C.id, C.seq, C.code, C.name, C.description, C.position;
            
            
            
            
            
            
            
            
            
            SELECT 
                A.id, A.seq, A.code, A.name, A.description, A.position,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 0 DAY)) THEN B.amount ELSE 0 END) AS amount1,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 1 DAY)) THEN B.amount ELSE 0 END) AS amount2,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 2 DAY)) THEN B.amount ELSE 0 END) AS amount3,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 3 DAY)) THEN B.amount ELSE 0 END) AS amount4,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 4 DAY)) THEN B.amount ELSE 0 END) AS amount5,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 5 DAY)) THEN B.amount ELSE 0 END) AS amount6,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 6 DAY)) THEN B.amount ELSE 0 END) AS amount7,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 7 DAY)) THEN B.amount ELSE 0 END) AS amount8,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 8 DAY)) THEN B.amount ELSE 0 END) AS amount9,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 9 DAY)) THEN B.amount ELSE 0 END) AS amount10,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 10 DAY)) THEN B.amount ELSE 0 END) AS amount11,

                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 11 DAY)) THEN B.amount ELSE 0 END) AS amount12,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 12 DAY)) THEN B.amount ELSE 0 END) AS amount13,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 13 DAY)) THEN B.amount ELSE 0 END) AS amount14,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 14 DAY)) THEN B.amount ELSE 0 END) AS amount15,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 15 DAY)) THEN B.amount ELSE 0 END) AS amount16,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 16 DAY)) THEN B.amount ELSE 0 END) AS amount17,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 17 DAY)) THEN B.amount ELSE 0 END) AS amount18,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 18 DAY)) THEN B.amount ELSE 0 END) AS amount19,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 19 DAY)) THEN B.amount ELSE 0 END) AS amount20,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 20 DAY)) THEN B.amount ELSE 0 END) AS amount21,

                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 21 DAY)) THEN B.amount ELSE 0 END) AS amount22,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 22 DAY)) THEN B.amount ELSE 0 END) AS amount23,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 23 DAY)) THEN B.amount ELSE 0 END) AS amount24,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 24 DAY)) THEN B.amount ELSE 0 END) AS amount25,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 25 DAY)) THEN B.amount ELSE 0 END) AS amount26,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 26 DAY)) THEN B.amount ELSE 0 END) AS amount27,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 27 DAY)) THEN B.amount ELSE 0 END) AS amount28,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 28 DAY)) THEN B.amount ELSE 0 END) AS amount29,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 29 DAY)) THEN B.amount ELSE 0 END) AS amount30,
                SUM(CASE WHEN DATE(B.date_input) = DATE(DATE_ADD(fromDate, INTERVAL 30 DAY)) THEN B.amount ELSE 0 END) AS amount31
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
        Schema::dropIfExists('spReportLedger_Daily');
    }
};
