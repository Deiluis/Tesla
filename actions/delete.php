<?php
    include('../connection.php');

    $id = $_GET['id'];
    $table = $_GET['table'];
    
    // Elimina archivos del sistema de archivos.
    if ($table === "files") {
        $file = $conn -> query("SELECT path, subject_id FROM files WHERE id = $id") -> fetch_assoc();
        unlink("." . $file['path']);
    }

    if ($conn -> query("DELETE FROM $table WHERE `id`= $id")) {    

        if ($table === 'subjects') {     

            if ($conn -> query("DELETE FROM files WHERE `subject_id`= $id")) {
                $dir = "../uploads/subject-$id";

                // Elimina todos los archivos y directorios de la carpeta de la materia y luego la elimina también.
                // No se puede eliminar una carpeta que no esta vacía.
                array_map('unlink', glob("$dir/*.*"));
                rmdir($dir);
            }
        }

        if ($table === 'files') {
            return header("Location: ../?subject_id=" . $file['subject_id']);
        }

        header('Location: ../admin');
    } else {
        echo $conn->error;
    }
?>