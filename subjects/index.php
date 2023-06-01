<?php
include('../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tesla - Iniciar sesión</title>
    <style>
        .card{
            width: 200px;
            height: 200px;
            border: solid 1px black;
            border-radius: 10px;
            padding: 0;
            margin: 10px;
            position: relative;
            display: flex;
            justify-content: center;
        }
        .card span{
            position: absolute;
            bottom: 0;
            text-decoration: none;
            color: black;
        }
        .card img{
            position: absolute;
            top: 0;
            width: 150px;
        }
        .container{
            display: flex;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <h1>Tesla - La plataforma web</h1>
    <div class="container">
      <?php
      $result = $conn->query("SELECT name,id from subjects");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
        <a href="files?id=<?php echo $row['id'] ?>">
            <div class="card">
                <img src="https://www.quimica-organica.com/wp-content/uploads/2017/12/la-materia-electron-atomo.png"/>
                <span><?php echo $row["name"] ?></span>
            </div>
        </a>
      <?php }
      }
      ?>
    </div>
</body>
</html>