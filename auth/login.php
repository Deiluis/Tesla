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
            header('Location: ../dashboard');
        } else {
            echo '
                <script>
                    alert("Usuario no existe, verifique los datos ingresados");
                    window.location = "./";
                </script>
            ';
            session_destroy();
        }
    } else {
        echo '
            <script>
                alert("Usuario no existe, verifique los datos ingresados");
                window.location = "./";
            </script>
        ';
        session_destroy();
    }
    exit;
?>