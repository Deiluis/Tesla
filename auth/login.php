<?php
    include('../connection.php');
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query_user = mysqli_query(
        $conn, "SELECT * FROM users WHERE username='$username'"
    );

    $user = mysqli_fetch_array($query_user);

    if (isset($user['id'])) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: ../');
            exit;
        } else {
            $_SESSION['error'] = 'La contraseña es incorrecta <a href="#">¿Olvidaste tu contraseña?</a>';
            return print('
                <script>
                    window.location = "../";
                </script>
            ');
        }
    } else {
        $_SESSION['error'] = 'El usuario y contraseña no corresponde a ningún usuario';
        print('
            <script>
                window.location = "../";
            </script>
        ');
    }
    exit;
?>