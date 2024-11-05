<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts')->insert([
            'seq' => 1,
            'code' => '0001',
            'name' => 'MODAL',
            'position' => 'DEBET',
            'description' => 'CAPITAL STOCK',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('accounts')->insert([
            'seq' => 2,
            'code' => '0002',
            'name' => 'KEWAJIBAN',
            'position' => 'CREDIT',
            'description' => 'LIABILITIES',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('accounts')->insert([
            'seq' => 3,
            'code' => '0003',
            'name' => 'SALES',
            'position' => 'DEBET',
            'description' => 'SELLING TRANSACTION',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('accounts')->insert([
            'seq' => 4,
            'code' => '0004',
            'name' => 'HPP (Harga Pokok Penjualan)',
            'position' => 'CREDIT',
            'description' => 'COGS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('accounts')->insert([
            'seq' => 5,
            'code' => '0005',
            'name' => 'PURCHASE',
            'position' => 'CREDIT',
            'description' => 'BUYING TRANSACTION',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('accounts')->insert([
            'seq' => 6,
            'code' => '0006',
            'name' => 'CASHFLOW',
            'description' => 'OTHER TRANSACTION',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('accounts')->insert([
            'seq' => 7,
            'code' => '0007',
            'name' => 'SAVING',
            'position' => 'CREDIT',
            'description' => 'OWNER WITHDRAWAL',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
