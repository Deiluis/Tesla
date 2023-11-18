<?php
    include('./connection.php');
    $lab = $_POST['lab'];
    $itemId = $_POST['itemId'];
    $item = $conn->query("
        SELECT *
        FROM `inventory` 
        WHERE id = $itemId AND laboratory_id = '$lab'
    ")->fetch_assoc();
    print(json_encode($item));