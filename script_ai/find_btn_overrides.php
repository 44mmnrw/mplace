<?php

echo "=== ПОИСК ПЕРЕОПРЕДЕЛЕНИЙ БАЗОВЫХ СТИЛЕЙ КНОПОК ===\n\n";

$baseProperties = [
    'padding' => '8px 16px',
    'border-radius' => '10px',
    'font-size' => '14px',
    'line-height' => '20px',
];

$files = glob(__DIR__ . '/../resources/css/*.css');

$conflicts = [];

foreach ($files as $file) {
    $fileName = basename($file);
    if ($fileName === 'base.css') continue; // Пропускаем base.css
    
    $content = file_get_contents($file);
    
    // Ищем правила для .btn (но не .btn-primary, .btn-secondary и т.д.)
    if (preg_match_all('/(\.btn(?!-)[^{]*)\{([^}]+)\}/s', $content, $matches, PREG_OFFSET_CAPTURE)) {
        foreach ($matches[0] as $index => $match) {
            $fullMatch = $match[0];
            $position = $match[1];
            $selector = trim($matches[1][$index][0]);
            $properties = $matches[2][$index][0];
            
            // Подсчитываем номер строки
            $lineNum = substr_count(substr($content, 0, $position), "\n") + 1;
            
            // Проверяем наличие базовых свойств
            $foundProps = [];
            foreach ($baseProperties as $prop => $baseValue) {
                if (preg_match('/' . preg_quote($prop, '/') . '\s*:\s*([^;]+)/i', $properties, $propMatch)) {
                    $foundValue = trim($propMatch[1]);
                    if ($foundValue !== $baseValue) {
                        $foundProps[$prop] = $foundValue;
                    }
                }
            }
            
            if (!empty($foundProps)) {
                $conflicts[] = [
                    'file' => $fileName,
                    'line' => $lineNum,
                    'selector' => $selector,
                    'properties' => $foundProps,
                    'full' => trim($fullMatch)
                ];
            }
        }
    }
}

if (empty($conflicts)) {
    echo "✅ Конфликтов не найдено! Все кнопки используют базовые стили.\n";
} else {
    echo "⚠️  Найдены конфликты:\n\n";
    foreach ($conflicts as $conflict) {
        echo "╔═══════════════════════════════════════════\n";
        echo "║ {$conflict['file']} (строка {$conflict['line']})\n";
        echo "╚═══════════════════════════════════════════\n";
        echo "Селектор: {$conflict['selector']}\n";
        echo "Переопределяет:\n";
        foreach ($conflict['properties'] as $prop => $value) {
            echo "  - $prop: $value (должно быть: {$baseProperties[$prop]})\n";
        }
        echo "\nПолное правило:\n{$conflict['full']}\n\n";
    }
}
