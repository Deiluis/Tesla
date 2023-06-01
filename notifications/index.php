<?php
include('../connection.php');

$admin_id = $_GET['adminId'];

$query = "
    SELECT notifications.*
    FROM laboratories
    INNER JOIN notifications
    ON laboratories.id = notifications.laboratory_id 
    WHERE admin_id = '$admin_id'
";

$result = $conn -> query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/41b6154676.js" crossorigin="anonymous"></script>
</head>
<body>
    <table>
        <tr>
            <td>Laboratorio</td>
            <td>Computadora</td>
            <td>Descripción</td>
            <td>Estado</td>
            <td>Opciones</td>
        </tr>
        <?php
        while ($row = $result -> fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['laboratory_id'] ?></td>
                <td><?php echo $row['computer'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['status'] ?></td>
                <td><button><i class="fa-solid fa-check"></i></button></td>
            </tr> <?php 
        } ?>
    </table>
</body>
</html>