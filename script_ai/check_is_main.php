<?php
try {
    $mysqli = new mysqli('localhost', 'mplace_usr', '123', 'mplace');
    if ($mysqli->connect_error) die("Error: " . $mysqli->connect_error);
    
    $result = $mysqli->query("SELECT id, product_id, is_main, sort_order FROM product_images WHERE product_id = 4 LIMIT 10");
    
    echo "=== product_images для product_id=4 ===\n";
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']}, is_main: " . ($row['is_main'] ? 'YES' : 'NO') . ", sort: {$row['sort_order']}\n";
    }
    
    echo "\n=== Проверка is_main эксплицитно ===\n";
    $result = $mysqli->query("SELECT COUNT(*) as cnt FROM product_images WHERE product_id = 4 AND is_main = 1");
    $row = $result->fetch_assoc();
    echo "is_main = 1: " . $row['cnt'] . "\n";
    
    $result = $mysqli->query("SELECT COUNT(*) as cnt FROM product_images WHERE product_id = 4 AND is_main = 0");
    $row = $result->fetch_assoc();
    echo "is_main = 0: " . $row['cnt'] . "\n";
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
