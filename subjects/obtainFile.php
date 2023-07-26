<?php

function obtainFile($id_file) {
    include("../connection.php");
    $query_file = mysqli_query($conn, "SELECT file_type, path FROM files WHERE id = $id_file");
    $file_data = mysqli_fetch_array($query_file);
    $extension = $file_data['file_type'];
    $path = $file_data['path'];

    // Arreglar con if
    switch($extension){
        case 'png':
            return '<img src="'.$path.'" class="content--img">';
        case 'jpg':
            return '<img src="'.$path.'" class="content--img">';
            break;
        case 'jpeg':
            return '<img src="'.$path.'" class="content--img">';
            break;
        case 'svg':
            return '<img src="'.$path.'" class="content--img">';
            break;    
        case 'pdf':
            return '<embed src="'.$path.'" type="application/pdf" class="content--pdf"></embed>';
            break;
        case 'mp3':
            return '<audio src="'.$path.'" controls class="content--audio"></audio>';
            break;
        case 'wav':
            return '<audio src="'.$path.'" controls class="content--audio"></audio>';
            break;
        case 'mp4':
            return '<video src="'.$path.'" controls class="content--video"></video>';
            break;
    }
}

$idFile = $_POST['id-file'];
echo obtainFile($idFile);

?>