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
        DB::unprepared('DROP PROCEDURE IF EXISTS spChartSPCMonthly;');
        DB::unprepared("CREATE PROCEDURE spChartSPCMonthly (IN fromDate DATE)
        BEGIN    
            -- DECLARE toDate DATE;
            -- SET fromDate = DATE_FORMAT(fromDate,'%Y-01-01');
            -- SET toDate = DATE_ADD(DATE_ADD(fromDate, INTERVAL 1 YEAR), INTERVAL -1 DAY);
            
            -- DROP TEMPORARY TABLE IF EXISTS tempData;
            -- CREATE TEMPORARY TABLE tempData            
            -- SELECT 
			-- 	0 AS seq, 'SALES' AS category,
            --     SUM(CASE WHEN MONTH(A.date_input) = 1 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_1,
            --     SUM(CASE WHEN MONTH(A.date_input) = 2 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_2,
            --     SUM(CASE WHEN MONTH(A.date_input) = 3 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_3,
            --     SUM(CASE WHEN MONTH(A.date_input) = 4 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_4,
            --     SUM(CASE WHEN MONTH(A.date_input) = 5 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_5,
            --     SUM(CASE WHEN MONTH(A.date_input) = 6 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_6,
            --     SUM(CASE WHEN MONTH(A.date_input) = 7 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_7,
            --     SUM(CASE WHEN MONTH(A.date_input) = 8 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_8,
            --     SUM(CASE WHEN MONTH(A.date_input) = 9 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_9,
            --     SUM(CASE WHEN MONTH(A.date_input) = 10 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_10,
            --     SUM(CASE WHEN MONTH(A.date_input) = 11 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_11,
            --     SUM(CASE WHEN MONTH(A.date_input) = 12 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_12
            -- FROM 
            --     selling AS A
            -- LEFT OUTER JOIN
            --     selling_details AS B ON A.id = B.selling_id
            -- WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            -- UNION ALL
            -- SELECT 
			-- 	1 AS seq, 'PROFIT' AS category,
            --     SUM(CASE WHEN MONTH(A.date_input) = 1 THEN B.rate * B.cogs ELSE 0 END) AS data_1,
            --     SUM(CASE WHEN MONTH(A.date_input) = 2 THEN B.rate * B.cogs ELSE 0 END) AS data_2,
            --     SUM(CASE WHEN MONTH(A.date_input) = 3 THEN B.rate * B.cogs ELSE 0 END) AS data_3,
            --     SUM(CASE WHEN MONTH(A.date_input) = 4 THEN B.rate * B.cogs ELSE 0 END) AS data_4,
            --     SUM(CASE WHEN MONTH(A.date_input) = 5 THEN B.rate * B.cogs ELSE 0 END) AS data_5,
            --     SUM(CASE WHEN MONTH(A.date_input) = 6 THEN B.rate * B.cogs ELSE 0 END) AS data_6,
            --     SUM(CASE WHEN MONTH(A.date_input) = 7 THEN B.rate * B.cogs ELSE 0 END) AS data_7,
            --     SUM(CASE WHEN MONTH(A.date_input) = 8 THEN B.rate * B.cogs ELSE 0 END) AS data_8,
            --     SUM(CASE WHEN MONTH(A.date_input) = 9 THEN B.rate * B.cogs ELSE 0 END) AS data_9,
            --     SUM(CASE WHEN MONTH(A.date_input) = 10 THEN B.rate * B.cogs ELSE 0 END) AS data_10,
            --     SUM(CASE WHEN MONTH(A.date_input) = 11 THEN B.rate * B.cogs ELSE 0 END) AS data_11,
            --     SUM(CASE WHEN MONTH(A.date_input) = 12 THEN B.rate * B.cogs ELSE 0 END) AS data_12
            -- FROM 
            --     selling AS A
            -- LEFT OUTER JOIN
            --     selling_details AS B ON A.id = B.selling_id
            -- WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            -- UNION ALL
            -- SELECT 
            --     2 AS seq, 'CASHFLOW' AS category,
            --     SUM(CASE WHEN MONTH(A.date_input) = 1 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_1,
            --     SUM(CASE WHEN MONTH(A.date_input) = 2 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_2,
            --     SUM(CASE WHEN MONTH(A.date_input) = 3 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_3,
            --     SUM(CASE WHEN MONTH(A.date_input) = 4 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_4,
            --     SUM(CASE WHEN MONTH(A.date_input) = 5 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_5,
            --     SUM(CASE WHEN MONTH(A.date_input) = 6 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_6,
            --     SUM(CASE WHEN MONTH(A.date_input) = 7 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_7,
            --     SUM(CASE WHEN MONTH(A.date_input) = 8 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_8,
            --     SUM(CASE WHEN MONTH(A.date_input) = 9 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_9,
            --     SUM(CASE WHEN MONTH(A.date_input) = 10 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_10,
            --     SUM(CASE WHEN MONTH(A.date_input) = 11 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_11,
            --     SUM(CASE WHEN MONTH(A.date_input) = 12 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_12
            -- FROM
            --     cashflows AS A
            -- LEFT OUTER JOIN
            --     accounts AS B ON A.account_id = B.id
            -- WHERE B.name = 'CASHFLOW' AND DATE(A.date_input) BETWEEN fromDate AND toDate
            -- ;
            
			-- SELECT category,
			-- 	CASE WHEN data_1 = 0 THEN CASE WHEN data_2 = 0 THEN NULL ELSE data_1 END ELSE data_1 END AS data_1,
			-- 	CASE WHEN data_2 = 0 THEN CASE WHEN data_3 = 0 THEN NULL ELSE data_2 END ELSE data_2 END AS data_2,
			-- 	CASE WHEN data_3 = 0 THEN CASE WHEN data_4 = 0 THEN NULL ELSE data_3 END ELSE data_3 END AS data_3,
			-- 	CASE WHEN data_4 = 0 THEN CASE WHEN data_5 = 0 THEN NULL ELSE data_4 END ELSE data_4 END AS data_4,
			-- 	CASE WHEN data_5 = 0 THEN CASE WHEN data_6 = 0 THEN NULL ELSE data_5 END ELSE data_5 END AS data_5,
			-- 	CASE WHEN data_6 = 0 THEN CASE WHEN data_7 = 0 THEN NULL ELSE data_6 END ELSE data_6 END AS data_6,
			-- 	CASE WHEN data_7 = 0 THEN CASE WHEN data_8 = 0 THEN NULL ELSE data_7 END ELSE data_7 END AS data_7,
			-- 	CASE WHEN data_8 = 0 THEN CASE WHEN data_9 = 0 THEN NULL ELSE data_8 END ELSE data_8 END AS data_8,
			-- 	CASE WHEN data_9 = 0 THEN CASE WHEN data_10 = 0 THEN NULL ELSE data_9 END ELSE data_9 END AS data_9,
			-- 	CASE WHEN data_10 = 0 THEN CASE WHEN data_11 = 0 THEN NULL ELSE data_10 END ELSE data_10 END AS data_10,
			-- 	CASE WHEN data_11 = 0 THEN CASE WHEN data_12 = 0 THEN NULL ELSE data_11 END ELSE data_11 END AS data_11,
			-- 	CASE WHEN data_12 = 0 THEN NULL ELSE data_12 END AS data_11
            -- FROM tempData ORDER BY seq;




            DECLARE toDate DATE;
		
            DECLARE sales_data_1 DECIMAL(18, 4);
            DECLARE sales_data_2 DECIMAL(18, 4);
            DECLARE sales_data_3 DECIMAL(18, 4);
            DECLARE sales_data_4 DECIMAL(18, 4);
            DECLARE sales_data_5 DECIMAL(18, 4);
            DECLARE sales_data_6 DECIMAL(18, 4);
            DECLARE sales_data_7 DECIMAL(18, 4);
            DECLARE sales_data_8 DECIMAL(18, 4);
            DECLARE sales_data_9 DECIMAL(18, 4);
            DECLARE sales_data_10 DECIMAL(18, 4);
            DECLARE sales_data_11 DECIMAL(18, 4);
            DECLARE sales_data_12 DECIMAL(18, 4);

            DECLARE cogs_data_1 DECIMAL(18, 4);
            DECLARE cogs_data_2 DECIMAL(18, 4);
            DECLARE cogs_data_3 DECIMAL(18, 4);
            DECLARE cogs_data_4 DECIMAL(18, 4);
            DECLARE cogs_data_5 DECIMAL(18, 4);
            DECLARE cogs_data_6 DECIMAL(18, 4);
            DECLARE cogs_data_7 DECIMAL(18, 4);
            DECLARE cogs_data_8 DECIMAL(18, 4);
            DECLARE cogs_data_9 DECIMAL(18, 4);
            DECLARE cogs_data_10 DECIMAL(18, 4);
            DECLARE cogs_data_11 DECIMAL(18, 4);
            DECLARE cogs_data_12 DECIMAL(18, 4);

            DECLARE cashflow_data_1 DECIMAL(18, 4);
            DECLARE cashflow_data_2 DECIMAL(18, 4);
            DECLARE cashflow_data_3 DECIMAL(18, 4);
            DECLARE cashflow_data_4 DECIMAL(18, 4);
            DECLARE cashflow_data_5 DECIMAL(18, 4);
            DECLARE cashflow_data_6 DECIMAL(18, 4);
            DECLARE cashflow_data_7 DECIMAL(18, 4);
            DECLARE cashflow_data_8 DECIMAL(18, 4);
            DECLARE cashflow_data_9 DECIMAL(18, 4);
            DECLARE cashflow_data_10 DECIMAL(18, 4);
            DECLARE cashflow_data_11 DECIMAL(18, 4);
            DECLARE cashflow_data_12 DECIMAL(18, 4);
            
            
            SET fromDate = DATE_FORMAT(fromDate,'%Y-01-01');
            SET toDate = DATE_ADD(DATE_ADD(fromDate, INTERVAL 1 YEAR), INTERVAL -1 DAY);
            
            DROP TEMPORARY TABLE IF EXISTS tempData;
            CREATE TEMPORARY TABLE tempData            
            SELECT 
				0 AS seq, 'SALES' AS category,
                SUM(CASE WHEN MONTH(A.date_input) = 1 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_1,
                SUM(CASE WHEN MONTH(A.date_input) = 2 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_2,
                SUM(CASE WHEN MONTH(A.date_input) = 3 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_3,
                SUM(CASE WHEN MONTH(A.date_input) = 4 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_4,
                SUM(CASE WHEN MONTH(A.date_input) = 5 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_5,
                SUM(CASE WHEN MONTH(A.date_input) = 6 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_6,
                SUM(CASE WHEN MONTH(A.date_input) = 7 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_7,
                SUM(CASE WHEN MONTH(A.date_input) = 8 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_8,
                SUM(CASE WHEN MONTH(A.date_input) = 9 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_9,
                SUM(CASE WHEN MONTH(A.date_input) = 10 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_10,
                SUM(CASE WHEN MONTH(A.date_input) = 11 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_11,
                SUM(CASE WHEN MONTH(A.date_input) = 12 THEN (B.rate * B.amount) - B.discount ELSE 0 END) AS data_12
            FROM 
                selling AS A
            LEFT OUTER JOIN
                selling_details AS B ON A.id = B.selling_id
            WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            UNION ALL
            SELECT 
				1 AS seq, 'COGS' AS category,
                SUM(CASE WHEN MONTH(A.date_input) = 1 THEN B.rate * B.cogs ELSE 0 END) AS data_1,
                SUM(CASE WHEN MONTH(A.date_input) = 2 THEN B.rate * B.cogs ELSE 0 END) AS data_2,
                SUM(CASE WHEN MONTH(A.date_input) = 3 THEN B.rate * B.cogs ELSE 0 END) AS data_3,
                SUM(CASE WHEN MONTH(A.date_input) = 4 THEN B.rate * B.cogs ELSE 0 END) AS data_4,
                SUM(CASE WHEN MONTH(A.date_input) = 5 THEN B.rate * B.cogs ELSE 0 END) AS data_5,
                SUM(CASE WHEN MONTH(A.date_input) = 6 THEN B.rate * B.cogs ELSE 0 END) AS data_6,
                SUM(CASE WHEN MONTH(A.date_input) = 7 THEN B.rate * B.cogs ELSE 0 END) AS data_7,
                SUM(CASE WHEN MONTH(A.date_input) = 8 THEN B.rate * B.cogs ELSE 0 END) AS data_8,
                SUM(CASE WHEN MONTH(A.date_input) = 9 THEN B.rate * B.cogs ELSE 0 END) AS data_9,
                SUM(CASE WHEN MONTH(A.date_input) = 10 THEN B.rate * B.cogs ELSE 0 END) AS data_10,
                SUM(CASE WHEN MONTH(A.date_input) = 11 THEN B.rate * B.cogs ELSE 0 END) AS data_11,
                SUM(CASE WHEN MONTH(A.date_input) = 12 THEN B.rate * B.cogs ELSE 0 END) AS data_12
            FROM 
                selling AS A
            LEFT OUTER JOIN
                selling_details AS B ON A.id = B.selling_id
            WHERE DATE(A.date_input) BETWEEN fromDate AND toDate
            UNION ALL
            SELECT 
                2 AS seq, 'CASHFLOW' AS category,
                SUM(CASE WHEN MONTH(A.date_input) = 1 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_1,
                SUM(CASE WHEN MONTH(A.date_input) = 2 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_2,
                SUM(CASE WHEN MONTH(A.date_input) = 3 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_3,
                SUM(CASE WHEN MONTH(A.date_input) = 4 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_4,
                SUM(CASE WHEN MONTH(A.date_input) = 5 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_5,
                SUM(CASE WHEN MONTH(A.date_input) = 6 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_6,
                SUM(CASE WHEN MONTH(A.date_input) = 7 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_7,
                SUM(CASE WHEN MONTH(A.date_input) = 8 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_8,
                SUM(CASE WHEN MONTH(A.date_input) = 9 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_9,
                SUM(CASE WHEN MONTH(A.date_input) = 10 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_10,
                SUM(CASE WHEN MONTH(A.date_input) = 11 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_11,
                SUM(CASE WHEN MONTH(A.date_input) = 12 THEN CASE WHEN A.debet - A.credit < 0 THEN (A.debet - A.credit) * -1 ELSE A.debet - A.credit END ELSE 0 END) AS data_12
            FROM
                cashflows AS A
            LEFT OUTER JOIN
                accounts AS B ON A.account_id = B.id
            WHERE B.name = 'CASHFLOW' AND DATE(A.date_input) BETWEEN fromDate AND toDate
            UNION ALL
            SELECT 
				3 AS seq, 'CUAN' AS category,
                0 AS data_1,
                0 AS data_2,
                0 AS data_3,
                0 AS data_4,
                0 AS data_5,
                0 AS data_6,
                0 AS data_7,
                0 AS data_8,
                0 AS data_9,
                0 AS data_10,
                0 AS data_11,
                0 AS data_12        
            ;
            
            -- update cuan
            SELECT 
				data_1, data_2, data_3, data_4, data_5, data_6, data_7, data_8, data_9, data_10, data_11, data_12
			INTO
				sales_data_1, sales_data_2, sales_data_3, sales_data_4, sales_data_5, sales_data_6, sales_data_7, sales_data_8, sales_data_9, sales_data_10, sales_data_11, sales_data_12
			FROM tempData WHERE category = 'SALES';

            SELECT 
				data_1, data_2, data_3, data_4, data_5, data_6, data_7, data_8, data_9, data_10, data_11, data_12
			INTO
				cogs_data_1, cogs_data_2, cogs_data_3, cogs_data_4, cogs_data_5, cogs_data_6, cogs_data_7, cogs_data_8, cogs_data_9, cogs_data_10, cogs_data_11, cogs_data_12
			FROM tempData WHERE category = 'COGS';

			SELECT 
				data_1, data_2, data_3, data_4, data_5, data_6, data_7, data_8, data_9, data_10, data_11, data_12
			INTO
				cashflow_data_1, cashflow_data_2, cashflow_data_3, cashflow_data_4, cashflow_data_5, cashflow_data_6, cashflow_data_7, cashflow_data_8, cashflow_data_9, cashflow_data_10, cashflow_data_11, cashflow_data_12            
			FROM tempData WHERE category = 'CASHFLOW';

			UPDATE tempData SET data_1 = sales_data_1 - cogs_data_1 - cashflow_data_1, data_2 = sales_data_2 - cogs_data_2 - cashflow_data_2, data_3 = sales_data_3 - cogs_data_3 - cashflow_data_3, data_4 = sales_data_4 - cogs_data_4 - cashflow_data_4, data_5 = sales_data_5 - cogs_data_5 - cashflow_data_5, data_6 = sales_data_6 - cogs_data_6 - cashflow_data_6, data_7 = sales_data_7 - cogs_data_7 - cashflow_data_7, data_8 = sales_data_8 - cogs_data_8 - cashflow_data_8, data_9 = sales_data_9 - cogs_data_9 - cashflow_data_9, data_10 = sales_data_10 - cogs_data_10 - cashflow_data_10, data_1 = sales_data_11 - cogs_data_11 - cashflow_data_11, data_12 = sales_data_12 - cogs_data_12 - cashflow_data_12
			WHERE category = 'CUAN';




            
			SELECT category,
				CASE WHEN data_1 = 0 THEN CASE WHEN data_2 = 0 THEN NULL ELSE data_1 END ELSE data_1 END AS data_1,
				CASE WHEN data_2 = 0 THEN CASE WHEN data_3 = 0 THEN NULL ELSE data_2 END ELSE data_2 END AS data_2,
				CASE WHEN data_3 = 0 THEN CASE WHEN data_4 = 0 THEN NULL ELSE data_3 END ELSE data_3 END AS data_3,
				CASE WHEN data_4 = 0 THEN CASE WHEN data_5 = 0 THEN NULL ELSE data_4 END ELSE data_4 END AS data_4,
				CASE WHEN data_5 = 0 THEN CASE WHEN data_6 = 0 THEN NULL ELSE data_5 END ELSE data_5 END AS data_5,
				CASE WHEN data_6 = 0 THEN CASE WHEN data_7 = 0 THEN NULL ELSE data_6 END ELSE data_6 END AS data_6,
				CASE WHEN data_7 = 0 THEN CASE WHEN data_8 = 0 THEN NULL ELSE data_7 END ELSE data_7 END AS data_7,
				CASE WHEN data_8 = 0 THEN CASE WHEN data_9 = 0 THEN NULL ELSE data_8 END ELSE data_8 END AS data_8,
				CASE WHEN data_9 = 0 THEN CASE WHEN data_10 = 0 THEN NULL ELSE data_9 END ELSE data_9 END AS data_9,
				CASE WHEN data_10 = 0 THEN CASE WHEN data_11 = 0 THEN NULL ELSE data_10 END ELSE data_10 END AS data_10,
				CASE WHEN data_11 = 0 THEN CASE WHEN data_12 = 0 THEN NULL ELSE data_11 END ELSE data_11 END AS data_11,
				CASE WHEN data_12 = 0 THEN NULL ELSE data_12 END AS data_12
            FROM tempData ORDER BY seq;            
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spChartSPCMonthly');
    }
};
