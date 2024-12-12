<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('renters')->insert([
            [
                'name' => 'Nguyen Van A',
                'phone_number' => '0987654321',
                'email' => 'nva@gmail.com',
               
            ],
            [
                'name' => 'Tran Thi B',
                'phone_number' => '0976543210',
                'email' => 'ttb@gmail.com',
               
            ]
        ]);
    }
}
