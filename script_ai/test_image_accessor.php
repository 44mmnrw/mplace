<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Проверка ProductImage accessor:\n";
echo "=================================\n\n";

$image = \App\Models\ProductImage::first();

if ($image) {
    echo "ID: {$image->id}\n";
    echo "image_path: " . ($image->image_path ?? 'NULL') . "\n";
    echo "image_url: {$image->image_url}\n";
    echo "Является заглушкой: " . (str_starts_with($image->image_url, 'placeholder:') ? 'ДА' : 'НЕТ') . "\n";
} else {
    echo "В БД нет изображений\n";
}
