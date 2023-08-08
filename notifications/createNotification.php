<?php
include('../connection.php');

$query_ids = $conn -> query("SELECT `id` FROM laboratories");
$query = $conn -> query("SELECT * FROM laboratories");

$laboratories = $query -> fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nota - Tesla</title>
</head>
<body>
    <form action="./insertNotification" method="post">
        <label for="laboratory">Laboratorio</label>
        <select name="laboratory" id="laboratory">
            <option>Selecciona un laboratorio</option>
            <?php
            while($row = $query_ids -> fetch_assoc()) { ?>
                <option><?php echo $row['id'] ?></option> <?php
            } 
            ?>
        </select>
        <label for="computer">Computadora</label>
        <input type="number" name="computer" id="computer">
        <label for="description">Descripción del problema</label>
        <textarea name="description" id="description"></textarea>
        <button>Enviar</button>
    </form>
</body>
</html>