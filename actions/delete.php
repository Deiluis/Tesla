<?php
    include('../connection.php');

    $id = $_GET['id'];
    $table = $_GET['table'];

    if ($conn->query("DELETE FROM $table WHERE `id`=$id")){
        if(isset($_GET['id_materia'])){
            $subject = $_GET['id_materia'];
            return header("Location: ../subjects/files?id=$subject");
        }
        header('Location: ../admin');
    }else{
        echo $conn->error;
    }
?>