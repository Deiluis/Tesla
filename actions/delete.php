<?php
    include('../connection.php');

    $id = $_GET['id'];
    $table = $_GET['table'];
    if(isset($_GET['subject_id'])){
        $file = $conn->query("SELECT name, file_type FROM files WHERE id = $id")->fetch_assoc();
    }
    if ($conn->query("DELETE FROM $table WHERE `id`=$id")){
        if(isset($_GET['subject_id'])){
            $subject = $_GET['subject_id'];
            unlink('../uploads/'. $file['name'] .'.'. $file['file_type']);
            return header("Location: ../?subject_id=$subject");
        }
        header('Location: ../admin');
    }else{
        echo $conn->error;
    }
?>