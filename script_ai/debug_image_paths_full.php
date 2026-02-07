<?php
try {
    $mysqli = new mysqli('localhost', 'mplace_usr', '123', 'mplace');
    if ($mysqli->connect_error) die("Error: " . $mysqli->connect_error);
    
    // Получим изображения для product_id = 4
    $result = $mysqli->query("SELECT id, image_path, is_main FROM product_images WHERE product_id = 4 LIMIT 3");
    
    echo "=== Проверка image_path в БД ===\n";
    while ($row = $result->fetch_assoc()) {
        $path = $row['image_path'];
        echo "\nID: {$row['id']}, is_main: " . ($row['is_main'] ? 'YES' : 'NO') . "\n";
        echo "Path: $path\n";
        
        // Проверяем существование оригинала
        $origExists = file_exists("storage/app/public/" . $path) ? "YES" : "NO";
        echo "Original exists: $origExists\n";
        
        // Конструируем пути к миниатюрам
        $pathParts = explode('/', $path);
        $filename = array_pop($pathParts);
        array_pop($pathParts); // Удаляем originals
        
        $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        foreach (['thumb', 'medium', 'large'] as $size) {
            $thumbFilename = "{$filenameWithoutExt}-{$size}.{$ext}";
            $thumbPath = "storage/app/public/" . implode('/', $pathParts) . "/{$size}/{$thumbFilename}";
            echo "  {$size}: " . (file_exists($thumbPath) ? "EXISTS" : "NOT FOUND") . "\n";
        }
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
