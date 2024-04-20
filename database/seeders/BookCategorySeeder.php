<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $categories = ['Action Adventure','Fictional','Non-Fictional','Historical','Technology'];

         foreach ($categories as $key => $cate) {
            $bookcate = new BookCategory();
            $bookcate->name = $cate;
            $bookcate->save();
         }

      
    }
}
