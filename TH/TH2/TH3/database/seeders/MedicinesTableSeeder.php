<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MedicinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('medicines')->insert([
                'name' => $faker->word(),
                'brand' => $faker->company(),
                'dosage' => $faker->randomFloat(2, 1, 100) . ' ' . $faker->word(),
                'form' => $faker->randomElement(['Tablet', 'Capsule', 'Syrup', 'Injection']),
                'price' => $faker->randomFloat(2, 10, 100),
                'stock' => $faker->randomNumber(3, true),
            ]);
        }
        
    }
}
