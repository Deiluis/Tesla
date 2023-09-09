<?php
    include('../connection.php');
    $lab = $_POST['lab'];
    $pc_id = $_POST['pc_id'];
    $pc = $conn->query("
        SELECT pc, laboratory_id, information
        FROM `computers` 
        WHERE pc = $pc_id AND laboratory_id = '$lab'
    ")->fetch_assoc();
    print(json_encode($pc));