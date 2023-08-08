<?php
    $subject_id = $_GET['subject_id'];
    $folder_name = $_POST['foldername'];
    mkdir("./uploads/subject-$subject_id/$folder_name");
    header("Location: ./?subject_id=$subject_id");
?>