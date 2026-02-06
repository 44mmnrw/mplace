<?php

echo "=== ПОИСК ПЕРЕОПРЕДЕЛЕНИЙ БАЗОВЫХ СТИЛЕЙ В .btn-* КЛАССАХ ===\n\n";

$baseProperties = [
    'padding',
    'border-radius',
    'font-size',
    'line-height',
];

$files = glob(__DIR__ . '/../resources/css/*.css');

$overrides = [];

foreach ($files as $file) {
    $fileName = basename($file);
    if ($fileName === 'base.css') continue;
    
    $content = file_get_contents($file);
    
    // Ищем правила для .btn-primary, .btn-secondary и т.д.
    if (preg_match_all('/(\.btn-[a-z]+[^{]*)\{([^}]+)\}/s', $content, $matches, PREG_OFFSET_CAPTURE)) {
        foreach ($matches[0] as $index => $match) {
            $fullMatch = $match[0];
            $position = $match[1];
            $selector = trim($matches[1][$index][0]);
            $properties = $matches[2][$index][0];
            
            $lineNum = substr_count(substr($content, 0, $position), "\n") + 1;
            
            // Проверяем наличие базовых свойств
            $foundProps = [];
            foreach ($baseProperties as $prop) {
                if (preg_match('/' . preg_quote($prop, '/') . '\s*:\s*([^;]+)/i', $properties, $propMatch)) {
                    $foundProps[$prop] = trim($propMatch[1]);
                }
            }
            
            if (!empty($foundProps)) {
                $overrides[] = [
                    'file' => $fileName,
                    'line' => $lineNum,
                    'selector' => $selector,
                    'properties' => $foundProps
                ];
            }
        }
    }
}

if (empty($overrides)) {
    echo "✅ Переопределений базовых стилей не найдено!\n";
} else {
    echo "Найдены переопределения базовых стилей:\n\n";
    foreach ($overrides as $override) {
        echo "╔═══════════════════════════════════════════\n";
        echo "║ {$override['file']} (строка {$override['line']})\n";
        echo "╚═══════════════════════════════════════════\n";
        echo "Селектор: {$override['selector']}\n";
        echo "Переопределяет:\n";
        foreach ($override['properties'] as $prop => $value) {
            echo "  - $prop: $value\n";
        }
        echo "\n";
    }
    
    echo "\n⚠️  РЕКОМЕНДАЦИЯ: Удалите эти свойства, чтобы кнопки использовали базовые стили.\n";
    echo "Оставляйте только цветовые стили (background, color, border-color).\n";
}
