<?php
    session_start();

    $subject_id = $_GET['subject_id'];
    $folder_name = $_POST['foldername'];

    if (mkdir("../uploads/subject-$subject_id/$folder_name"))
        $_SESSION['success'] = "Se creó la carpeta " . $folder_name . " exitosamente.";
    else
        $_SESSION['error'] = "Hubo un error al crear la carpeta " . $folder_name . ".";
    
    header("Location: ../?subject_id=$subject_id");
?>