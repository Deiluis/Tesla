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
        $division = $_POST['division'];
        $group = $_POST['group'];
        $professor = $_POST['professor'];
        $laboratory = $_POST['laboratory'];

        $query = "
        INSERT INTO `subjects` (`id`, `name_id`, `course`, `division`, `group`, `professor_id`, `laboratory_id`) 
        VALUES (NULL, $name, $course , $division, '$group', $professor, '$laboratory')
        ";

        if ($conn -> query($query)) {

            // Al crear la materia, crea también la carpeta donde se alojarán sus archivos.
            $new_subject_id = $conn -> insert_id;
            $folderPath = "../uploads/subject-$new_subject_id";
            mkdir($folderPath);

            header('Location: ../admin');
        } else {
            echo $conn -> error;
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
    if (isset($_POST['name_subjects'])) {
        $name = $_POST['name'];
        if ($conn->query("INSERT INTO `subjects_names` (`id`, `name`) VALUES (NULL, '$name')")) {
            header('Location: ../admin');
        } else {
            echo $conn->error;
        }
    }
    if (isset($_POST['inventory'])) {
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $quantity = $_POST['quantity'];
        $laboratory = $_POST['laboratory'];
        if ($conn->query("INSERT INTO `inventory` (`id`, `name`, `description`, `quantity`, `laboratory_id`) VALUES (NULL, '$name', '$desc', $quantity, '$laboratory')")) {
            header("Location: ../?items_id=$laboratory#inventario");
        } else {
            echo $conn->error;
        }
    }
    if (isset($_POST['reservation'])) {
        $user = $_POST['user'];
        $item = $_POST['item'];
        $date = $_POST['date'];
        $start = $_POST['startTime'];
        $finish = $_POST['endTime'];
        $description = $_POST['description'];
        $laboratory = $_POST['laboratory'];
        if ($conn->query("INSERT INTO `reservations` (`id`, `user_id`, `item_id`, `date`, `start_time`, `finish_time`, `description`) VALUES (NULL, '$user', '$item', '$date', '$start', '$finish', '$description')")) {
            header("Location: ../?items_id=$laboratory#inventario");
        } else {
            echo $conn->error;
        }
    }
?>