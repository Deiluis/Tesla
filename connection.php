<?php
    error_reporting(0);
    /*
      Conexión a la base datos, primer datos ingresado es la dirección IP
      el segundo dato es el usuario, el tercero es la contraseña y
      el cuarto es la base datos.
    */
    $conn = mysqli_connect("localhost", "root", "", "tesla");
    if (!$conn) {
        error_log('Connection error: ' . mysqli_connect_error());
    }
?>