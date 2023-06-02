<?php
    include('../connection.php');
    if(isset($_GET['id'])) $result = $conn->query("SELECT * FROM inventory WHERE laboratory_id = '$_GET[id]'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <style>
      :root{
        font-size: 62.5%;
      }
    .tablas {
      display: grid;
      grid-template-columns: auto auto;
    }

    body {
      font-size: 1.7rem;
    }

    table {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    table td,
    table th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    table td:last-child {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      width: fit-content;
      white-space: nowrap;
    }

    table td a {
      display: flex;
      justify-content: center;
      background-color: #ff6b6b;
      color: white;
      border-radius: 20%;
      padding: .7rem;
      margin: 0 2px 0 2px;
      cursor: pointer;
      text-decoration: none;
    }
    .link--visualizar {
      background: #1e5fd8;
    }
    .link--disabled {
    background: #49556b;
    cursor: default;
    }

    table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    table th {
      padding-top: 8px;
      padding-bottom: 8px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
    table th:nth-child(2){
      width: 140px;
    }
    table th:last-child {
      text-align: left;
      background-color: #ffAA6D;
      color: white;
      width: 1px;
    }
    </style>
</head>

<body>
    <h2><?php echo $_GET['id'] ?></h2>
<table>
      <tr>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Cantidad</th>
        <th>Opciones</th>
      </tr>
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["description"] ?></td>
            <td><?php echo $row["quantity"] ?></td>
            <td>
            <a href="#" class="link--visualizar" id="<?php echo $row['id'] ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                </svg>
            </a>
            <a href="./delete?id=<?php echo $row['id'] ?>&laboratory=<?php echo $_GET['id'] ?>"
                class="link--eliminar link_delete"
                title="Eliminar">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                </svg>
            </a>
            </td>
          </tr>
      <?php }
      }
      ?>
    </table>
    <form action="../actions/create" method="post">
        <input type="text" name="name" placeholder="Nombre">
        <input type="text" name="description" placeholder="Descripcion">
        <input type="numeric" name="quantity" placeholder="Cantidad">
        <input type="hidden" name="laboratory" value="<?php echo $_GET['id'] ?>">
        <button type="submit" name="inventory">Subir</button>
    </form>
</body>
</html>