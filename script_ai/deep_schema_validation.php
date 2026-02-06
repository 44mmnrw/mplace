<?php
/**
 * ГЛУБОКАЯ ПРОВЕРКА ВСЕХ ПОЛЕЙ ВСЕХ ТАБЛИЦ С DBML-СХЕМОЙ
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pdo = DB::connection()->getPdo();

// Определяем ТОЧНУЮ структуру полей из DBML для каждой таблицы
$expectedStructure = [
    'products' => [
        'id' => 'bigint unsigned',
        'shop_id' => 'bigint unsigned',
        'author_id' => 'bigint unsigned',
        'primary_category_id' => 'bigint unsigned',
        'title' => 'varchar(255)',
        'slug' => 'varchar(255)',
        'sku' => 'varchar(100)',
        'short_description' => 'varchar(500)',
        'description' => 'text',
        'files' => 'json',
        'auto_delivery' => 'tinyint(1)',
        'delivery_instructions' => 'text',
        'format' => 'varchar(50)',
        'language' => 'varchar(10)',
        'materials' => 'json',
        'requirements' => 'json',
        'what_you_learn' => 'json',
        'current_price' => 'decimal(10,2)',
        'current_old_price' => 'decimal(10,2)',
        'currency' => 'varchar(3)',
        'status' => 'varchar(50)',
        'is_active' => 'tinyint(1)',
        'is_featured' => 'tinyint(1)',
        'views_count' => 'int',
        'sales_count' => 'int',
        'rating' => 'decimal(3,2)',
        'reviews_count' => 'int',
        'stock_quantity' => 'int',
        'is_digital' => 'tinyint(1)',
        'meta_title' => 'varchar(255)',
        'meta_description' => 'text',
        'meta_keywords' => 'text',
        'published_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ],
    'product_images' => [
        'id' => 'bigint unsigned',
        'product_id' => 'bigint unsigned',
        'image_path' => 'varchar(500)',
        'is_main' => 'tinyint(1)',
        'sort_order' => 'int',
        'alt_text' => 'varchar(255)',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ],
];

// Недопустимые поля, которых НЕ ДОЛЖНО быть
$forbiddenFields = [
    'products' => ['images', 'main_image', 'video_url', 'duration', 'difficulty_level', 
                   'old_price', 'max_participants', 'min_participants', 'starts_at', 
                   'ends_at', 'content', 'category_id', 'seller_id', 'favorites_count', 
                   'purchases_count'],
];

echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "  ГЛУБОКАЯ ПРОВЕРКА СООТВЕТСТВИЯ СТРУКТУРЫ БД С DBML-СХЕМОЙ\n";
echo "═══════════════════════════════════════════════════════════════════════════\n\n";

$errors = [];
$warnings = [];

foreach ($expectedStructure as $tableName => $expectedFields) {
    echo "🔍 Проверка таблицы: $tableName\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    // Получаем текущую структуру
    $stmt = $pdo->query("DESCRIBE `$tableName`");
    $actualFields = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $actualFields[$row['Field']] = $row['Type'];
    }
    
    // Проверяем недостающие поля
    foreach ($expectedFields as $field => $type) {
        if (!isset($actualFields[$field])) {
            $errors[] = "❌ $tableName.$field - ПОЛЕ ОТСУТСТВУЕТ (ожидается: $type)";
            echo "  ❌ $field - ОТСУТСТВУЕТ (должно быть: $type)\n";
        }
    }
    
    // Проверяем лишние поля
    if (isset($forbiddenFields[$tableName])) {
        foreach ($forbiddenFields[$tableName] as $forbidden) {
            if (isset($actualFields[$forbidden])) {
                $errors[] = "❌ $tableName.$forbidden - ЛИШНЕЕ ПОЛЕ (должно быть удалено)";
                echo "  ❌ $forbidden - ЛИШНЕЕ ПОЛЕ (надо удалить)\n";
            }
        }
    }
    
    // Проверяем все существующие поля
    foreach ($actualFields as $field => $actualType) {
        if (isset($expectedFields[$field])) {
            // Нормализуем типы для сравнения
            $normalizedActual = strtolower(preg_replace('/\s+/', '', $actualType));
            $normalizedExpected = strtolower(preg_replace('/\s+/', '', $expectedFields[$field]));
            
            // Игнорируем различия в unsigned/signed для проверки
            $normalizedActual = str_replace('unsigned', '', $normalizedActual);
            $normalizedExpected = str_replace('unsigned', '', $normalizedExpected);
            
            if ($normalizedActual !== $normalizedExpected && 
                !str_contains($normalizedActual, $normalizedExpected)) {
                $warnings[] = "⚠️  $tableName.$field - несоответствие типа (есть: $actualType, ожидается: {$expectedFields[$field]})";
                echo "  ⚠️  $field - тип: $actualType (ожидается: {$expectedFields[$field]})\n";
            } else {
                echo "  ✅ $field - OK\n";
            }
        }
    }
    
    echo "\n";
}

echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "  ИТОГОВЫЙ ОТЧЕТ\n";
echo "═══════════════════════════════════════════════════════════════════════════\n\n";

if (empty($errors) && empty($warnings)) {
    echo "🎉 ВСЕ ОТЛИЧНО! Структура полностью соответствует DBML-схеме.\n\n";
} else {
    echo "КРИТИЧЕСКИЕ ОШИБКИ (" . count($errors) . "):\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    foreach ($errors as $error) {
        echo "$error\n";
    }
    echo "\n";
    
    if (!empty($warnings)) {
        echo "ПРЕДУПРЕЖДЕНИЯ (" . count($warnings) . "):\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        foreach ($warnings as $warning) {
            echo "$warning\n";
        }
        echo "\n";
    }
}
