<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Book::create([
            'title' => 'La la land',
            'author' => 'SJK Jacob',
            'price' => '200',
            'stock'=>'100',
            'book_category_id' =>'1',
        ]);

        Book::create([
            'title' => 'Rawana',
            'author' => 'sju',
            'price' => '200',
            'stock'=>'10',
            'book_category_id' =>'2',
        ]);

        Book::create([
            'title' => 'Surandib',
            'author' => 'Malkit',
            'price' => '200',
            'stock'=>'10',
            'book_category_id' =>'3',
        ]);

        Book::create([
            'title' => 'Don',
            'author' => 'SJK Jacob',
            'price' => '20',
            'stock'=>'100',
            'book_category_id' =>'4',
        ]);

        Book::create([
            'title' => 'God of war',
            'author' => 'SJK Jacob',
            'price' => '20',
            'stock'=>'140',
            'book_category_id' =>'5',
        ]);

        Book::create([
            'title' => 'New Dawn',
            'author' => 'LLK Nirmal',
            'price' => '20',
            'stock'=>'140',
            'book_category_id' =>'2',
        ]);

        Book::create([
            'title' => 'Max Payne',
            'author' => 'Kamal Rizki',
            'price' => '20',
            'stock'=>'190',
            'book_category_id' =>'2',
        ]);

        Book::create([
            'title' => 'Max Payne2',
            'author' => 'Kamal Rizki',
            'price' => '20',
            'stock'=>'1',
            'book_category_id' =>'1',
        ]);

    }
}
