<?php
    include('../connection.php');

    $id = $_GET['id'];
    $table = $_GET['table'];

    if ($table == 'notifications') {
        $resolve = $_GET['status_id'];
        $values = "`status_id` = '$resolve'";
        if ($conn->query("UPDATE `$table` SET $values WHERE `id`=$id"))
            return header('Location: ../admin/observaciones');
        else
            return print $SQL .' ||| \n '. $conn->error;
    }

    if (isset($_POST['account'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $rol_id = $_POST['rol_id'];

        $values = 
        "`name`='$name', `surname`='$surname', `email`='$email', `username`='$username', `rol_id`='$rol_id'";
        if($_POST['password'] != ''){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $values .= ", `password`='$password'";
        }
    }

    if (isset($_POST['subject'])) {
        $name = $_POST['name'];
        $course = $_POST['course'];
        $division = $_POST['division'];
        $group = $_POST['group'];
        $professor = $_POST['professor'];
        $laboratory = $_POST['laboratory'];

        $values = "`name_id` = $name, `course`=$course, `division`=$division, `group`='$course', `professor_id`=$professor, `laboratory_id`='$laboratory'";
    }

    if (isset($_POST['roles'])) {
        $name = $_POST['name'];

        $values = "`name` = '$name'";
    }

    if (isset($_POST['laboratories'])) {
        $name = $_POST['name'];
        $computersQuantity = $_POST['computersQuantity'];
        $adminId = $_POST['admin_id'];

        $values = "`id` = '$name', `computers_quantity`=$computersQuantity, `admin_id`='$adminId'";
        if ($conn->query("UPDATE `$table` SET $values WHERE `id`='$id'"))
            return header('Location: ../admin/#laboratorios');
        else
            return print($values .' ||| \n '. $conn->error);
    }
     
    if (isset($_POST['courses'])) {
        $year = $_POST['year'];
        $division = $_POST['division'];
        $subgroup = $_POST['subgroup'];
        $sector = $_POST['sector'];

        $values = "`year` = '$year', `division`='$division', `subgroup`='$subgroup', `sector`='$sector'";
    }
    if ($conn->query("UPDATE `$table` SET $values WHERE `id`=$id"))
        header('Location: ../admin');
    else
        echo "UPDATE `$table` SET $values WHERE `id`=$id" .' ||| \n '. $conn->error;
?>