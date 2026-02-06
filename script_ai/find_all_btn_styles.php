<?php

echo "=== ПОЛНАЯ ДИАГНОСТИКА ВСЕХ СТИЛЕЙ КНОПОК ===\n\n";

$files = glob(__DIR__ . '/../resources/css/*.css');

foreach ($files as $file) {
    $fileName = basename($file);
    $content = file_get_contents($file);
    
    // Ищем все правила для .btn, .btn-primary, .btn-secondary
    $patterns = [
        '\.btn(?!-)' => 'BASE .btn',
        '\.btn-primary' => '.btn-primary',
        '\.btn-secondary' => '.btn-secondary',
    ];
    
    foreach ($patterns as $pattern => $label) {
        if (preg_match_all('/(' . $pattern . '[^{]*)\{([^}]+)\}/s', $content, $matches, PREG_OFFSET_CAPTURE)) {
            echo "╔═══════════════════════════════════════════\n";
            echo "║ $fileName → $label\n";
            echo "╚═══════════════════════════════════════════\n";
            
            foreach ($matches[0] as $index => $match) {
                $fullMatch = $match[0];
                $position = $match[1];
                
                // Подсчитываем номер строки
                $lineNum = substr_count(substr($content, 0, $position), "\n") + 1;
                
                echo "Строка $lineNum:\n";
                echo trim($fullMatch) . "\n\n";
            }
        }
    }
}

echo "\n=== АНАЛИЗ КОНФЛИКТОВ ===\n\n";

// Собираем все свойства для каждого класса
$properties = [
    '.btn' => [],
    '.btn-primary' => [],
    '.btn-secondary' => [],
];

foreach ($files as $file) {
    $fileName = basename($file);
    $content = file_get_contents($file);
    
    foreach ($properties as $className => &$props) {
        $pattern = preg_quote($className, '/');
        if ($className === '.btn') {
            $pattern = '\.btn(?!-)';
        }
        
        if (preg_match_all('/(' . $pattern . '[^{]*)\{([^}]+)\}/s', $content, $matches)) {
            foreach ($matches[2] as $ruleContent) {
                // Парсим свойства
                $lines = explode(';', $ruleContent);
                foreach ($lines as $line) {
                    if (preg_match('/^\s*([a-z-]+)\s*:\s*(.+)$/i', trim($line), $propMatch)) {
                        $propName = trim($propMatch[1]);
                        $propValue = trim($propMatch[2]);
                        
                        if (!isset($props[$propName])) {
                            $props[$propName] = [];
                        }
                        $props[$propName][] = [
                            'file' => $fileName,
                            'value' => $propValue
                        ];
                    }
                }
            }
        }
    }
}

// Выводим конфликты
foreach ($properties as $className => $props) {
    echo "--- $className ---\n";
    foreach ($props as $propName => $values) {
        if (count($values) > 1) {
            $uniqueValues = array_unique(array_column($values, 'value'));
            if (count($uniqueValues) > 1) {
                echo "⚠️  КОНФЛИКТ в '$propName':\n";
                foreach ($values as $val) {
                    echo "   {$val['file']}: {$val['value']}\n";
                }
                echo "\n";
            }
        }
    }
    echo "\n";
}
