<?php
    include('../connection.php');

    $id = $_GET['id'];
    $laboratory = $_GET['laboratory'];

    if ($conn->query("DELETE FROM inventory WHERE `id`='$id'")){
        header("Location: ../inventory/items?id=$laboratory");
    } else {
        echo $conn->error;
    }
?>