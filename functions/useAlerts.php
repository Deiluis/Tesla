<?php
session_start();

if (isset($_POST['success']))
    $_SESSION['success'] = $_POST['success'];

if (isset($_POST['error']))
    $_SESSION['error'] = $_POST['error'];

echo json_encode("hola");

?>