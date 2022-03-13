<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::create(['title' => 'أمراض القلب وأعراضه','image' => 'category_1.jpg']);
        Category::create(['title' => 'معلومات عن القلب','image' => 'category_1.jpg']);
        Category::create(['title' => 'رجيم وغذاء مرضى القلب','image' => 'category_1.jpg']);
        Category::create(['title' => 'ابحاث علمية عن القلب','image' => 'category_1.jpg']);
    }
}
