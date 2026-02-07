<?php
require __DIR__ . '/../bootstrap/app.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

$images = ProductImage::limit(5)->get();

echo "=== Проверка путей в БД и файловой системе ===\n\n";

foreach ($images as $image) {
    echo "ID: {$image->id}\n";
    echo "  image_path в БД: {$image->image_path}\n";
    
    echo "  Файл существует: ";
    if (Storage::disk('public')->exists($image->image_path)) {
        echo "✓ ДА\n";
    } else {
        echo "✗ НЕТ\n";
    }
    
    // Проверяем миниатюры
    echo "  Миниатюры:\n";
    foreach (['thumb', 'medium', 'large'] as $size) {
        $thumbUrl = $image->getThumbnailUrl($size);
        // Extract path from asset URL
        $thumbPath = str_replace(asset('storage/'), '', $thumbUrl);
        echo "    {$size}: ";
        if (Storage::disk('public')->exists($thumbPath)) {
            echo "✓ ДА\n";
        } else {
            echo "✗ НЕТ (ищем в: {$thumbPath})\n";
        }
    }
    
    echo "\n";
}
