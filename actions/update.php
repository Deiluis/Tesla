<?php
    include('../connection.php');

    $id = $_GET['id'];
    $table = $_GET['table'];

    if (isset($_POST['account'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $rol_id = $_POST['rol_id'];

        $values = 
        "`name`='$name', `surname`='$surname', `email`='$email', `username`='$username', `password`='$password', `rol_id`='$rol_id'";
    }

    if (isset($_POST['subject'])) {
        $name = $_POST['name'];
        $course = $_POST['course'];
        $professor = $_POST['professor'];
        $laboratory = $_POST['laboratory'];

        $values = "`name` = '$name', `course_id`=$course, `professor_id`=$professor, `laboratory`='$laboratory'";
    }

    if (isset($_POST['roles'])) {
        $name = $_POST['name'];

        $values = "`name` = '$name'";
    }

    if (isset($_POST['laboratories'])) {
        $name = $_POST['name'];
        $computersQuantity = $_POST['computersQuantity'];
        $adminId = $_POST['admin_id'];

        $values = "`id` = '$name', `computers_quantity`='$computersQuantity', `admin_id`='$adminId'";
    }
     
    if (isset($_POST['courses'])) {
        $year = $_POST['year'];
        $division = $_POST['division'];
        $subgroup = $_POST['subgroup'];
        $sector = $_POST['sector'];

        $values = "`year` = '$year', `division`='$division', `subgroup`='$subgroup', `sector`='$sector'";
    }
    $SQL = "UPDATE `$table` SET $values WHERE `id`=$id";
    if ($conn->query("UPDATE `$table` SET $values WHERE `id`=$id"))
        header('Location: ../admin');
    else
        echo $SQL .' ||| '. $conn->error;
?>