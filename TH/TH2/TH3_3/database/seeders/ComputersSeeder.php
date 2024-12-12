<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class ComputersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('computers')->insert([
                'computer_name' => $faker->word(),
                'model' => $faker->word() . ' ' . $faker->randomNumber(4),
                'operating_system' => $faker->randomElement(['Windows 10', 'Windows 11', 'macOS Ventura', 'Linux Ubuntu']),
                'memory' => $faker->numberBetween(4, 64), // Memory in GB
                'available' => $faker->boolean(),
            ]);
        }
    }
}
