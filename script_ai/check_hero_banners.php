<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\HeroBannerImage;

echo "=== Проверка картинок hero-баннера ===\n\n";

$images = HeroBannerImage::orderBy('column_number')->orderBy('position')->get();

if ($images->isEmpty()) {
    echo "❌ Картинки не найдены в БД\n";
    echo "\nДля добавления картинок используйте SQL:\n";
    echo "INSERT INTO hero_banner_images (column_number, position, image_path, link_url, is_active, created_at, updated_at)\n";
    echo "VALUES (1, 1, 'products/images/4/2026-02/originals/Tx0ewIV1M89v6pnnQI0FfGBF3O7PwBJllWucBXe6.png', NULL, 1, NOW(), NOW());\n";
    exit;
}

echo "✓ Найдено картинок: " . $images->count() . "\n\n";

echo "Колонка 1 (крутится вниз):\n";
foreach ($images->where('column_number', 1) as $image) {
    $active = $image->is_active ? '✓' : '✗';
    echo "  {$active} Позиция {$image->position}: {$image->image_path}\n";
    echo "     URL: {$image->image_url}\n";
    if ($image->link_url) {
        echo "     Ссылка: {$image->link_url}\n";
    }
}

echo "\nКолонка 2 (крутится вверх):\n";
foreach ($images->where('column_number', 2) as $image) {
    $active = $image->is_active ? '✓' : '✗';
    echo "  {$active} Позиция {$image->position}: {$image->image_path}\n";
    echo "     URL: {$image->image_url}\n";
    if ($image->link_url) {
        echo "     Ссылка: {$image->link_url}\n";
    }
}

echo "\n✓ Проверка завершена\n";
