<?php
session_start();
include('../connection.php');
$id = $_SESSION['user']['id'];
$query = "
    SELECT notifications.*
    FROM laboratories
    INNER JOIN notifications
    ON laboratories.id = notifications.laboratory_id 
    WHERE admin_id = '$id'
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
                <td>
                <?php if ($row['status'] == 'unresolved'){?>
                    <a href="../actions/update?id=<?php echo $row['id'] ?>&table=notifications&status=resolved"><i class="fa-solid fa-check"></i></a>
                <?php } else { ?>
                    <a href="../actions/update?id=<?php echo $row['id'] ?>&table=notifications&status=unresolved"><i class="fa-solid fa-check"></i></a>
                <?php } ?>
                    <a href="../actions/delete?id=<?php echo $row['id'] ?>&table=notifications"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/></svg></a>
                </td>
            </tr> <?php 
        } ?>
    </table>
</body>
</html>