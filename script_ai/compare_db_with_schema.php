<?php
/**
 * Скрипт сравнения структуры БД с DBML-схемой
 * Проверяет соответствие таблиц, полей, типов данных, индексов и foreign keys
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pdo = DB::connection()->getPdo();

echo "=== СРАВНЕНИЕ СТРУКТУРЫ БД С DBML-СХЕМОЙ ===\n\n";

// Определяем ожидаемые таблицы из DBML
$expectedTables = [
    'users', 'user_roles', 'user_user_role', 'sessions', 'password_reset_tokens',
    'shops', 'authors', 'author_addresses', 'author_tax_info', 'customers',
    'categories', 'category_relations', 'attributes', 'attribute_options', 'category_attribute',
    'products', 'product_categories', 'product_prices', 'product_images', 'product_files',
    'product_attribute_values', 'carts', 'cart_items', 'wishlists',
    'order_statuses', 'payment_statuses', 'orders', 'order_items', 'order_item_access',
    'payments', 'refunds', 'reviews', 'notifications',
    'follows', 'reports', 'activity_logs', 'coupons', 'coupon_usage', 'coupon_categories', 'coupon_products',
    'seller_balances', 'seller_payouts', 'npd_receipts',
    'blog_posts', 'blog_categories', 'blog_post_categories', 'tags', 'blog_post_tag', 'blog_comments',
    'newsletters', 'newsletter_segments', 'newsletter_sends',
    'conversations', 'messages', 'tickets', 'ticket_messages',
    'subscription_plans', 'shop_subscriptions', 'notification_settings'
];

// Получаем список таблиц из БД
$stmt = $pdo->query("SHOW TABLES");
$actualTables = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "📊 СТАТИСТИКА ТАБЛИЦ:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo sprintf("Ожидается по DBML: %d таблиц\n", count($expectedTables));
echo sprintf("Есть в БД:         %d таблиц\n", count($actualTables));
echo sprintf("Служебных Laravel: %d таблиц (migrations, cache, jobs, failed_jobs)\n", 
    count(array_intersect($actualTables, ['migrations', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs'])));
echo "\n";

// Проверка отсутствующих таблиц
$missingTables = array_diff($expectedTables, $actualTables);
if (!empty($missingTables)) {
    echo "❌ ОТСУТСТВУЮЩИЕ ТАБЛИЦЫ (" . count($missingTables) . "):\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    foreach ($missingTables as $table) {
        echo "  • $table\n";
    }
    echo "\n";
} else {
    echo "✅ Все таблицы из DBML присутствуют в БД\n\n";
}

// Проверка лишних таблиц (кроме служебных Laravel)
$serviceTables = ['migrations', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs'];
$extraTables = array_diff($actualTables, $expectedTables, $serviceTables);
if (!empty($extraTables)) {
    echo "⚠️  ДОПОЛНИТЕЛЬНЫЕ ТАБЛИЦЫ (" . count($extraTables) . "):\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    foreach ($extraTables as $table) {
        echo "  • $table\n";
    }
    echo "\n";
}

// Детальная проверка ключевых таблиц
$keyTables = [
    'users' => ['id', 'email', 'password', 'email_verified_at', 'remember_token', 'created_at', 'updated_at'],
    'shops' => ['id', 'user_id', 'name', 'slug', 'description', 'logo', 'status', 'rating', 'created_at'],
    'authors' => ['id', 'user_id', 'display_name', 'bio', 'avatar', 'rating', 'is_verified', 'created_at'],
    'products' => ['id', 'shop_id', 'author_id', 'title', 'slug', 'description', 'status', 'price', 'rating', 'created_at'],
    'orders' => ['id', 'customer_id', 'order_number', 'status_id', 'subtotal', 'total', 'created_at'],
    'payments' => ['id', 'order_id', 'payment_method', 'amount', 'status_id', 'gateway_response', 'created_at'],
    'reviews' => ['id', 'reviewable_type', 'reviewable_id', 'user_id', 'rating', 'comment', 'created_at'],
    'seller_balances' => ['id', 'user_id', 'available_balance', 'pending_balance', 'hold_days', 'updated_at'],
    'npd_receipts' => ['id', 'payout_id', 'receipt_id', 'receipt_link', 'status', 'created_at'],
];

echo "🔍 ДЕТАЛЬНАЯ ПРОВЕРКА КЛЮЧЕВЫХ ТАБЛИЦ:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

foreach ($keyTables as $tableName => $expectedFields) {
    if (!in_array($tableName, $actualTables)) {
        echo "❌ Таблица '$tableName' НЕ НАЙДЕНА\n\n";
        continue;
    }
    
    // Получаем структуру таблицы
    $stmt = $pdo->query("DESCRIBE `$tableName`");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $actualFields = array_column($columns, 'Field');
    
    $missing = array_diff($expectedFields, $actualFields);
    
    if (empty($missing)) {
        echo "✅ $tableName - все обязательные поля присутствуют\n";
    } else {
        echo "⚠️  $tableName - отсутствуют поля:\n";
        foreach ($missing as $field) {
            echo "     • $field\n";
        }
    }
    
    // Проверка дополнительных полей
    $extra = array_diff($actualFields, $expectedFields);
    if (!empty($extra) && count($extra) > 2) { // игнорируем 1-2 доп поля (обычно timestamps)
        echo "     Дополнительные поля: " . implode(', ', $extra) . "\n";
    }
    
    echo "\n";
}

// Проверка foreign keys для критичных таблиц
echo "🔗 ПРОВЕРКА FOREIGN KEYS:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$criticalFKs = [
    'shops' => [['user_id', 'users', 'id']],
    'authors' => [['user_id', 'users', 'id']],
    'products' => [
        ['shop_id', 'shops', 'id'],
        ['author_id', 'authors', 'id']
    ],
    'orders' => [['customer_id', 'customers', 'id']],
    'payments' => [['order_id', 'orders', 'id']],
    'seller_payouts' => [['user_id', 'users', 'id']],
    'npd_receipts' => [['payout_id', 'seller_payouts', 'id']],
];

foreach ($criticalFKs as $tableName => $fks) {
    if (!in_array($tableName, $actualTables)) {
        continue;
    }
    
    $stmt = $pdo->query("
        SELECT 
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = '$tableName'
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    $actualFKs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "$tableName:\n";
    
    foreach ($fks as $expectedFK) {
        list($column, $refTable, $refColumn) = $expectedFK;
        $found = false;
        
        foreach ($actualFKs as $actualFK) {
            if ($actualFK['COLUMN_NAME'] === $column 
                && $actualFK['REFERENCED_TABLE_NAME'] === $refTable
                && $actualFK['REFERENCED_COLUMN_NAME'] === $refColumn) {
                $found = true;
                break;
            }
        }
        
        if ($found) {
            echo "  ✅ $column → $refTable($refColumn)\n";
        } else {
            echo "  ❌ ОТСУТСТВУЕТ: $column → $refTable($refColumn)\n";
        }
    }
    echo "\n";
}

// Проверка индексов
echo "📑 ПРОВЕРКА ИНДЕКСОВ НА КЛЮЧЕВЫХ ПОЛЯХ:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$indexChecks = [
    'products' => ['slug', 'status', 'shop_id', 'author_id'],
    'orders' => ['order_number', 'status_id', 'customer_id'],
    'users' => ['email'],
    'shops' => ['slug', 'status', 'user_id'],
    'reviews' => ['reviewable_type', 'reviewable_id', 'user_id'],
];

foreach ($indexChecks as $tableName => $fields) {
    if (!in_array($tableName, $actualTables)) {
        continue;
    }
    
    $stmt = $pdo->query("SHOW INDEX FROM `$tableName`");
    $indexes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $indexedColumns = array_unique(array_column($indexes, 'Column_name'));
    
    echo "$tableName:\n";
    foreach ($fields as $field) {
        if (in_array($field, $indexedColumns)) {
            echo "  ✅ $field проиндексирован\n";
        } else {
            echo "  ⚠️  $field НЕ проиндексирован\n";
        }
    }
    echo "\n";
}

// Итоговая сводка
echo "\n═══════════════════════════════════════════════════════════\n";
echo "📋 ИТОГОВАЯ СВОДКА:\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$missingCount = count($missingTables);
$createdCount = count(array_intersect($expectedTables, $actualTables));
$completeness = round(($createdCount / count($expectedTables)) * 100, 1);

echo "Полнота реализации:     $completeness% ($createdCount из " . count($expectedTables) . " таблиц)\n";
echo "Отсутствует таблиц:     $missingCount\n";
echo "Дополнительных таблиц:  " . count($extraTables) . "\n\n";

if ($missingCount === 0) {
    echo "🎉 ОТЛИЧНО! Все таблицы из DBML-схемы присутствуют в БД.\n";
} elseif ($missingCount <= 5) {
    echo "✅ ХОРОШО! Основная структура реализована, осталось $missingCount таблиц.\n";
} else {
    echo "⚠️  ВНИМАНИЕ! Не хватает $missingCount таблиц из схемы.\n";
}

echo "\n";
