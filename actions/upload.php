<?php
session_start();
include('../connection.php');
$target_dir = "../subjects/uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$file = '';
$uploadOk = 1;
$subject = $_POST['subject_id'];
// Chequea si el archivo existe
if (file_exists($target_file)) {
    $uploadOk = 0;
}

// Chequea que no haya errores
if ($uploadOk == 0) {
    header('Location: ../subjects');
    // Agregar error en submit
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $file = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
        if ($conn->query(
            "
            INSERT INTO files (id, name, file_type, path, subject_id)
            VALUES (NULL,'$file', '$fileType', '$target_file', '$subject')
            "
        )) {
            header('Location: ../subjects/files?id='. $subject);
        }
        $conn->close();
    } else {
        // echo "Sorry, there was an error uploading your file.";
    }
}
?>