<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->insert([
            'account_number' => '1111-1111-xxxxxxx',
            'account_name' => 'SANTANDER',
            'branch_office' => 'Ciechanow - Poland',
            'behalf_of' => 'ARIO ELVANDA',
            'description' => 'THIS EXAMPLE BANK',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
