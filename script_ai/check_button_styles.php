<?php

echo "=== Проверка стилей кнопок в хедере ===\n\n";

$files = [
    'base.css' => __DIR__ . '/../resources/css/base.css',
    'header.css' => __DIR__ . '/../resources/css/header.css',
];

foreach ($files as $name => $path) {
    echo "--- $name ---\n";
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        // Ищем стили для .btn
        if (preg_match_all('/\.btn[^{]*\{[^}]+\}/s', $content, $matches)) {
            foreach ($matches[0] as $match) {
                echo $match . "\n\n";
            }
        }
        
        // Ищем стили для .header-nav-right
        if (preg_match_all('/\.header-nav[^{]*\{[^}]+\}/s', $content, $matches)) {
            foreach ($matches[0] as $match) {
                echo $match . "\n\n";
            }
        }
    } else {
        echo "Файл не найден!\n";
    }
    echo "\n";
}

echo "=== Возможные причины разного уровня кнопок ===\n";
echo "1. display: inline-block вместо inline-flex\n";
echo "2. Отсутствие vertical-align: middle\n";
echo "3. Разные padding или line-height\n";
echo "4. Отсутствие align-items в flex-контейнере\n";
