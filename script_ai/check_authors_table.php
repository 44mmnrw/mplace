<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Структура таблицы authors ===\n\n";

$columns = DB::select('SHOW COLUMNS FROM authors');

foreach ($columns as $col) {
    $nullable = $col->Null === 'YES' ? 'NULL' : 'NOT NULL';
    $default = $col->Default ? "DEFAULT: {$col->Default}" : '';
    echo sprintf("%-25s %-30s %-10s %s\n", $col->Field, $col->Type, $nullable, $default);
}

echo "\n=== Проверка записей в authors ===\n\n";
$authors = DB::table('authors')->get();
if ($authors->count() > 0) {
    foreach ($authors as $author) {
        echo "ID: {$author->id}\n";
        echo "Display Name: {$author->display_name}\n";
        echo "Avatar: " . ($author->avatar ?? 'NULL') . "\n";
        echo "---\n";
    }
} else {
    echo "Нет записей в таблице authors\n";
}
