<?php
require_once __DIR__ . '/../bootstrap/app.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

echo "=== Проверка путей изображений ===\n\n";

$images = ProductImage::with('product')->get();
echo "Всего изображений в БД: " . $images->count() . "\n\n";

foreach ($images as $image) {
    echo "ID: {$image->id}, Product: {$image->product->title}\n";
    echo "  image_path: " . $image->image_path . "\n";
    echo "  image_url: " . $image->image_url . "\n";
    echo "  thumb: " . $image->getThumbnailUrl('thumb') . "\n";
    echo "  medium: " . $image->getThumbnailUrl('medium') . "\n";
    echo "  large: " . $image->getThumbnailUrl('large') . "\n";
    
    // Проверяем существование файлов
    echo "  Файлы в storage:\n";
    echo "    originals: " . (Storage::disk('public')->exists($image->image_path) ? "✓" : "✗") . "\n";
    
    $thumbPath = str_replace('/originals/', '/thumb/', str_replace('/originals\\', '/thumb\\', $image->image_path));
    $thumbPath = preg_replace('/\/([^\/]+)\./', '/-thumb.', $thumbPath);
    $thumbPath = str_replace('originals/', 'thumb/', $image->image_path);
    $thumbPath = preg_replace('/\/([^\/]+)\./', '/$1-thumb.', $thumbPath);
    
    echo "\n";
}
