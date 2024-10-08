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
        DB::unprepared('DROP PROCEDURE IF EXISTS spReportJournal;');
        DB::unprepared("CREATE PROCEDURE spReportJournal (IN fromDate DATE, IN toDate DATE)
        BEGIN    
            DECLARE beginingDate DATE;
            SET beginingDate = DATE_ADD(fromDate, INTERVAL -1 DAY);
            
            
            
            
            DROP TEMPORARY TABLE IF EXISTS tempBuyBegin;
            CREATE TEMPORARY TABLE tempBuyBegin
            SELECT 
                beginingDate AS date_input, 'Begining' AS description, 0 AS debet, IFNULL(SUM(subtotal - discount), 0) AS credit
            FROM 
                buying
            WHERE date_input < fromDate;

            DROP TEMPORARY TABLE IF EXISTS tempBuy;
            CREATE TEMPORARY TABLE tempBuy
            SELECT 
                DATE(date_input) AS date_input, 'Buying' AS description, 0 AS debet, IFNULL(SUM(subtotal - discount), 0) AS credit
            FROM 
                buying
            WHERE date_input BETWEEN fromDate AND toDate 
            GROUP BY DATE(date_input); 
            
            
            
            DROP TEMPORARY TABLE IF EXISTS tempSellingBegin;
            CREATE TEMPORARY TABLE tempSellingBegin
            SELECT 
                beginingDate AS date_input, 'Begining' AS description, IFNULL(SUM(subtotal - discount), 0) AS debet, 0 AS credit
            FROM 
                selling
            WHERE date_input < fromDate;

            DROP TEMPORARY TABLE IF EXISTS tempSelling;
            CREATE TEMPORARY TABLE tempSelling
            SELECT 
                DATE(date_input) AS date_input, 'Sales' AS description, IFNULL(SUM(subtotal - discount), 0) AS debet, 0 AS credit
            FROM 
                selling
            WHERE date_input BETWEEN fromDate AND toDate 
            GROUP BY DATE(date_input); 
            
            


            DROP TEMPORARY TABLE IF EXISTS tempCashflowBegin;
            CREATE TEMPORARY TABLE tempCashflowBegin
            SELECT 
                beginingDate AS date_input, 'Begining' AS description, IFNULL(SUM(debet), 0) AS debet, IFNULL(SUM(credit), 0) AS credit
            FROM 
                cashflows
            WHERE date_input < fromDate;

            DROP TEMPORARY TABLE IF EXISTS tempCashflow;
            CREATE TEMPORARY TABLE tempCashflow
            SELECT 
                DATE(date_input) AS date_input, title AS description, IFNULL(SUM(debet), 0) AS debet, IFNULL(SUM(credit), 0) AS credit
            FROM 
                cashflows
            WHERE date_input BETWEEN fromDate AND toDate 
            GROUP BY DATE(date_input), title; 
            
            
            
            
            

            DROP TEMPORARY TABLE IF EXISTS tempDate;
            CREATE TEMPORARY TABLE tempDate
            WITH RECURSIVE date_ranges AS (
                SELECT DATE(beginingDate) AS Date
                UNION ALL
                SELECT Date + INTERVAL 1 DAY
                FROM Date_Ranges
                WHERE Date <= DATE(toDate))
            SELECT Date AS date_input, '' AS description, 0 AS debet, 0 AS credit FROM date_ranges;
            
            

            DROP TEMPORARY TABLE IF EXISTS tempCollect;
            CREATE TEMPORARY TABLE tempCollect (
                date_input DATE, 
                description VARCHAR(100), 
                debet DECIMAL(18, 4),
                credit DECIMAL(18, 4)
            );
            
            INSERT INTO tempCollect SELECT * FROM tempBuyBegin;
            INSERT INTO tempCollect SELECT * FROM tempBuy;
            INSERT INTO tempCollect SELECT * FROM tempSellingBegin;
            INSERT INTO tempCollect SELECT * FROM tempSelling;
            INSERT INTO tempCollect SELECT * FROM tempCashflowBegin;
            INSERT INTO tempCollect SELECT * FROM tempCashflow;
            INSERT INTO tempCollect SELECT * FROM tempDate;
            
            
            

            DROP TEMPORARY TABLE IF EXISTS tempResult;
            CREATE TEMPORARY TABLE tempResult
            SELECT
                date_input, description, IFNULL(SUM(debet), 0) AS debet, IFNULL(SUM(credit), 0) AS credit
            FROM 
                tempCollect
            GROUP BY date_input, description 
            ORDER BY date_input;


            
            
            DELETE FROM tempResult WHERE date_input IN
            (
                SELECT A.date_input 
                    FROM
                        (
                            SELECT date_input, COUNT(date_input) AS seq FROM tempResult GROUP BY date_input
                        ) AS A
                WHERE A.seq > 1
            ) AND description = '';
            
            SELECT * FROM tempResult;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spReportJournal');
    }
};
