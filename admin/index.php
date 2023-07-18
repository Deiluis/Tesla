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
                    <svg viewBox="0 0 24 24" fill="currentColor" height="24"  width="24" focusable="false" style="    margin-left: 10px;
                    margin-bottom: 5px; pointer-events: none; display: block; width: 100%; height: 100%;"><path d="M20 3v18H8v-1h11V4H8V3h12zm-8.9 12.1.7.7 4.4-4.4L11.8 7l-.7.7 3.1 3.1H3v1h11.3l-3.2 3.3z"></path></svg>
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
                                
                                    <a href="../actions/delete?id=<?php echo $row["id"] ?>&table=users">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                    </a>
                                    <a href="editRegister?id=<?php echo $row["id"] ?>&table=users">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                    </a>
                                </td>
                                </tr>

                            <?php }
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="content-wrapper" id="materias">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Materia</th>
                                <th>Curso</th>
                                <th>Profesor</th>
                                <th>Laboratorio</th>
                            </tr>
                            <tr>
                                <td>Instalación y mantenimiento de redes informáticas</td>
                                <td>la colo</td>
                                <td>COLO</td>
                                <td>colo@colo.ar</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                                <td>la colo</td>
                                <td>COLO</td>
                                <td>colo@colo.ar</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                                <td>la colo</td>
                                <td>COLO</td>
                                <td>colo@colo.ar</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                                <td>la colo</td>
                                <td>COLO</td>
                                <td>colo@colo.ar</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="content-wrapper" id="roles">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Roles</th>
                            </tr>
                            <tr>
                                <td>Ematp</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="content-wrapper" id="laboratorios">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Laboratorio</th>
                                <th>Computadoras</th>
                                <th>Admin</th>
                            </tr>
                            <tr>
                                <td>EMATP</td>
                                <td>EMATP</td>
                                <td>EMATP</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                                <td>Colo</td>
                                <td>Colo</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                                <td>Colo</td>
                                <td>Colo</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                                <td>Colo</td>
                                <td>Colo</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="content-wrapper" id="name_materias">
                    <div class="content-section">
                        <table>
                            <tr>
                                <th>Materia</th>
                            </tr>
                            <tr>
                                <td>EMATP</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                            </tr>
                            <tr>
                                <td>Colo</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay-app"></div>
    </div>
    <script>
        let target = $(location).attr('hash') || '#usuarios';
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
        document.querySelector('.dark-light').addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
        });
    </script>
</body>

</html>