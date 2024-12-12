<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'publication_year' => 2008,
                'genre' => 'Programming',
                'library_id' => 1, // Tham chiếu đến thư viện ID 1
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt, David Thomas',
                'publication_year' => 1999,
                'genre' => 'Programming',
                'library_id' => 1, // Tham chiếu đến thư viện ID 1
            ],
            [
                'title' => 'Design Patterns',
                'author' => 'Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides',
                'publication_year' => 1994,
                'genre' => 'Software Design',
                'library_id' => 2, // Tham chiếu đến thư viện ID 2
            ],
        ]);
    }
}
