<?php
include('../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <style>
        .card{
            width: 200px;
            height: fit-content;
            border: solid 1px black;
            border-radius: 10px;
            padding: 0;
            margin: 10px;
            position: relative;
            display: flex;
            justify-content: center;
        }
        a {
            text-decoration: none;
        }
        .card span{
            position: relative;
            bottom: 0;
            text-decoration: none;
            color: black;
        }
        .container{
            display: flex;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
<div class="container">
      <?php
      $result = $conn->query("SELECT id from laboratories");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
        <a href="items?id=<?php echo $row['id'] ?>" class="card">
            <span><?php echo $row["id"] ?></span>
        </a>
      <?php }
      }
      ?>
    </div>
</body>
</html>