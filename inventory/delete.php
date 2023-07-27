<?php
    include('../connection.php');

    $id = $_GET['id'];
    $laboratory = $_GET['laboratory'];

    if ($conn->query("DELETE FROM inventory WHERE `id`='$id'")){
        header("Location: ../?items_id=$laboratory#inventario");
    } else {
        echo $conn->error;
    }
?>