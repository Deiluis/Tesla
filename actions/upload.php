<?php
session_start();
include('../connection.php');
$subject_id = $_POST['subject_id'];
$dir_name = $_POST['dir_name'];

if ($dir_name)
    $target_dir = "../uploads/subject-$subject_id/$dir_name/";
else 
    $target_dir = "../uploads/subject-$subject_id/";

$file_path = $target_dir . basename($_FILES["file"]["name"]);
$fileType = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
$file = '';
$uploadOk = 1;
// Chequea si el archivo existe
if (file_exists($file_path)) {
    $uploadOk = 0;
}

// Chequea que no haya errores
if ($uploadOk == 0) {
    echo "<script>console.log('error');</script>";
    //header('Location: ../?subject_id='. $subject_id);
    // Agregar error en submit
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        $file = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);

        // Elimina el primer punto de la ruta.
        $file_path = substr($file_path, 1);

        if ($conn->query(
            "
            INSERT INTO files (id, name, file_type, path, subject_id)
            VALUES (NULL,'$file', '$fileType', '$file_path', '$subject_id')
            "
        )) {
            header('Location: ../?subject_id='. $subject_id);
        }
        $conn->close();
    } else {
        // echo "Sorry, there was an error uploading your file.";
        echo "<script>console.log('error');</script>";
        //header('Location: ../?subject_id='. $subject_id);
    }
}
?>