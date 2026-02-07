<?php
try {
    $mysqli = new mysqli('localhost', 'mplace_usr', '123', 'mplace');
    if ($mysqli->connect_error) die("Error: " . $mysqli->connect_error);
    
    $result = $mysqli->query("SELECT id, image_path FROM product_images LIMIT 3");
    echo "=== Пути в БД ===\n";
    while ($row = $result->fetch_assoc()) {
        echo $row['image_path'] . "\n";
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
