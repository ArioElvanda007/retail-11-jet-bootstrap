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
        $procedure = "DROP PROCEDURE IF EXISTS spStock;
        
        CREATE PROCEDURE spStock (IN spIidx BIGINT, spDate DATE)
        BEGIN
            DROP TEMPORARY TABLE IF EXISTS tempProd;
            
            IF spIidx = 0 THEN
                CREATE TEMPORARY TABLE tempProd
                SELECT * FROM products;
            END IF;
        
            IF spIidx <> 0 THEN
                CREATE TEMPORARY TABLE tempProd
                SELECT * FROM products WHERE id = spIidx;
            END IF;
            
            SELECT 
                A.id, A.code, A.name, A.price_buy, A.price_sell,
                IFNULL(D.rate, 0) + IFNULL(G.rate, 0) - 
                IFNULL(J.rate, 0) AS stock, A.description, A.created_at, A.updated_at
            FROM
                tempProd AS A
            LEFT OUTER JOIN
                (
                    SELECT 
                        B.id, B.prod_id, B.rate 
                    FROM 
                        stocks AS B
                    INNER JOIN
                        (
                            SELECT MAX(id) AS id, MAX(date_input) AS date_input FROM stocks
                            WHERE date_input <= spDate
                            GROUP BY prod_id    
                        ) AS C ON B.id = C.id
                ) AS D ON A.id = D.prod_id
            LEFT OUTER JOIN
                (
                    SELECT 
                        F.prod_id, IFNULL(SUM(F.rate), 0) AS rate
                    FROM 
                        buying AS E
                    INNER JOIN
                        buying_details AS F ON E.id = F.buying_id WHERE E.date_input <= spDate 
                ) AS G ON A.id = G.prod_id
            LEFT OUTER JOIN
                (
                    SELECT 
                        I.prod_id, IFNULL(SUM(I.rate), 0) AS rate
                    FROM 
                        selling AS H
                    INNER JOIN
                        selling_details AS I ON H.id = I.selling_id WHERE H.date_input <= spDate
                ) AS J ON A.id = J.prod_id    
            -- GROUP BY A.id, A.name, A.price_buy, A.price_sell, A.description, A.created_at, A.updated_at
            ;
        END

        ;";
        
        DB::unprepared($procedure);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spStock');
    }
};
