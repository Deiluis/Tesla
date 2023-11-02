<?php

include('../connection.php');

session_start();

$subject_id = $_POST['subject_id'];
$dir_name = $_POST['dir_name'];

$dir = "./uploads/subject-$subject_id/$dir_name";

if ($conn -> query("DELETE FROM files WHERE `path` LIKE '%$dir%'")) {
    
    $dir = "." . $dir;

    // Elimina todos los archivos y directorios de la carpeta de la materia y luego la elimina también.
    // No se puede eliminar una carpeta que no esta vacía.
    array_map('unlink', glob("$dir/*.*"));
    rmdir($dir);

    echo json_encode("La carpeta " . $dir_name . " fue eliminada exitosamente.");
    $_SESSION['success'] = "La carpeta " . $dir_name . " fue eliminada exitosamente.";
} else {
    echo json_encode("Hubo un error al eliminar la carpeta " . $dir_name . ".");
    $_SESSION['error'] = "Hubo un error al eliminar la carpeta " . $dir_name . ".";
}

?>