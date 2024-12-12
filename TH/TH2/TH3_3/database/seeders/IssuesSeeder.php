<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class IssuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();   
        for ($i = 0; $i < 100; $i++){
        DB::table('issues')->insert([
            'computer_id' => $faker->numberBetween(1, 50), // Assuming you have 50 computers in the computers table
            'reported_by' => $faker->name(),
            'reported_date' => $faker->dateTimeThisYear(),
            'description' => $faker->paragraph(),
            'status' => $faker->randomElement(['Low', 'Medium', 'High']),
            'priority' => $faker->randomElement(['Open', 'In Progress', 'Resolved']),
        ]);
    }
    }
}
