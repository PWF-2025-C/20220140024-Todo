<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['title' => 'Category 1']);
        Category::create(['title' => 'Category 2']);
        Category::create(['title' => 'Category 3']);
    }
}
