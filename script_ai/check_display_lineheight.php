<?php

echo "=== ПРОВЕРКА DISPLAY И LINE-HEIGHT ДЛЯ КНОПОК ===\n\n";

$files = [
    'base.css' => __DIR__ . '/../resources/css/base.css',
    'header.css' => __DIR__ . '/../resources/css/header.css',
    'welcome.css' => __DIR__ . '/../resources/css/welcome.css',
    'reset.css' => __DIR__ . '/../resources/css/reset.css',
];

foreach ($files as $name => $path) {
    echo "╔════════════════════════════\n";
    echo "║ $name\n";
    echo "╚════════════════════════════\n";
    
    if (!file_exists($path)) {
        echo "Файл не найден!\n\n";
        continue;
    }
    
    $content = file_get_contents($path);
    $lines = explode("\n", $content);
    
    $inBtnRule = false;
    $currentRule = '';
    $buffer = [];
    
    foreach ($lines as $lineNum => $line) {
        $trimmed = trim($line);
        
        // Проверяем начало правила для кнопок или ссылок
        if (preg_match('/^(\.btn|a:|a\[|body\s*\{)/', $trimmed)) {
            $inBtnRule = true;
            $buffer = [];
            $currentRule = $trimmed;
        }
        
        if ($inBtnRule) {
            $buffer[] = $line;
            
            if (strpos($trimmed, '}') !== false) {
                // Вывести правило если содержит display, line-height или vertical-align
                $fullRule = implode("\n", $buffer);
                if (preg_match('/(display|line-height|vertical-align)/', $fullRule)) {
                    echo "Строка " . ($lineNum - count($buffer) + 2) . ":\n";
                    echo implode("\n", $buffer) . "\n\n";
                }
                $inBtnRule = false;
                $buffer = [];
            }
        }
    }
    
    echo "\n";
}

echo "=== ВЫВОД ===\n";
echo "Проблема может быть в:\n";
echo "1. Разный display (inline-flex vs inline-block)\n";
echo "2. Разный line-height\n";
echo "3. Разный vertical-align\n";
echo "4. body { line-height: 1.5 } из reset.css применяется к кнопкам\n";
