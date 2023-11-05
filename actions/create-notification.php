<?php

include('../connection.php');
session_start();

$validForm = isset($_POST['laboratory']) && isset($_POST['computer']) && isset($_POST['description']);

if ($validForm) {
    $laboratory = $_POST['laboratory'];
    $computer = $_POST['computer'];
    $description = $_POST['description'];

    $result = $conn -> query("
        INSERT INTO `notifications` (`id`, `laboratory_id`, `computer`, `description`, `status_id`) 
        VALUES (NULL, '$laboratory', '$computer', '$description', 1)
    ");

    if ($result) 
        $_SESSION['success'] = 'Observación añadida exitosamente.';
    else 
        $_SESSION['error']   = 'Ocurrió un error al enviar la observación, inténtelo de nuevo más tarde o contacte a un administrador.';
} else {
    $_SESSION['error']   = 'Ocurrió un error al enviar la observación, inténtelo de nuevo más tarde o contacte a un administrador.';
}

header("Location: ../");

?>