<?php
try {
    $mysqli = new mysqli('localhost', 'mplace_usr', '123', 'mplace');
    if ($mysqli->connect_error) die("Error: " . $mysqli->connect_error);
    
    // Получим все product_id, у которых нет is_main=1
    $result = $mysqli->query("
        SELECT product_id FROM (
            SELECT DISTINCT product_id 
            FROM product_images 
            WHERE product_id NOT IN (
                SELECT DISTINCT product_id FROM product_images WHERE is_main = 1
            )
        ) t
    ");
    
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        // Для каждого product_id, устанавливаем is_main=1 для первого изображения
        $update_result = $mysqli->query("
            UPDATE product_images 
            SET is_main = 1 
            WHERE product_id = $product_id 
            ORDER BY id ASC 
            LIMIT 1
        ");
        $count += $mysqli->affected_rows;
    }
    
    echo "Updated: $count records\n";
    
    // Проверяем результат
    $result = $mysqli->query("SELECT COUNT(*) as cnt FROM product_images WHERE is_main = 1");
    $row = $result->fetch_assoc();
    echo "Total is_main=1: " . $row['cnt'] . "\n";
    
    $result = $mysqli->query("
        SELECT product_id, COUNT(*) as img_count, SUM(is_main) as main_count 
        FROM product_images 
        GROUP BY product_id
    ");
    
    echo "\nПо продуктам:\n";
    while ($row = $result->fetch_assoc()) {
        $img_count = $row['img_count'];
        $main_count = $row['main_count'] ?? 0;
        echo "Product {$row['product_id']}: {$img_count} images, {$main_count} main\n";
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

