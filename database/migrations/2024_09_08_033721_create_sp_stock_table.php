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
        DB::unprepared('DROP PROCEDURE IF EXISTS spStock;');
        DB::unprepared("CREATE PROCEDURE spStock (IN spIidx BIGINT, spDate DATE)
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
            
            
            
            
            DROP TEMPORARY TABLE IF EXISTS tempAdj;
            IF spIidx = 0 THEN
				CREATE TEMPORARY TABLE tempAdj                
				SELECT 
					prod_id, IFNULL(SUM(rate), 0) AS rate, date_input
				FROM 
					stocks
				WHERE DATE(date_input) = DATE(spDate) 
				GROUP BY date_input, prod_id
				;
            END IF;
            
            IF spIidx <> 0 THEN
				CREATE TEMPORARY TABLE tempAdj
				SELECT 
					prod_id, IFNULL(SUM(rate), 0) AS rate, date_input
				FROM 
					stocks
				WHERE DATE(date_input) = DATE(spDate) AND prod_id = spIidx
				GROUP BY date_input, prod_id
				;                
            END IF;



            DROP TEMPORARY TABLE IF EXISTS tempAdjBegin;
            IF spIidx = 0 THEN
				CREATE TEMPORARY TABLE tempAdjBegin                
				SELECT 
					prod_id, IFNULL(SUM(rate), 0) AS rate, date_input
				FROM 
					stocks
				WHERE DATE(date_input) < DATE(spDate) 
				GROUP BY date_input, prod_id
				;
            END IF;
            
            IF spIidx <> 0 THEN
				CREATE TEMPORARY TABLE tempAdjBegin
				SELECT 
					prod_id, IFNULL(SUM(rate), 0) AS rate, date_input
				FROM 
					stocks
				WHERE DATE(date_input) < DATE(spDate) AND prod_id = spIidx
				GROUP BY date_input, prod_id
				;                
            END IF;


            
            DROP TEMPORARY TABLE IF EXISTS tempBuy;
            IF spIidx = 0 THEN
				CREATE TEMPORARY TABLE tempBuy
				SELECT 
					B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, A.date_input
				FROM 
					buying AS A
				INNER JOIN
					buying_details AS B ON A.id = B.buying_id WHERE DATE(A.date_input) = DATE(spDate)
					GROUP BY B.prod_id, A.date_input
				;
            END IF;
            
            IF spIidx <> 0 THEN
				CREATE TEMPORARY TABLE tempBuy
				SELECT 
					B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, A.date_input
				FROM 
					buying AS A
				INNER JOIN
					buying_details AS B ON A.id = B.buying_id WHERE DATE(A.date_input) = DATE(spDate) AND B.prod_id = spIidx
					GROUP BY B.prod_id, A.date_input
				;
            END IF;
            
            
            
            
            DROP TEMPORARY TABLE IF EXISTS tempBuyBegin;
            IF spIidx = 0 THEN
				CREATE TEMPORARY TABLE tempBuyBegin
				SELECT 
					B.prod_id, IFNULL(SUM(B.rate), 0) AS rate
				FROM 
					buying AS A
				INNER JOIN
					buying_details AS B ON A.id = B.buying_id WHERE DATE(A.date_input) < DATE(spDate)
					GROUP BY B.prod_id
				; 
            END IF;
            
			IF spIidx <> 0 THEN
				CREATE TEMPORARY TABLE tempBuyBegin
				SELECT 
					B.prod_id, IFNULL(SUM(B.rate), 0) AS rate
				FROM 
					buying AS A
				INNER JOIN
					buying_details AS B ON A.id = B.buying_id WHERE DATE(A.date_input) < DATE(spDate) AND B.prod_id = spIidx
					GROUP BY B.prod_id
				; 
            END IF;
            
            
            
                    
                    
                    
            DROP TEMPORARY TABLE IF EXISTS tempSell;
            IF spIidx = 0 THEN
				CREATE TEMPORARY TABLE tempSell
				SELECT 
					B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, A.date_input
				FROM 
					selling AS A
				INNER JOIN
					selling_details AS B ON A.id = B.selling_id WHERE DATE(A.date_input) = DATE(spDate)
					GROUP BY B.prod_id, A.date_input
				; 
			END IF;

            IF spIidx <> 0 THEN
				CREATE TEMPORARY TABLE tempSell
				SELECT 
					B.prod_id, IFNULL(SUM(B.rate), 0) AS rate, A.date_input
				FROM 
					selling AS A
				INNER JOIN
					selling_details AS B ON A.id = B.selling_id WHERE DATE(A.date_input) = DATE(spDate) AND B.prod_id = spIidx 
					GROUP BY B.prod_id, A.date_input
				; 
			END IF;
            
            
            
            
            
            
            DROP TEMPORARY TABLE IF EXISTS tempSellBegin;
            IF spIidx = 0 THEN
				CREATE TEMPORARY TABLE tempSellBegin
				SELECT 
					B.prod_id, IFNULL(SUM(B.rate), 0) AS rate
				FROM 
					selling AS A
				INNER JOIN
					selling_details AS B ON A.id = B.selling_id WHERE A.date_input < spDate
					GROUP BY B.prod_id
				;     
            END IF;
            
            IF spIidx <> 0 THEN
				CREATE TEMPORARY TABLE tempSellBegin
				SELECT 
					B.prod_id, IFNULL(SUM(B.rate), 0) AS rate
				FROM 
					selling AS A
				INNER JOIN
					selling_details AS B ON A.id = B.selling_id WHERE A.date_input < spDate AND B.prod_id = spIidx 
					GROUP BY B.prod_id
				;     
            END IF;
            
            
            
            
            
            
            DROP TEMPORARY TABLE IF EXISTS tempProd2;
            CREATE TEMPORARY TABLE tempProd2
            SELECT 
                A.id, A.code, A.name, A.price_buy, A.price_sell,     
				ifnull(G.rate, 0) AS adj_begining,
				ifnull(E.rate, 0) AS buy_begining,
                ifnull(F.rate, 0) AS sell_begining,

                MAX(CASE WHEN DATE(B.date_input) = DATE(spDate) THEN B.rate ELSE 0 END) AS adj_current,
                MAX(CASE WHEN DATE(C.date_input) = DATE(spDate) THEN C.rate ELSE 0 END) AS buy_current,
                MAX(CASE WHEN DATE(D.date_input) = DATE(spDate) THEN D.rate ELSE 0 END) AS sell_current,
                
                A.description, A.created_at, A.updated_at
            FROM 
                tempProd AS A
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
            GROUP BY A.id, A.name, A.price_buy, A.price_sell, A.description, A.created_at, A.updated_at
            ;
            
            SELECT 
				id, name, code, price_buy, price_sell, (adj_begining + buy_begining - sell_begining) + adj_current + buy_current - sell_current AS stock, description, created_at, updated_at
            FROM tempProd2
            ;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spStock;');
    }
};
