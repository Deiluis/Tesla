<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo '
        <script>
            alert("Usuario no existe, verifique los datos ingresados");
            window.location = "./";
        </script>
    ';
    session_destroy();
    exit;
}

$id = $_SESSION['user']['id'];
$name = $_SESSION['user']['name'];
$surname = $_SESSION['user']['surname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tesla - Dashboard</title>
    <script src="https://kit.fontawesome.com/41b6154676.js" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Bienvenido <?php echo $name . " " . $surname ?></h1>
    <div>
        <a href="./subjects">
            <i class="fa-solid fa-book"></i>
            <h3>Biblioteca</h3>
        </a>
    </div>
    <div>
        <a href="#">
            <i class="fa-solid fa-display"></i>
            <h3>Exponer</h3>
        </a>
    </div>
    <div>
        <a href="./notifications/?adminId=<?php echo $id ?>">
            <i class="fa-solid fa-file-circle-exclamation"></i>
            <h3>Hoja de observaciones</h3>
        </a>
    </div>
    <div>
        <a href="#">
            <i class="fa-solid fa-user"></i>
            <h3>Mi cuenta</h3>
        </a>
    </div>
    <div>
        <a href="./admin">
            <i class="fa-solid fa-user-lock"></i>
            <h3>Panel de administración</h3>
        </a>
    </div>
    <div>
        <a href="./auth/logout">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
            <h3>Cerrar sesión</h3>
        </a>
    </div>
</body>
</html>