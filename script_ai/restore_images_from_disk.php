<?php
try {
    $mysqli = new mysqli('localhost', 'mplace_usr', '123', 'mplace');
    if ($mysqli->connect_error) die("Error: " . $mysqli->connect_error);
    
    // Функция для сканирования оригинальных файлов
    function scanOriginalImages($basePath) {
        $images = [];
        if (!is_dir($basePath)) return $images;
        
        $files = glob($basePath . '/originals/*.*');
        foreach ($files as $file) {
            $images[] = basename($file);
        }
        sort($images);
        return $images;
    }
    
    // Сканируем все продукты
    $productsDir = 'storage/app/public/products/images';
    if (!is_dir($productsDir)) {
        echo "Dir not found: $productsDir\n";
        exit;
    }
    
    $productDirs = glob($productsDir . '/*', GLOB_ONLYDIR);
    
    echo "=== Пересоздание записей product_images из файлов ===\n\n";
    
    $totalCreated = 0;
    
    foreach ($productDirs as $productDir) {
        $productId = basename($productDir);
        
        // Сканируем даты (папки 2026-02 и т.д.)
        $dateDirs = glob($productDir . '/*', GLOB_ONLYDIR);
        
        foreach ($dateDirs as $dateDir) {
            // Сканируем оригинальные файлы
            $images = scanOriginalImages($dateDir);
            
            foreach ($images as $index => $filename) {
                // Путь в БД
                $relativePath = str_replace(
                    'storage/app/public/', 
                    '', 
                    $dateDir . '/originals/' . $filename
                );
                $relativePath = str_replace('\\', '/', $relativePath);
                
                // Проверяем есть ли миниатюры
                $hasThumbs = file_exists($dateDir . '/originals/' . $filename);
                
                if ($hasThumbs) {
                    // Вставляем запись в БД
                    $isMain = $index === 0 ? 1 : 0;
                    $sortOrder = $index;
                    
                    $mysqli->query(
                        "INSERT INTO product_images 
                        (product_id, image_path, is_main, sort_order, created_at, updated_at)
                        VALUES 
                        ($productId, '$relativePath', $isMain, $sortOrder, NOW(), NOW())"
                    );
                    
                    if ($mysqli->error) {
                        echo "Error for $relativePath: " . $mysqli->error . "\n";
                    } else {
                        $totalCreated++;
                        echo "✓ Created: $relativePath (is_main=$isMain)\n";
                    }
                }
            }
        }
    }
    
    echo "\n=== Итог ===\n";
    echo "Создано записей: $totalCreated\n";
    
    // Проверяем результат
    $result = $mysqli->query("SELECT COUNT(*) as cnt FROM product_images");
    $row = $result->fetch_assoc();
    echo "Всего в product_images: " . $row['cnt'] . "\n";
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
