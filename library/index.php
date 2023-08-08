
<?php
include('../connection.php');

$query = "
    SELECT *
    FROM laboratories
";

$result = $conn -> query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tesla - Biblioteca</title>
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
    <h1>Tesla - Biblioteca</h1>
    <p>Elegí el curso al que queres acceder.</p>
    <div class="container">
    <?php
    for ($i = 1; $i <= 7; $i++) { ?>
        <a href="./divisions?courseId=<?php echo $i ?>">
            <div class="card">
                <img src="https://www.quimica-organica.com/wp-content/uploads/2017/12/la-materia-electron-atomo.png"/>
                <span><?php echo $i ?>º año</span>
            </div>
        </a>
    <?php
    }
    ?>
    </div>
</body>
</html>