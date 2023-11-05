<?php
session_start();
include('../connection.php');
$subject_id = $_POST['subject_id'];
$dir_name = $_POST['dir_name'];

if ($dir_name)
    $target_dir = "../uploads/subject-$subject_id/$dir_name/";
else 
    $target_dir = "../uploads/subject-$subject_id/";

$fileType = '';

// Verifica si se seleccionaron archivos
if (!empty($_FILES['files']['name'][0])) {

    // Recorre el array de archivos, archivo por archivo
    foreach ($_FILES['files']['name'] as $key => $filename) {

        $file_path = $target_dir . basename($filename);
        $fileType = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        // Chequea si el archivo existe
        if (file_exists($file_path)) {
            // El mensaje de error cambia en función de si se guarda en una carpeta o en la raíz de la materia.
            if ($dir_name)
                $_SESSION['error'] = "El archivo " . $filename . " ya existe en la carpeta " . $dir_name . ".";
            else
                $_SESSION['error'] = "El archivo " . $filename . " ya existe en los archivos sin carpeta.";
        } else {
            // Mueve el archivo creado a la ubicación deseada
            if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $file_path)) {
                $file = pathinfo($filename, PATHINFO_FILENAME);
                // Elimina el primer punto de la ruta.
                $file_path = substr($file_path, 1);
                // Sube el registro del archivo a la base de datos.
                if ($conn->query("
                    INSERT INTO files (id, name, file_type, path, subject_id)
                    VALUES (NULL, '$file', '$fileType', '$file_path', '$subject_id')
                ")) {
                    $_SESSION['success'] = "Se subió el archivo " . $filename . " exitosamente.";
                } else {
                    $_SESSION['error'] = "Hubo un error al subir el archivo " . $filename . ".";
                }
            } else {
                $_SESSION['error'] = "Hubo un error al subir el archivo " . $filename . ".";
            }
        }
    }
} else {
    $_SESSION['error'] = "No se seleccionaron archivos para subir.";
}

// Ya sea que los archivos se hayan subido o no, te redirige nuevamente.
header('Location: ../?subject_id=' . $subject_id);
?>