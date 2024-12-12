<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LibrariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('libraries')->insert([
            [
                'name' => 'Thư viện IT Đại học ABC',
                'address' => '123 Đường X, Hà Nội',
                'contact_number' => '0123456789',
            ],
            [
                'name' => 'Thư viện Khoa học Kỹ thuật',
                'address' => '456 Đường Y, TP. Hồ Chí Minh',
                'contact_number' => '0987654321',
            ],
            [
                'name' => 'Thư viện Công nghệ Thông tin',
                'address' => '789 Đường Z, Đà Nẵng',
                'contact_number' => '0901234567',
            ],
        ]);
    }
    }

