<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;

echo "=== Проверка связи Products -> Authors ===\n\n";

// Проверяем продукты
$products = DB::table('products')
    ->select('id', 'title', 'author_id', 'status')
    ->limit(5)
    ->get();

echo "📦 Продукты в БД:\n";
foreach ($products as $product) {
    echo "  ID: {$product->id} | Title: {$product->title} | Author ID: " . ($product->author_id ?? 'NULL') . " | Status: {$product->status}\n";
}

echo "\n👤 Авторы в БД:\n";
$authors = DB::table('authors')->select('id', 'user_id', 'display_name', 'avatar')->get();
foreach ($authors as $author) {
    echo "  ID: {$author->id} | User ID: {$author->user_id} | Name: {$author->display_name} | Avatar: " . ($author->avatar ?? 'NULL') . "\n";
}

echo "\n=== Проверка через Eloquent ===\n";
$product = Product::with('author')->where('status', 'published')->first();

if ($product) {
    echo "✅ Найден продукт: {$product->title}\n";
    echo "   Author ID в продукте: " . ($product->author_id ?? 'NULL') . "\n";
    
    if ($product->author) {
        echo "✅ Автор загружен: {$product->author->display_name}\n";
        echo "   Avatar: " . ($product->author->avatar ?? 'NULL') . "\n";
    } else {
        echo "❌ Автор НЕ загружен (связь не работает)\n";
    }
} else {
    echo "❌ Нет опубликованных продуктов\n";
}
