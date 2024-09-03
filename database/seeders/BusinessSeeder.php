<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business')->insert([
            'name' => 'Ario Elvanda - Shop',
            'address' => 'Gabriela Narutowicza 4A, 06-400 Ciechanów - Polandia',
            'telephone' => '+48-xxxx-xxxx',
            'email' => 'general@gmail.com',
            'description' => 'IS GENERAL BUSINESS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
