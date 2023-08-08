<?php
if(isset($_GET['courseId']) || isset($_GET['divisionId'])){
include('../connection.php');
$curso = $_GET['courseId'];
$division = $_GET['divisionId'];
$query = "
SELECT subjects.*, subjects_names.name
    FROM subjects_names 
    INNER JOIN subjects
    ON subjects.name_id = subjects_names.id
    WHERE course = $curso AND division = $division
";

$result = $conn -> query($query);
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
    
        if ($result -> num_rows > 0) {
            while ($row = $result -> fetch_assoc()) { ?>
                <a href="files?id=<?php echo $row['id'] ?>">
                    <div class="card">
                        <img src="https://www.quimica-organica.com/wp-content/uploads/2017/12/la-materia-electron-atomo.png"/>
                        <span><?php echo $row["name"] ?></span>
                    </div>
                </a>
        <?php
            }
        }
        ?>
    </div>
</body>
</html>
<?php } else header('Location: ../library');  ?>