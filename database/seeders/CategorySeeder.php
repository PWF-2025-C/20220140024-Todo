<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Membuat beberapa kategori
        Category::create(['title' => 'Work']);
        Category::create(['title' => 'Personal']);
        Category::create(['title' => 'Shopping']);
    }
}
