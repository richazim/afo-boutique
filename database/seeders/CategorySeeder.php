<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = require database_path('data/categories.php');

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']], // unique key
                $category
            );
        }
    }
}
