<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class SeedCategories extends Command
{
    protected $signature = 'seed:categories';
    protected $description = 'Заполнить категории';

    public function handle()
    {
        $categories = [
            'Рукоделие',
            'Вязание',
            'Шитье',
            'Вышивка',
            'Кулинария',
            'Декор',
        ];

        foreach ($categories as $index => $name) {
            Category::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                [
                    'name' => $name,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }

        $this->info('✓ Категории готовы!');
    }
}
