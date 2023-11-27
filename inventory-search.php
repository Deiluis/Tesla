<?php
include('./connection.php');
$lab = $_POST['lab'];
$itemId = $_POST['itemId'];
$item = $conn->query("SELECT inventory.name, inventory.description, inventory.quantity, inventory.laboratory_id, inventory.id, GROUP_CONCAT( users.name, ' ', users.surname, ',', reservations.date, ',', reservations.start, ',', reservations.finish, ',', reservations.area, ',', reservations.description SEPARATOR '.' ) AS reservations FROM `inventory` INNER JOIN reservations ON inventory.id = reservations.item_id INNER JOIN users ON reservations.user_id = users.id WHERE inventory.id = $itemId AND inventory.laboratory_id = '$lab' GROUP BY inventory.id")->fetch_assoc();
print(json_encode($item));
