<?php

echo "=== Проверка margin для кнопок ===\n\n";

$files = [
    'base.css' => __DIR__ . '/../resources/css/base.css',
    'header.css' => __DIR__ . '/../resources/css/header.css',
    'welcome.css' => __DIR__ . '/../resources/css/welcome.css',
    'reset.css' => __DIR__ . '/../resources/css/reset.css',
];

foreach ($files as $name => $path) {
    echo "--- $name ---\n";
    if (file_exists($path)) {
        $content = file_get_contents($path);
        $lines = explode("\n", $content);
        
        foreach ($lines as $index => $line) {
            if (preg_match('/(\.btn|button|a\s*\{)/', $line) && 
                preg_match('/margin/', $lines[$index] ?? '')) {
                echo "Строка " . ($index + 1) . ": " . trim($line) . "\n";
                // Показать контекст
                for ($i = max(0, $index - 2); $i <= min(count($lines) - 1, $index + 5); $i++) {
                    if ($i === $index) {
                        echo ">>> " . trim($lines[$i]) . "\n";
                    } else {
                        echo "    " . trim($lines[$i]) . "\n";
                    }
                }
                echo "\n";
            }
            
            // Также ищем просто margin в контексте кнопок
            if (stripos($line, 'margin') !== false && 
                (stripos($line, 'btn') !== false || 
                 stripos($line, 'button') !== false)) {
                echo "Найден margin: строка " . ($index + 1) . ": " . trim($line) . "\n";
            }
        }
    }
    echo "\n";
}

echo "=== Проверка reset.css на глобальные стили ===\n";
if (file_exists($files['reset.css'])) {
    $content = file_get_contents($files['reset.css']);
    echo $content;
}
