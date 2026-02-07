<?php
try {
    $mysqli = new mysqli('localhost', 'mplace_usr', '123', 'mplace');
    if ($mysqli->connect_error) die("Error: " . $mysqli->connect_error);
    
    // Получим все product_id которые имеют изображения
    $result = $mysqli->query("SELECT DISTINCT product_id FROM product_images ORDER BY product_id");
    
    echo "=== Products с изображениями ===\n";
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row['product_id'];
    }
    echo "Product IDs: " . implode(', ', $products) . "\n";
    
    if (empty($products)) {
        echo "В БД нет изображений!\n";
        exit;
    }
    
    // Для первого product_id получим все изображения
    $pid = $products[0];
    echo "\n=== Изображения для product_id=$pid ===\n";
    
    $result = $mysqli->query("SELECT id, image_path, is_main FROM product_images WHERE product_id = $pid");
    echo "Всего: " . $result->num_rows . " изображений\n";
    
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']}, is_main: " . ($row['is_main'] ? 'YES' : 'NO') . "\n";
        echo "  Path: {$row['image_path']}\n";
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
