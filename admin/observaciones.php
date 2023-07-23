<?php
    session_start();
    include('../connection.php');
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
    $rol = $_SESSION['user']['rol_id'];
    $notifications = $conn->query("
        SELECT COUNT(*)
        FROM laboratories
        INNER JOIN notifications
        ON laboratories.id = notifications.laboratory_id 
        WHERE laboratories.admin_id = $id AND notifications.status_id = 1;
    ")->fetch_assoc();
    $laboratories = $conn->query("
        SELECT laboratories.id, GROUP_CONCAT(notifications.status_id SEPARATOR ',') AS estados
        FROM `laboratories` 
        INNER JOIN notifications ON laboratories.id = notifications.laboratory_id
        WHERE admin_id = $id
        GROUP BY laboratories.id 
    ");
    $query = $conn->query("
    SELECT laboratories.id,
        GROUP_CONCAT(notifications.id SEPARATOR ',') AS id_pc,
        GROUP_CONCAT(notifications.computer SEPARATOR ',') AS computadoras,
        GROUP_CONCAT(notifications.description SEPARATOR ',') AS descripciones,
        GROUP_CONCAT(notifications.status_id SEPARATOR ',') AS estados
    FROM laboratories 
    INNER JOIN notifications ON laboratories.id = notifications.laboratory_id 
    WHERE admin_id = $id 
    GROUP BY laboratories.id 
    ORDER BY laboratories.id, notifications.computer;
    ");
?>
<!DOCTYPE html>
<html lang="es-AR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <title>Dashboard - Observaciones</title>
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
                    ?> <a class="menu-link is-active notify">Observaciones</a> <?php
                }else{
                    ?> <a class="menu-link is-active">Observaciones</a> <?php } ?>
                <a class="menu-link" href="./">Panel de Administracion</a>
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
                <a href="#">
                    <svg viewBox="0 0 512 512" fill="currentColor">
                        <path d="M448.773 235.551A135.893 135.893 0 00451 211c0-74.443-60.557-135-135-135-47.52 0-91.567 25.313-115.766 65.537-32.666-10.59-66.182-6.049-93.794 12.979-27.612 19.013-44.092 49.116-45.425 82.031C24.716 253.788 0 290.497 0 331c0 7.031 1.703 13.887 3.006 20.537l.015.015C12.719 400.492 56.034 436 106 436h300c57.891 0 106-47.109 106-105 0-40.942-25.053-77.798-63.227-95.449z" />
                    </svg>
                </a>
                <a href="../auth/logout">
                    <svg viewBox="0 0 24 24" fill="currentColor" height="24" width="24" focusable="false"
                        class="logout">
                        <path
                            d="M20 3v18H8v-1h11V4H8V3h12zm-8.9 12.1.7.7 4.4-4.4L11.8 7l-.7.7 3.1 3.1H3v1h11.3l-3.2 3.3z">
                        </path>
                    </svg>
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
                        <a href="#">
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
                    <div class="side-menu">
                    <a href="./#usuarios">
                            <svg viewBox="0 0 512 512" fill="currentColor">
                                <circle cx="295.099" cy="327.254" r="110.96" transform="rotate(-45 295.062 327.332)" />
                                <path d="M471.854 338.281V163.146H296.72v41.169a123.1 123.1 0 01121.339 122.939c0 3.717-.176 7.393-.5 11.027zM172.14 327.254a123.16 123.16 0 01100.59-120.915L195.082 73.786 40.146 338.281H172.64c-.325-3.634-.5-7.31-.5-11.027z" />
                            </svg>
                            Usuarios
                        </a>
                        <a href="./#materias">
                            <svg viewBox="0 0 488.455 488.455" fill="currentColor">
                                <path d="M287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0" />
                                <path d="M427.397 91.581H385.21l-30.544-61.059H133.76l-30.515 61.089-42.127.075C27.533 91.746.193 119.115.164 152.715L0 396.86c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059V152.639c-.001-33.674-27.385-61.058-61.059-61.058zM244.22 381.61c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118S311.555 381.61 244.22 381.61z" />
                            </svg>
                            Materias
                        </a>
                        <a href="./#laboratorios">
                            <svg viewBox="0 0 488.455 488.455" fill="currentColor">
                                <path d="M287.396 216.317c23.845 23.845 23.845 62.505 0 86.35s-62.505 23.845-86.35 0-23.845-62.505 0-86.35 62.505-23.845 86.35 0" />
                                <path d="M427.397 91.581H385.21l-30.544-61.059H133.76l-30.515 61.089-42.127.075C27.533 91.746.193 119.115.164 152.715L0 396.86c0 33.675 27.384 61.074 61.059 61.074h366.338c33.675 0 61.059-27.384 61.059-61.059V152.639c-.001-33.674-27.385-61.058-61.059-61.058zM244.22 381.61c-67.335 0-122.118-54.783-122.118-122.118s54.783-122.118 122.118-122.118 122.118 54.783 122.118 122.118S311.555 381.61 244.22 381.61z" />
                            </svg>
                            Laboratorios
                        </a>
                        <a href="./#roles">
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
                    <a class="menu-link-main" href="#">Laboratorios</a>
                    <div class="header-menu">
                    <?php while ($row = $laboratories -> fetch_assoc()){ 
                        if(in_array(1, explode(",",$row["estados"]))){ ?>
                            <a class="main-header-link notify" href="#<?php echo $row['id'] ?>"><?php echo $row['id'] ?></a> <?php 
                        } else { ?>
                            <a class="main-header-link" href="#<?php echo $row['id'] ?>"><?php echo $row['id'] ?></a> <?php
                        }} ?>
                    </div>
                </div>
                <?php
                    while ($row = $query -> fetch_assoc()) { $idPc = explode(",", $row["id_pc"]) ?>
                        <div class="content-wrapper" id="<?php echo $row['id'] ?>">
                            <div class="content-section">
                                <ul>
                                <?php for($i = 0; $i < count(explode(",", $row["computadoras"])); $i++){  ?>             

                                    <li class="adobe-product">
                                        <div class="products">PC - <?php echo explode(",", $row["computadoras"])[$i] ?></div>
                                        <span class="status">
                                            <?php switch(explode(",", $row["estados"])[$i]){
                                                case 1: print "<span class='status-circle red'></span>";break;
                                                case 2: print "<span class='status-circle '></span>";break;
                                                case 3: print "<span class='status-circle green'></span>";break;
                                                default: break;
                                            } echo explode(",", $row["descripciones"])[$i] ?>
                                        </span>
                                        <div class="button-wrapper">
                                            <?php switch(explode(",", $row["estados"])[$i]){
                                                case 1: ?> <a href="../actions/update?id=<?php echo $idPc[$i] ?>&table=notifications&status_id=3"><button class='content-button status-button'>Resolver</button></a><?php break;
                                                case 2: ?> <a href="../actions/update?id=<?php echo $idPc[$i] ?>&table=notifications&status_id=3"><button class='content-button status-button'>Resolver</button></a><?php break;
                                                case 3: ?> <a href="../actions/update?id=<?php echo $idPc[$i] ?>&table=notifications&status_id=1"><button class='content-button status-button open'>Resuelto</button></a><?php break;
                                                default: break;
                                            }?>
                                            <div class="menu">
                                                <button class="dropdown">
                                                    <ul>
                                                        <li><a href="../actions/update?id=<?php echo $idPc[$i] ?>&table=notifications&status_id=2">En revision</a></li>
                                                        <li><a href="#">Relevamiento</a></li>
                                                        <li><a href="../actions/delete?id=<?php echo $idPc[$i] ?>&table=notifications">Borrar</a></li>
                                                    </ul>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php 
                    } ?>
            </div>
        </div>
        <div class="overlay-app"></div>
    </div>
    <script>
        $('.header-menu a:first-child').addClass('is-active');
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