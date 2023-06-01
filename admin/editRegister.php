<?php
include('../connection.php');

$id = $_GET['id'];
$table = $_GET['table'];
if($table === 'laboratories'){
    $result = $conn -> query("SELECT * FROM `$table` WHERE `id`='$id'");
}else{
    $result = $conn -> query("SELECT * FROM `$table` WHERE `id`=$id");
}
$user = $result -> fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>
<body>
    <?php
    switch ($_GET['table']) {
        case 'users':
            ?>
            <form action="../actions/update?id=<?php echo $user['id'] ?>&table=users" method="post">
                <input type="text" name="name" id="name" placeholder="Nombre" value="<?php echo $user['name'] ?>">
                <input type="text" name="surname" id="surname" placeholder="Apellido" value="<?php echo $user['surname'] ?>">
                <input type="text" name="username" id="username" placeholder="Nombre de usuario" value="<?php echo $user['username'] ?>">
                <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $user['email'] ?>">
                <input type="password" name="password" id="password" placeholder="Contraseña" value="********">
                <select name="rol_id" id="rol_id">
                    <?php
                        $roles = $conn -> query("SELECT * FROM roles");
                        if($roles -> num_rows > 0){
                            while($row = $roles -> fetch_assoc()){
                                echo "<option value='".$row['id']."'>".$row['name']."</option>";
                            }
                        }
                    ?>
                </select>
                <button type="submit" name="account">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                    </svg>
                </button>
            </form>
            <?php
            break;
        case 'roles':
            ?>
            <form action="../actions/update?id=<?php echo $user['id'] ?>&table=roles" method="post">
                <input type="text" name="name" id="name" placeholder="Nombre" value="<?php echo $user['name'] ?>">
                <button type="submit" name="roles">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                    </svg>
                </button>
            </form>
            <?php
            break;
        case 'laboratories':
            ?>
            <form action="../actions/update?id=<?php echo $user['id'] ?>&table=laboratories" method="post">
                <input type="text" name="name" id="name" placeholder="Nombre" value="<?php echo $user['id'] ?>">
                <input type="text" name="computersQuantity" id="name" placeholder="Nombre" value="<?php echo $user['computers_quantity'] ?>">
                <select name="admin_id" id="course">
                    <?php
                        $roles = $conn -> query("SELECT * FROM users WHERE rol_id=2");
                        if($roles -> num_rows > 0){
                            while($row = $roles -> fetch_assoc()){
                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . " " . $row['surname'] . "</option>";
                            }
                        }
                    ?>
                </select>

                <button type="submit" name="laboratories">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                    </svg>
                </button>
            </form>
            <?php
            break;
        case 'courses':
            ?>
            <form action="../actions/update?id=<?php echo $user['id'] ?>&table=courses" method="post">
                <input type="text" name="year" id="name" placeholder="Nombre" value="<?php echo $user['year'] ?>">
                <input type="text" name="division" id="name" placeholder="Nombre" value="<?php echo $user['division'] ?>">
                <input type="text" name="subgroup" id="name" placeholder="Nombre" value="<?php echo $user['subgroup'] ?>">
                <input type="text" name="sector" id="name" placeholder="Nombre" value="<?php echo $user['sector'] ?>">

                <button type="submit" name="courses">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                    </svg>
                </button>
            </form>
            <?php
            break;
        default:
            echo 'NaN'; // code to be executed if n is different from all labels;
    }
    ?>

</body>
</html>