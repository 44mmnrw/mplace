<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Рукоделие', 'slug' => 'rukodeliye', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Вязание', 'slug' => 'vyazaniye', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Шитье', 'slug' => 'shit\'yo', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Вышивка', 'slug' => 'vyshivka', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'Кулинария', 'slug' => 'kulinariya', 'is_active' => true, 'sort_order' => 5],
            ['name' => 'Декор', 'slug' => 'dekor', 'is_active' => true, 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
