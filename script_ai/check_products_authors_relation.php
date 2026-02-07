<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Проверка связей Products <-> Authors ===\n\n";

echo "📦 Продукты с author_id:\n";
$products = DB::table('products')
    ->select('id', 'title', 'author_id', 'status')
    ->get();

foreach ($products as $product) {
    echo "  ID: {$product->id} | {$product->title} | Author ID: " . ($product->author_id ?? 'NULL') . " | Status: {$product->status}\n";
}

echo "\n👤 Авторы:\n";
$authors = DB::table('authors')
    ->select('id', 'user_id', 'display_name')
    ->get();

foreach ($authors as $author) {
    echo "  Author ID: {$author->id} | User ID: {$author->user_id} | Name: {$author->display_name}\n";
}

echo "\n❗ Несоответствия:\n";
$orphanProducts = DB::table('products as p')
    ->leftJoin('authors as a', 'p.author_id', '=', 'a.id')
    ->whereNotNull('p.author_id')
    ->whereNull('a.id')
    ->select('p.id', 'p.title', 'p.author_id')
    ->get();

if ($orphanProducts->count() > 0) {
    foreach ($orphanProducts as $p) {
        echo "  ❌ Product ID: {$p->id} ({$p->title}) ссылается на несуществующего автора ID: {$p->author_id}\n";
    }
} else {
    echo "  ✅ Все продукты корректно связаны с авторами\n";
}
