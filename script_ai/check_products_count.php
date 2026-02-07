<?php
require_once __DIR__ . '/../bootstrap/app.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use App\Models\ProductImage;

echo "=== Проверка данных ===\n";
echo "Всего мастер-классов: " . Product::count() . "\n";
echo "Всего изображений: " . ProductImage::count() . "\n";
echo "Мастер-классы:\n";

Product::with('mainImage', 'images')->each(function ($product) {
    echo "  - {$product->id}: {$product->title} (изображений: {$product->images->count()})\n";
    if ($product->mainImage) {
        echo "    Основное изображение: {$product->mainImage->image_file}\n";
    }
});
