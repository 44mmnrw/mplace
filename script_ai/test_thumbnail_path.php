<?php
try {
    $mysqli = new mysqli('localhost', 'mplace_usr', '123', 'mplace');
    if ($mysqli->connect_error) die("Error: " . $mysqli->connect_error);
    
    $result = $mysqli->query("SELECT id, image_path FROM product_images LIMIT 1");
    $row = $result->fetch_assoc();
    
    $imagePath = $row['image_path']; // products/images/4/2026-02/originals/4vII4bkf...png
    
    echo "Исходный путь: $imagePath\n\n";
    
    // Симуляция getThumbnailUrl
    $pathParts = explode('/', $imagePath);
    echo "Шаг 1 - Split по '/': " . json_encode($pathParts) . "\n";
    
    $filename = array_pop($pathParts);
    echo "Шаг 2 - Pop filename: $filename\n";
    echo "         Остаток: " . json_encode($pathParts) . "\n";
    
    array_pop($pathParts);
    echo "Шаг 3 - Pop 'originals': " . json_encode($pathParts) . "\n";
    
    $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    echo "Шаг 4 - Filename без расширения: $filenameWithoutExt\n";
    echo "        Расширение: $ext\n";
    
    $sizes = ['thumb', 'medium', 'large'];
    foreach ($sizes as $size) {
        $thumbFilename = "{$filenameWithoutExt}-{$size}.{$ext}";
        $thumbPath = implode('/', $pathParts) . "/{$size}/{$thumbFilename}";
        
        echo "\n{$size}:\n";
        echo "  Filename: $thumbFilename\n";
        echo "  Full path: $thumbPath\n";
        echo "  File exists: " . (file_exists("storage/app/public/" . $thumbPath) ? "YES" : "NO") . "\n";
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
