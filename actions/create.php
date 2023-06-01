<?php
    include('../connection.php');
    
    if (isset($_POST['account'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $rol_id = $_POST['rol_id'];

        if ($conn->query("INSERT INTO `users` (`id`, `name`, `surname`, `email`, `username`, `password`, `rol_id`) VALUES (NULL, '$name', '$surname', '$email', '$username', '$password', $rol_id)")) {
            header('Location: ../admin');
        } else {
            echo $conn->error;
        }
    }
    if (isset($_POST['subject'])) {
        $name = $_POST['name'];
        $course = $_POST['course'];
        $professor = $_POST['professor'];
        $laboratory = $_POST['laboratory'];

        if ($conn->query("INSERT INTO `subjects` (`id`, `name`, `course_id`, `professor_id`, `laboratory`) VALUES (NULL, '$name', $course, $professor, '$laboratory')")) {
            header('Location: ../admin');
        } else {
            echo $conn->error;
        }
    }
    if (isset($_POST['roles'])) {
        $name = $_POST['name'];
        if ($conn->query("INSERT INTO `roles` (`id`, `name`) VALUES (NULL, '$name')")) {
            header('Location: ../admin');
        } else {
            echo $conn->error;
        }
    }
    if (isset($_POST['laboratories'])) {
        $name = $_POST['name'];
        $computers = $_POST['computers'];
        $admin = $_POST['admin_id'];
        if ($conn->query("INSERT INTO `laboratories` (`id`, `computers_quantity`, `admin_id`) VALUES ('$name', $computers, '$admin')")) {
            header('Location: ../admin');
        } else {
            echo $conn->error;
        }
    }
    if (isset($_POST['courses'])) {
        $year = $_POST['year'];
        $division = $_POST['division'];
        $subgroup = $_POST['subgroup'];
        $sector = $_POST['sector'];
        if ($conn->query("INSERT INTO `courses` (`id`, `year`, `division`, `subgroup`, `sector`) VALUES (NULL, $year, $division, '$subgroup', $sector)")) {
            header('Location: ../admin');
        } else {
            echo $conn->error;
        }
    }
?>