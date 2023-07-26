<?php

function obtainFile($id_file) {
    include("../connection.php");
    $file_data = $conn->query("SELECT file_type, path FROM files WHERE id = $id_file")->fetch_assoc();
    $extension = $file_data['file_type'];
    $path = substr($file_data['path'], 1);

    // Arreglar con if
    switch($extension){
        case 'png': return '<img src="'.$path.'" class="content--img">';
        case 'jpg': return '<img src="'.$path.'" class="content--img">';
       case 'jpeg': return '<img src="'.$path.'" class="content--img">';
        case 'svg': return '<img src="'.$path.'" class="content--img">';
        case 'pdf': return '<embed src="'.$path.'" type="application/pdf" class="content--pdf"></embed>';
        case 'mp3': return '<audio src="'.$path.'" controls class="content--audio"></audio>';
        case 'wav': return '<audio src="'.$path.'" controls class="content--audio"></audio>';
        case 'mp4': return '<video src="'.$path.'" controls class="content--video"></video>';
    }
}

$idFile = $_POST['id-file'];
echo obtainFile($idFile);

?>