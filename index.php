<?php
    session_start();
    if (isset($_SESSION['user'])) {
        echo '
            <script>
                window.location = "./dashboard";
            </script>
        ';
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tesla</title>
</head>
<body>
    <h1>Bienvenido a Tesla</h1>
    <div>
        <a href="./library">
            <i class="fa-solid fa-book"></i>
            <h3>Biblioteca</h3>
        </a>
    </div>
    <div>
        <a href="#">
            <i class="fa-solid fa-display"></i>
            <h3>Ver exposicion</h3>
        </a>
    </div>
    <div>
        <a href="./auth/">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
            <h3>Iniciar Sesion</h3>
        </a>
    </div>
</body>
</html>