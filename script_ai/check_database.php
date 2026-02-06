<?php
/**
 * Скрипт для проверки структуры базы данных
 * Показывает таблицы, поля, индексы и внешние ключи
 * 
 * Использование: php script_ai/check_database.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "\n" . str_repeat("=", 80) . "\n";
echo "ПРОВЕРКА СТРУКТУРЫ БАЗЫ ДАННЫХ\n";
echo str_repeat("=", 80) . "\n\n";

// Информация о подключении
$connection = DB::connection();
$config = config('database.connections.' . config('database.default'));

echo "📊 Подключение:\n";
echo "   Драйвер: {$config['driver']}\n";
echo "   База данных: {$config['database']}\n";
if (isset($config['host'])) {
    echo "   Хост: {$config['host']}:{$config['port']}\n";
    echo "   Пользователь: {$config['username']}\n";
}
echo "\n";

// Получаем список таблиц
$tables = DB::select('SHOW TABLES');
$databaseName = $config['database'];
$tableKey = "Tables_in_{$databaseName}";

echo "📋 Всего таблиц: " . count($tables) . "\n\n";

foreach ($tables as $table) {
    $tableName = $table->$tableKey;
    
    echo str_repeat("-", 80) . "\n";
    echo "📌 Таблица: {$tableName}\n";
    echo str_repeat("-", 80) . "\n";
    
    // Получаем структуру таблицы
    $columns = DB::select("SHOW FULL COLUMNS FROM `{$tableName}`");
    
    echo "\n  Поля:\n";
    echo "  " . str_pad("Название", 25) . str_pad("Тип", 20) . str_pad("Null", 8) . str_pad("Ключ", 8) . "По умолчанию\n";
    echo "  " . str_repeat("-", 75) . "\n";
    
    foreach ($columns as $column) {
        $field = str_pad($column->Field, 25);
        $type = str_pad($column->Type, 20);
        $null = str_pad($column->Null === 'YES' ? 'Да' : 'Нет', 8);
        $key = str_pad($column->Key ?: '-', 8);
        $default = $column->Default ?? 'NULL';
        
        echo "  {$field}{$type}{$null}{$key}{$default}\n";
    }
    
    // Получаем индексы
    $indexes = DB::select("SHOW INDEXES FROM `{$tableName}`");
    if (!empty($indexes)) {
        echo "\n  Индексы:\n";
        $indexGroups = [];
        foreach ($indexes as $index) {
            $indexGroups[$index->Key_name][] = $index;
        }
        
        foreach ($indexGroups as $keyName => $indexParts) {
            $columns = array_map(fn($i) => $i->Column_name, $indexParts);
            $unique = $indexParts[0]->Non_unique == 0 ? 'UNIQUE' : '';
            $type = $indexParts[0]->Key_name === 'PRIMARY' ? 'PRIMARY KEY' : ($unique ? 'UNIQUE' : 'INDEX');
            
            echo "  - {$type}: {$keyName} (" . implode(', ', $columns) . ")\n";
        }
    }
    
    // Получаем внешние ключи
    $foreignKeys = DB::select("
        SELECT 
            CONSTRAINT_NAME,
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_NAME = ?
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ", [$databaseName, $tableName]);
    
    if (!empty($foreignKeys)) {
        echo "\n  Внешние ключи:\n";
        foreach ($foreignKeys as $fk) {
            echo "  - {$fk->CONSTRAINT_NAME}: {$fk->COLUMN_NAME} → {$fk->REFERENCED_TABLE_NAME}({$fk->REFERENCED_COLUMN_NAME})\n";
        }
    }
    
    // Количество записей
    $count = DB::table($tableName)->count();
    echo "\n  📊 Записей в таблице: {$count}\n";
    
    echo "\n";
}

echo str_repeat("=", 80) . "\n";
echo "✅ Проверка завершена\n";
echo str_repeat("=", 80) . "\n\n";
