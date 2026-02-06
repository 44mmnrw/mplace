<?php

echo "=== ГЛУБОКАЯ ПРОВЕРКА ВСЕХ CSS ПРАВИЛ ===\n\n";

$cssFiles = [
    'reset.css',
    'base.css',
    'header.css',
    'welcome.css',
];

foreach ($cssFiles as $fileName) {
    $path = __DIR__ . '/../resources/css/' . $fileName;
    echo "╔═══════════════════════════════════════════\n";
    echo "║ $fileName\n";
    echo "╚═══════════════════════════════════════════\n\n";
    
    if (!file_exists($path)) {
        echo "Файл не найден!\n\n";
        continue;
    }
    
    $content = file_get_contents($path);
    $lines = explode("\n", $content);
    
    // Ищем все правила с margin
    $inRule = false;
    $currentSelector = '';
    $currentRule = [];
    $lineNum = 0;
    
    foreach ($lines as $line) {
        $lineNum++;
        $trimmed = trim($line);
        
        // Начало правила
        if (preg_match('/^([^{]+)\{/', $trimmed, $matches)) {
            $currentSelector = trim($matches[1]);
            $inRule = true;
            $currentRule = ['selector' => $currentSelector, 'line' => $lineNum, 'props' => []];
        }
        
        // Свойство внутри правила
        if ($inRule && preg_match('/margin/', $trimmed)) {
            $currentRule['props'][] = $trimmed;
        }
        
        // Конец правила
        if ($inRule && strpos($trimmed, '}') !== false) {
            if (!empty($currentRule['props'])) {
                echo "Строка {$currentRule['line']}: {$currentRule['selector']}\n";
                foreach ($currentRule['props'] as $prop) {
                    echo "  → $prop\n";
                }
                echo "\n";
            }
            $inRule = false;
            $currentRule = [];
        }
    }
}

echo "\n=== ПРОВЕРКА ПРАВИЛ ДЛЯ ССЫЛОК И КНОПОК ===\n\n";

foreach ($cssFiles as $fileName) {
    $path = __DIR__ . '/../resources/css/' . $fileName;
    if (!file_exists($path)) continue;
    
    $content = file_get_contents($path);
    
    // Ищем правила для a, button, .btn
    if (preg_match_all('/^([^{]*(?:a\[|a:|a\s|button|\.btn)[^{]*)\{([^}]+)\}/m', $content, $matches, PREG_SET_ORDER)) {
        echo "--- $fileName ---\n";
        foreach ($matches as $match) {
            echo "Селектор: " . trim($match[1]) . "\n";
            echo "Свойства: " . trim($match[2]) . "\n\n";
        }
    }
}
