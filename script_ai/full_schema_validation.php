<?php
/**
 * ПОЛНАЯ ПРОВЕРКА ВСЕХ ТАБЛИЦ И ВСЕХ КОЛОНОК С DBML-СХЕМОЙ
 * Таблица за таблицей, колонка за колонкой
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pdo = DB::connection()->getPdo();

// Читаем DBML файл
$dbmlPath = __DIR__ . '/database/mplace_dbml_schema.dbml';
$dbmlContent = file_get_contents($dbmlPath);

// Парсим DBML и извлекаем таблицы с полями
function parseDBML($content) {
    $tables = [];
    
    // Находим все определения таблиц
    preg_match_all('/Table\s+(\w+)\s*\{([^}]+(?:\{[^}]+\}[^}]*)*)\}/s', $content, $matches);
    
    foreach ($matches[1] as $index => $tableName) {
        $tableContent = $matches[2][$index];
        $fields = [];
        
        // Парсим поля таблицы
        preg_match_all('/^\s*(\w+)\s+([^\[]+)(?:\[([^\]]+)\])?/m', $tableContent, $fieldMatches);
        
        foreach ($fieldMatches[1] as $fIndex => $fieldName) {
            // Пропускаем служебные секции
            if (in_array($fieldName, ['indexes', 'Note', 'Ref'])) continue;
            
            $type = trim($fieldMatches[2][$fIndex]);
            $constraints = isset($fieldMatches[3][$fIndex]) ? $fieldMatches[3][$fIndex] : '';
            
            // Нормализуем тип
            $type = preg_replace('/\s+/', ' ', $type);
            
            $fields[$fieldName] = [
                'type' => $type,
                'constraints' => $constraints,
                'nullable' => !str_contains($constraints, 'not null'),
                'unique' => str_contains($constraints, 'unique'),
                'primary' => str_contains($constraints, 'pk'),
            ];
        }
        
        if (!empty($fields)) {
            $tables[$tableName] = $fields;
        }
    }
    
    return $tables;
}

$expectedTables = parseDBML($dbmlContent);

// Получаем список таблиц из БД
$stmt = $pdo->query("SHOW TABLES");
$actualTablesList = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "  ПОЛНАЯ ПРОВЕРКА БАЗЫ ДАННЫХ СО СХЕМОЙ DBML\n";
echo "  Таблица за таблицей, колонка за колонкой\n";
echo "═══════════════════════════════════════════════════════════════════════════\n\n";

echo "📊 Найдено в DBML: " . count($expectedTables) . " таблиц\n";
echo "📊 Найдено в БД: " . count($actualTablesList) . " таблиц\n\n";

$totalTables = 0;
$totalErrors = 0;
$totalWarnings = 0;
$perfectTables = 0;

foreach ($expectedTables as $tableName => $expectedFields) {
    $totalTables++;
    
    echo "┌─────────────────────────────────────────────────────────────────────────┐\n";
    echo "│ Таблица: " . str_pad($tableName, 63) . "│\n";
    echo "└─────────────────────────────────────────────────────────────────────────┘\n";
    
    // Проверяем существование таблицы
    if (!in_array($tableName, $actualTablesList)) {
        echo "  ❌ ТАБЛИЦА НЕ СУЩЕСТВУЕТ В БД!\n\n";
        $totalErrors++;
        continue;
    }
    
    // Получаем структуру таблицы из БД
    $stmt = $pdo->query("DESCRIBE `$tableName`");
    $actualFields = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $actualFields[$row['Field']] = [
            'type' => $row['Type'],
            'null' => $row['Null'] === 'YES',
            'key' => $row['Key'],
            'default' => $row['Default'],
        ];
    }
    
    $tableErrors = 0;
    $tableWarnings = 0;
    
    // Проверяем каждое поле из DBML
    foreach ($expectedFields as $fieldName => $expectedInfo) {
        $expectedType = $expectedInfo['type'];
        
        if (!isset($actualFields[$fieldName])) {
            echo "  ❌ ПОЛЕ ОТСУТСТВУЕТ: $fieldName (тип: $expectedType)\n";
            $tableErrors++;
            continue;
        }
        
        $actualType = $actualFields[$fieldName]['type'];
        $actualNull = $actualFields[$fieldName]['null'];
        
        // Нормализуем типы для сравнения
        $expectedTypeNorm = strtolower(str_replace(['bigint', 'int ', 'integer'], ['bigint', 'int', 'int'], $expectedType));
        $actualTypeNorm = strtolower($actualType);
        
        // Упрощенное сравнение типов
        $typeMatch = false;
        if (str_contains($expectedTypeNorm, 'varchar')) {
            $typeMatch = str_contains($actualTypeNorm, 'varchar');
        } elseif (str_contains($expectedTypeNorm, 'decimal')) {
            $typeMatch = str_contains($actualTypeNorm, 'decimal');
        } elseif (str_contains($expectedTypeNorm, 'text') || str_contains($expectedTypeNorm, 'longtext')) {
            $typeMatch = str_contains($actualTypeNorm, 'text');
        } elseif (str_contains($expectedTypeNorm, 'json')) {
            $typeMatch = str_contains($actualTypeNorm, 'json');
        } elseif (str_contains($expectedTypeNorm, 'timestamp') || str_contains($expectedTypeNorm, 'datetime')) {
            $typeMatch = str_contains($actualTypeNorm, 'timestamp') || str_contains($actualTypeNorm, 'datetime');
        } elseif (str_contains($expectedTypeNorm, 'boolean') || str_contains($expectedTypeNorm, 'bool')) {
            $typeMatch = str_contains($actualTypeNorm, 'tinyint');
        } elseif (str_contains($expectedTypeNorm, 'bigint')) {
            $typeMatch = str_contains($actualTypeNorm, 'bigint');
        } elseif (str_contains($expectedTypeNorm, 'int')) {
            $typeMatch = str_contains($actualTypeNorm, 'int');
        } else {
            $typeMatch = $expectedTypeNorm === $actualTypeNorm;
        }
        
        if (!$typeMatch) {
            echo "  ⚠️  $fieldName: несоответствие типа\n";
            echo "      Ожидается: $expectedType\n";
            echo "      Реально:   $actualType\n";
            $tableWarnings++;
        }
        
        // Проверяем nullable
        $expectedNull = $expectedInfo['nullable'];
        if ($expectedNull !== $actualNull && $fieldName !== 'id') {
            echo "  ⚠️  $fieldName: несоответствие NULL\n";
            echo "      Ожидается: " . ($expectedNull ? 'NULL' : 'NOT NULL') . "\n";
            echo "      Реально:   " . ($actualNull ? 'NULL' : 'NOT NULL') . "\n";
            $tableWarnings++;
        }
    }
    
    // Проверяем лишние поля в БД
    foreach ($actualFields as $fieldName => $actualInfo) {
        if (!isset($expectedFields[$fieldName])) {
            echo "  ⚠️  ЛИШНЕЕ ПОЛЕ В БД: $fieldName (тип: {$actualInfo['type']})\n";
            $tableWarnings++;
        }
    }
    
    if ($tableErrors === 0 && $tableWarnings === 0) {
        echo "  ✅ ВСЕ ПОЛЯ СООТВЕТСТВУЮТ СХЕМЕ (" . count($expectedFields) . " полей)\n";
        $perfectTables++;
    } else {
        echo "  📊 Итого: $tableErrors ошибок, $tableWarnings предупреждений\n";
    }
    
    echo "\n";
    
    $totalErrors += $tableErrors;
    $totalWarnings += $tableWarnings;
}

// Проверяем таблицы, которые есть в БД, но нет в DBML
$extraTables = array_diff($actualTablesList, array_keys($expectedTables));
$serviceTables = ['migrations', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs'];
$extraTables = array_diff($extraTables, $serviceTables);

if (!empty($extraTables)) {
    echo "┌─────────────────────────────────────────────────────────────────────────┐\n";
    echo "│ ДОПОЛНИТЕЛЬНЫЕ ТАБЛИЦЫ В БД (НЕТ В DBML)                               │\n";
    echo "└─────────────────────────────────────────────────────────────────────────┘\n";
    foreach ($extraTables as $table) {
        echo "  ⚠️  $table\n";
    }
    echo "\n";
}

echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "  ФИНАЛЬНЫЙ ОТЧЕТ\n";
echo "═══════════════════════════════════════════════════════════════════════════\n\n";

echo "📊 Всего таблиц проверено:        $totalTables\n";
echo "✅ Таблиц без ошибок:            $perfectTables\n";
echo "⚠️  Таблиц с предупреждениями:    " . ($totalTables - $perfectTables) . "\n";
echo "❌ Критических ошибок:           $totalErrors\n";
echo "⚠️  Предупреждений:               $totalWarnings\n";
echo "📈 Соответствие схеме:            " . round(($perfectTables / $totalTables) * 100, 1) . "%\n\n";

if ($totalErrors === 0 && $totalWarnings === 0) {
    echo "🎉🎉🎉 ОТЛИЧНО! База данных ПОЛНОСТЬЮ соответствует DBML-схеме! 🎉🎉🎉\n\n";
} elseif ($totalErrors === 0) {
    echo "✅ База данных соответствует DBML-схеме с незначительными отклонениями.\n\n";
} else {
    echo "❌ ВНИМАНИЕ! Обнаружены критические несоответствия!\n\n";
}
