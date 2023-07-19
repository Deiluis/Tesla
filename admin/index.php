<?php
session_start();
include('../connection.php');
$id = $_SESSION['user']['id'];
$notifications = $conn->query("
        SELECT COUNT(*)
        FROM laboratories
        INNER JOIN notifications
        ON laboratories.id = notifications.laboratory_id 
        WHERE laboratories.admin_id = '$id' AND notifications.status_id = 1;
    ")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <title>Dashboard - Admin</title>
    <style>
    .main-container > div + div + div {
        display: none;
    }
</style>
</head>

<body>
    <div class="video-bg">
        <video width="320" height="240" autoplay loop muted>
            <source src="https://assets.codepen.io/3364143/7btrrd.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="dark-light">
        <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
        </svg>
    </div>
    <div class="app">
        <div class="header">
            <div class="menu-circle"></div>
            <div class="header-menu">
                <?php if ($notifications['COUNT(*)'] > 0){
                    ?> <a class="menu-link notify" href="observaciones">Observaciones</a> <?php
                }else{
                    ?> <a class="menu-link " href="observaciones">Observaciones</a> <?php } ?>
                <a class="menu-link is-active">Panel de Administracion</a>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search">
            </div>
            <div class="header-profile">
                <div class="notification">
                    <span class="notification-number"><?php echo $notifications['COUNT(*)']; ?></span>
                    <svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
                    </svg>
                </div>
                <a href="#">
                    <img class="profile-img" src="https://images.unsplash.com/photo-1600353068440-6361ef3a86e8?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="">
                </a>
                <a href="../auth/logout">
                    <svg viewBox="0 0 24 24" fill="currentColor" height="24"  width="24" focusable="false" class="logout"><path d="M20 3v18H8v-1h11V4H8V3h12zm-8.9 12.1.7.7 4.4-4.4L11.8 7l-.7.7 3.1 3.1H3v1h11.3l-3.2 3.3z"></path></svg>
                </a>
            </div>
        </div>
        <div class="wrapper">
            <div class="left-side">
                <div class="side-wrapper">
                    <div class="side-title">Cuenta</div>
                    <div class="side-menu">
                        <a href="../account/">
                            <svg viewBox="0 0 512 512">
                                <g xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                    <path d="M0 0h128v128H0zm0 0M192 0h128v128H192zm0 0M384 0h128v128H384zm0 0M0 192h128v128H0zm0 0" data-original="#bfc9d1" />
                                </g>
                                <path xmlns="http://www.w3.org/2000/svg" d="M192 192h128v128H192zm0 0" fill="currentColor" data-original="#82b1ff" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M384 192h128v128H384zm0 0M0 384h128v128H0zm0 0M192 384h128v128H192zm0 0M384 384h128v128H384zm0 0" fill="currentColor" data-original="#bfc9d1" />
                            </svg>
                            Mi cuenta
                        </a>
                        <a href="../auth/logout">
                            <svg viewBox="0 0 488.932 488.932" fill="currentColor">
                                <path d="M243.158 61.361v-57.6c0-3.2 4-4.9 6.7-2.9l118.4 87c2 1.5 2 4.4 0 5.9l-118.4 87c-2.7 2-6.7.2-6.7-2.9v-57.5c-87.8 1.4-158.1 76-152.1 165.4 5.1 76.8 67.7 139.1 144.5 144 81.4 5.2 150.6-53 163-129.9 2.3-14.3 14.7-24.7 29.2-24.7 17.9 0 31.8 15.9 29 33.5-17.4 109.7-118.5 192-235.7 178.9-98-11-176.7-89.4-187.8-187.4-14.7-128.2 84.9-237.4 209.9-238.8z" />
                            </svg>
                            Cerrar sesion
                        </a>
                    </div>
                </div>
                <div class="side-wrapper">
                    <div class="side-title">Secciones</div>
                    <div class="side-menu">
                        <a href="observaciones">
                            <svg viewBox="0 0 512 512" fill="currentColor">
                                <circle cx="295.099" cy="327.254" r="110.96" transform="rotate(-45 295.062 327.332)" />
                                <path d="M471.854 338.281V163.146H296.72v41.169a123.1 123.1 0 01121.339 122.939c0 3.717-.176 7.393-.5 11.027zM172.14 327.254a123.16 123.16 0 01100.59-120.915L195.082 73.786 40.146 338.281H172.64c-.325-3.634-.5-7.31-.5-11.027z" />
                            </svg>
                            Observaciones
                            <span class="notification-number updates"><?php echo $notifications['COUNT(*)']; ?></span>
                        </a>
                        <a href="#">
                            <svg viewBox="0 0 488.455 488.455" fill="currentColor">
                                <path d="M287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0" />
                                <path d="M427.397 91.581H385.21l-30.544-61.059H133.76l-30.515 61.089-42.127.075C27.533 91.746.193 119.115.164 152.715L0 396.86c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059V152.639c-.001-33.674-27.385-61.058-61.059-61.058zM244.22 381.61c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118S311.555 381.61 244.22 381.61z" />
                            </svg>
                            Administracion
                        </a>
                    </div>
                </div>
                <div class="side-wrapper">
                    <div class="side-title">Panel de administración</div>
                    <div class="side-menu admin">
                        <a href="#usuarios">
                            <svg viewBox="0 0 512 512" fill="currentColor">
                                <circle cx="295.099" cy="327.254" r="110.96" transform="rotate(-45 295.062 327.332)" />
                                <path d="M471.854 338.281V163.146H296.72v41.169a123.1 123.1 0 01121.339 122.939c0 3.717-.176 7.393-.5 11.027zM172.14 327.254a123.16 123.16 0 01100.59-120.915L195.082 73.786 40.146 338.281H172.64c-.325-3.634-.5-7.31-.5-11.027z" />
                            </svg>
                            Usuarios
                        </a>
                        <a href="#materias">
                            <svg viewBox="0 0 488.455 488.455" fill="currentColor">
                                <path d="M287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0" />
                                <path d="M427.397 91.581H385.21l-30.544-61.059H133.76l-30.515 61.089-42.127.075C27.533 91.746.193 119.115.164 152.715L0 396.86c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059V152.639c-.001-33.674-27.385-61.058-61.059-61.058zM244.22 381.61c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118S311.555 381.61 244.22 381.61z" />
                            </svg>
                            Materias
                        </a>
                        <a href="#laboratorios">
                            <svg viewBox="0 0 488.455 488.455" fill="currentColor">
                                <path d="M287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0" />
                                <path d="M427.397 91.581H385.21l-30.544-61.059H133.76l-30.515 61.089-42.127.075C27.533 91.746.193 119.115.164 152.715L0 396.86c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059V152.639c-.001-33.674-27.385-61.058-61.059-61.058zM244.22 381.61c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118S311.555 381.61 244.22 381.61z" />
                            </svg>
                            Laboratorios
                        </a>
                        <a href="#roles">
                            <svg viewBox="0 0 488.455 488.455" fill="currentColor">
                                <path d="M287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0" />
                                <path d="M427.397 91.581H385.21l-30.544-61.059H133.76l-30.515 61.089-42.127.075C27.533 91.746.193 119.115.164 152.715L0 396.86c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059V152.639c-.001-33.674-27.385-61.058-61.059-61.058zM244.22 381.61c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118S311.555 381.61 244.22 381.61z" />
                            </svg>
                            Roles
                        </a>
                    </div>
                </div>
            </div>

            <div class="main-container">
                <div class="main-header">
                    <div class="header-menu">
                        <a class="main-header-link is-active" href="#usuarios">Usuarios</a>
                        <a class="main-header-link" href="#materias">Materias</a>
                        <a class="main-header-link" href="#laboratorios">Laboratorios</a>
                        <a class="main-header-link" href="#roles">Roles</a>
                        <a class="main-header-link" href="#name_materias">Nombres de materias</a>
                    </div>
                </div>
                <div class="content-wrapper" id="usuarios">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Autenticidad?</th>
                                <th>Rol</th>
                                <th>Opciones</th>
                            </tr>
                            <?php
                            $result = $conn->query("SELECT users.*, roles.name AS roles FROM users INNER JOIN roles ON roles.id = users.rol_id");
                            if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row["name"] ?></td>
                                    <td><?php echo $row["surname"] ?></td>
                                    <td><?php echo $row["username"] ?></td>
                                    <td><?php echo $row["email"] ?></td>
                                    <td><?php if(password_verify('',$row["password"]))print "<span class='status'><span class='status-circle red'></span>Sin contraseña</span>"; else print "<span class='status'><span class='status-circle green'></span>Autenticado</span>"; ?></td>
                                    <td><?php echo $row["roles"] ?></td>
                                    <td>
                                        <div class="button-wrapper">
                                            <a href="./?id=<?php echo $row['id'] ?>&table=users"><button class='content-button status-button'>Editar</button></a>
                                            <div class="menu">
                                                <button class="dropdown">
                                                    <ul>
                                                        <li><a href="delete?id=<?php echo $row["id"] ?>&table=users">Borrar</a></li>
                                                    </ul>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                            }
                            ?>
                            <tr>
                                <form action="../actions/create" method="post">
                                <td><input type="text" name="name" id="name" placeholder="Nombre"></td>
                                <td><input type="text" name="surname" id="surname" placeholder="Apellido"></td>
                                <td><input type="text" name="username" id="username" placeholder="Nombre de usuario"></td>
                                <td><input type="email" name="email" id="email" placeholder="Email"></td>
                                <td><input type="password" name="password" id="password" placeholder="Contraseña"></td>
                                <td>
                                    <select name="rol_id" id="rol_id">
                                    <?php
                                    $result = $conn->query("SELECT * FROM roles");
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <div class="button-wrapper">
                                        <button class='content-button status-button' type="submit">Agregar</button>
                                        <button type="reset">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                            </svg>
                                        </button>
                                        </div>
                                    </div>
                                </td>
                                </form>
                            </tr>
                        </table>
                        <?php 
                        if(isset($_GET['id']) || isset($_GET['table'])){
                            if($_GET['table'] == 'users'){
                            $id = $_GET['id'];
                            $table = $_GET['table'];    
                            $user = $conn -> query("SELECT * FROM `$table` WHERE `id`=$id")->fetch_assoc();
                        ?>
                        <table>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Contraseña</th>
                                <th>Rol</th>
                                <th>Opciones</th>
                            </tr>
                            <tr>
                                <form action="../actions/update?id=<?php echo $user['id'] ?>&table=users" method="post">
                                    <td ><input type="text" name="name" id="name" placeholder="Nombre" value="<?php echo $user['name'] ?>"></td>
                                    <td><input type="text" name="surname" id="surname" placeholder="Apellido" value="<?php echo $user['surname'] ?>" ></td>
                                    <td> <input type="text" name="username" id="username" placeholder="Nombre de usuario" value="<?php echo $user['username'] ?>"></td>
                                    <td><input type="email" name="email" id="email" placeholder="Email" value="<?php echo $user['email'] ?>"></td>
                                    <td><input type="password" name="password" id="password" placeholder="***********" value=""></td>
                                    <td>
                                        <select name="rol_id" id="rol_id">
                                            <?php
                                                $roles = $conn -> query("SELECT * FROM roles");
                                                if($roles -> num_rows > 0){
                                                    while($row = $roles -> fetch_assoc()){
                                                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" name="account" style="background-color: transparent; border:none; color:white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                            </svg>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        </table>
                    <?php }} ?>
                    </div>
                </div>
                <div class="content-wrapper" id="materias">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Materia</th>
                                <th>Profesor</th>
                                <th>Curso</th>
                                <th>Laboratorio</th>
                                <th>Opciones</th>
                            </tr>
                            <?php
                            $result = $conn->query("SELECT subjects.id, subjects.course, subjects.division, subjects.group, subjects_names.name, users.name AS professor, subjects.laboratory_id FROM subjects INNER JOIN subjects_names ON subjects.name_id = subjects_names.id INNER JOIN users ON subjects.professor_id = users.id");
                            if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                <td><?php echo $row["name"] ?></td>
                                <td><?php echo $row["professor"]?></td>
                                <td><?php echo $row["course"] . "°" . $row["division"] . " - " . $row["group"] ?></td>
                                <td><?php echo $row["laboratory_id"] ?></td>
                                <td>
                                    <div class="button-wrapper">
                                        <a href="./?id=<?php echo $row['id'] ?>&table=subjects#materias"><button class='content-button status-button'>Editar</button></a>
                                        <div class="menu">
                                            <button class="dropdown">
                                                <ul style="height:fit-content;">
                                                    <li><a href="delete?id=<?php echo $row["id"] ?>&table=subjects">Borrar</a></li>
                                                </ul>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                </tr>

                            <?php }
                            }
                            ?>
                            <tr>
                                <form action="../actions/create" method="post">
                                    <td>
                                        <select name="name" id="name" style='width:300px;'>
                                            <?php $result = $conn->query("SELECT * FROM subjects_names");
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "
                                                        <option value='" . $row['id'] . "'>". $row['name'] . "</option>
                                                        ";
                                                }
                                            }?>
                                        </select>
                                    </td>
                                <td>
                                    <select name="professor" id="professor">
                                        <?php $result = $conn->query("SELECT * FROM users WHERE rol_id=1");
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . " " . $row['surname'] . "</option>";
                                            }
                                        }?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" min=1 max=7 name="course" placeholder="Curso">
                                    <input type="number" min=1 max=6 name="division" placeholder="Division">
                                    <input type="text" name="group" placeholder="Grupo" style="width:50px">
                                </td>
                                <td>
                                    <select name="laboratory" id="laboratory">
                                    <?php
                                    $result = $conn->query("SELECT * FROM laboratories");
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                                        }
                                    }
                                    ?>
                                    </select>  
                                </td>
                                <td>
                                    <div class="button-wrapper">
                                        <button class='content-button status-button' type="submit">Agregar</button>
                                        <button type="reset">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                            </svg>
                                        </button>
                                        </div>
                                    </div>
                                </td>
                                </form>
                            </tr>
                        </table>
                        <?php 
                        if(isset($_GET['id']) || isset($_GET['table'])){
                            if($_GET['table'] == 'subjects'){
                            $id = $_GET['id'];
                            $table = $_GET['table'];    
                            $user = $conn -> query("SELECT * FROM `$table` WHERE `id`=$id")->fetch_assoc();
                        ?>
                        <table style="position: absolute;
                        bottom:10px;">
                            <tr>
                                <th>Materia</th>
                                <th>Profesor</th>
                                <th>Curso</th>
                                <th>Division</th>
                                <th>Grupo</th>
                                <th>Laboratorio</th>
                                <th>Opciones</th>
                            </tr>
                            <tr>
                                <form action="../actions/update?id=<?php echo $user['id'] ?>&table=subjects" method="post">
                                    <td><select name="name" id="name" style="border-radius:5px;width:210px; background-color: #562a3c; border:none; color:white;">
                                            <?php
                                                $roles = $conn -> query("SELECT id, name FROM subjects_names");
                                                if($roles -> num_rows > 0){
                                                    while($row = $roles -> fetch_assoc()){
                                                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td><select name="professor" id="name" style="border-radius:5px;width:110px; background-color: #562a3c; border:none; color:white;">
                                            <?php
                                                $roles = $conn -> query("SELECT id, name FROM users WHERE rol_id=1");
                                                if($roles -> num_rows > 0){
                                                    while($row = $roles -> fetch_assoc()){
                                                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="course" id="username" placeholder="Curso" value="<?php echo $user['course'] ?>" style="width:30px; background-color: transparent; border:none; color:white;"></td>
                                    <td><input type="text" name="division" id="username" placeholder="Division" value="<?php echo $user['division'] ?>" style="width:30px; background-color: transparent; border:none; color:white;"></td>
                                    <td><input type="text" name="group" id="username" placeholder="Grupo" value="<?php echo $user['group'] ?>" style="width:30px; background-color: transparent; border:none; color:white;"></td>
                                    <td><select name="laboratory" id="name" style="border-radius:5px;width:120px; background-color: #562a3c; border:none; color:white;">
                                            <?php
                                                $roles = $conn -> query("SELECT id FROM laboratories");
                                                if($roles -> num_rows > 0){
                                                    while($row = $roles -> fetch_assoc()){
                                                        echo "<option value='".$row['id']."'>".$row['id']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" name="subject" style="background-color: transparent; border:none; color:white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                            </svg>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        </table>
                    <?php }} ?>
                    </div>
                </div>
                <div class="content-wrapper" id="laboratorios">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Laboratorio</th>
                                <th>Computadoras</th>
                                <th>Admin</th>
                                <th>Opciones</th>
                            </tr>
                            <?php
                            $result = $conn->query("SELECT laboratories.id, laboratories.computers_quantity, users.name, users.surname FROM laboratories INNER JOIN users ON laboratories.admin_id = users.id ");
                            if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row["id"] ?></td>
                                    <td><?php echo $row["computers_quantity"] ?></td>
                                    <td><?php echo $row["name"] ?> <?php echo $row["surname"] ?></td>
                                    <td>
                                        <div class="button-wrapper">
                                            <a href="./?id=<?php echo $row['id'] ?>&table=laboratories#laboratorios"><button class='content-button status-button'>Editar</button></a>
                                            <div class="menu">
                                                <button class="dropdown">
                                                    <ul style="height:fit-content;">
                                                        <li><a href="delete?id=<?php echo $row["id"] ?>&table=laboratories">Borrar</a></li>
                                                    </ul>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            <?php }
                            }
                            ?>
                        </table>
                    </div>
                    <div class="content-section">
                        <?php 
                        if(isset($_GET['id']) || isset($_GET['table'])){
                            if($_GET['table'] == 'laboratories'){
                            $id = $_GET['id'];
                            $table = $_GET['table'];    
                            $user = $conn -> query("SELECT * FROM `$table` WHERE `id`='$id'")->fetch_assoc();
                        ?>
                        <table>
                            <tr>
                                <th>Laboratorio</th>
                                <th>Computadoras</th>
                                <th>Admin</th>
                                <th>Opciones</th>
                            </tr>
                            <tr>
                                <form action="../actions/update?id=<?php echo $user['id'] ?>&table=laboratories" method="post">
                                    <td><input type="text" name="name" value="<?php echo $user['id'] ?>" placeholder="Laboratorio" style="border-radius:5px;width:120px; background-color: #562a3c; border:none; color:white;">
                                    </td>
                                    <td><input type="number" min="0" max="20" name="computersQuantity" id="computers_quantity" placeholder="Cantidad de computadoras" value="<?php echo $user['computers_quantity'] ?>" style="width:30px; background-color: transparent; border:none; color:white;"></td>
                                    <td><select name="admin_id" id="admin_id" style="border-radius:5px;width:120px; background-color: #562a3c; border:none; color:white;">
                                            <?php
                                                $roles = $conn -> query("SELECT id, name, surname FROM users WHERE rol_id=2");
                                                if($roles -> num_rows > 0){
                                                    while($row = $roles -> fetch_assoc()){
                                                        echo "<option value='".$row['id']."'>".$row['name']." ".$row['surname']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" name="laboratories" style="background-color: transparent; border:none; color:white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                            </svg>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        </table>
                    <?php }} ?>
                    </div>
                </div>
                <div class="content-wrapper" id="roles">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Roles</th>
                                <th>Opciones</th>
                            </tr>
                            <?php
                                $result = $conn->query("SELECT name, id FROM roles");
                                if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row["name"] ?></td>
                                        <td>
                                            <div class="button-wrapper">
                                                <a href="./?id=<?php echo $row['id'] ?>&table=roles#roles"><button class='content-button status-button'>Editar</button></a>
                                                <div class="menu">
                                                    <button class="dropdown">
                                                        <ul style="height:fit-content;">
                                                            <li><a href="../actions/delete?id=<?php echo $row["id"] ?>&table=roles">Borrar</a></li>
                                                        </ul>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                                }
                            ?>
                            <tr>
                                <form action="../actions/create" method="post">
                                <td><input type="text" name="name" id="name" placeholder="Nombre"></td>
                                <td>
                                <div class="button-wrapper">
                                        <button class='content-button status-button' type="submit">Agregar</button>
                                        <button type="reset">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                            </svg>
                                        </button>
                                        </div>
                                    </div>
                                </td>
                                </form>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="content-wrapper" id="name_materias">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Materia</th>
                                <th>Opciones</th>
                            </tr>
                            <?php
                                $result = $conn->query("SELECT name, id FROM subjects_names");
                                if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row["name"] ?></td>
                                        <td>
                                            <div class="button-wrapper">
                                                <a href="./?id=<?php echo $row['id'] ?>&table=roles#roles"><button class='content-button status-button'>Editar</button></a>
                                                <div class="menu">
                                                    <button class="dropdown">
                                                        <ul style="height:fit-content;">
                                                            <li><a href="../actions/delete?id=<?php echo $row["id"] ?>&table=roles">Borrar</a></li>
                                                        </ul>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay-app"></div>
    </div>
    <script>
        let target = $(location).attr('hash').substring(0, $(location).attr('hash').indexOf("?")) || $(location).attr('hash') || '#usuarios';
        $('.main-container > div + div').not(target).hide();
        $(target).fadeIn(600);
        $('.side-menu.admin a').on('click', function (e) {
            e.preventDefault();
            $('.main-header .header-menu a').addClass('is-active');
            $('.main-header .header-menu a').siblings().removeClass('is-active');
            target = $(this).attr('href');

            $('.main-container > div + div').not(target).hide();
            
            $(target).fadeIn(600);
        
        });
        $('.main-header .header-menu a').on('click', function (e) {
            e.preventDefault();
            $(this).addClass('is-active');
            $(this).siblings().removeClass('is-active');
            target = $(this).attr('href');

            $('.main-container > div + div').not(target).hide();
            
            $(target).fadeIn(600);
        
        });
        document.querySelectorAll(".dropdown").forEach((dropdown) => {
            dropdown.addEventListener("click", (e) => {
            e.stopPropagation();
            document.querySelectorAll(".dropdown").forEach((c) => c.classList.remove("is-active"));
            dropdown.classList.add("is-active");
            });
        });
        $(document).click(function (e) {
            const container = $(".status-button");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $(".dropdown").removeClass("is-active");
            }
        });

        $(function () {
            $(".dropdown").on("click", function (e) {
                $(".content-wrapper").addClass("overlay");
                e.stopPropagation();
            });
            $(document).on("click", function (e) {
                if ($(e.target).is(".dropdown") === false) {
                $(".content-wrapper").removeClass("overlay");
            }
            });
        });
        document.querySelector('.dark-light').addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
        });
    </script>
</body>

</html>