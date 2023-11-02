<?php

include('../connection.php');

session_start();

$subject_id = $_POST['subject_id'];
$old_name = $_POST['old_name'];
$new_name = $_POST['new_name'];

$search_path = "./uploads/subject-$subject_id/$old_name";
$replace_path = "./uploads/subject-$subject_id/$new_name";

$old_path = "../uploads/subject-$subject_id/$old_name";
$new_path = "../uploads/subject-$subject_id/$new_name";



// Busca todos los archivos de la carpeta.
$files_search = $conn -> query("SELECT `id`, `name`, `file_type` FROM files WHERE `path` LIKE '%$search_path%'");

if ($files_search !== null) {
    if ($files_search -> num_rows > 0) {

        $file_ids = array();
        $file_names = array();
        $file_types = array();
        $i = 0;

        while ($row = $files_search -> fetch_assoc()) {
            $file_ids[$i] = $row['id'];
            $file_names[$i] = $row['name'];
            $file_types[$i] = $row['file_type'];
            $i++;
        }


        // Recorre el array de ids y actualiza los registros de cada archivo.
        for ($j = 0; $j < count($file_ids); $j++) {

            $update_path = "$replace_path/$file_names[$j].$file_types[$j]";

            $files_search = $conn -> query("
                UPDATE files 
                SET `path` = '$update_path'
                WHERE `id` = $file_ids[$j];
            ");
        }
    }

    // Renombra la carpeta en el sistema de archivos.
    if (rename($old_path, $new_path)) {
        echo json_encode("La carpeta " . $old_name . " fue renombrada a " . $new_name . " exitosamente.");
        $_SESSION['success'] = "La carpeta " . $old_name . " fue renombrada a " . $new_name . " exitosamente.";
    } else {
        echo json_encode("Hubo un error al intentar renombrar la carpeta" . $old_name . ".");
        $_SESSION['error'] = "Hubo un error al intentar renombrar la carpeta" . $old_name . ".";
    }

} else {
    echo json_encode("Hubo un error al intentar renombrar la carpeta" . $old_name . ".");
    $_SESSION['error'] = "Hubo un error al intentar renombrar la carpeta" . $old_name . ".";
}

?>