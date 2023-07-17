<?php
include('../connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tesla - Crear cuenta</title>
  <style>
    .tablas {
      display: grid;
      grid-template-columns: auto auto;
    }

    body {
      font-size: 12px;
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
    }

    table td a {
      display: flex;
      justify-content: center;
      background-color: #ff6b6b;
      color: white;
      border: none;
      border-radius: 20%;
      padding: 5px;
      cursor: pointer;
      text-decoration: none;
    }

    table td a:last-child {
      background-color: #6b88ff;
    }

    input {
      border: 1px solid #ddd;
      padding: 5px;
      width: 94%;
    }

    table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    table tr:last-child {
      background-color: #fff;
      width: 10px;
    }

    table th {
      padding-top: 8px;
      padding-bottom: 8px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }

    table th:last-child {
      text-align: left;
      background-color: #ffAA6D;
      color: white;
    }
  </style>
</head>

<body>
  <div class="tablas">
    <table>
      <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Usuario</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Opciones</th>
      </tr>
      
        
      <?php

      $result = $conn->query("SELECT users.*, roles.name AS roles FROM users INNER JOIN roles ON roles.id = users.rol_id");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>

          <tr>
            <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["surname"] ?></td>
            <td><?php echo $row["username"] ?></td>
            <td><?php echo $row["email"] ?></td>
            <td><?php echo $row["roles"] ?></td>
            <td>
            
              <a href="../actions/delete?id=<?php echo $row["id"] ?>&table=users">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
              </a>
              <a href="editRegister?id=<?php echo $row["id"] ?>&table=users">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                </svg>
              </a>
            </td>
          </tr>

      <?php }
      }
      ?>
      <tr>
        <form action="../actions/create" method="post">
          <td><input type="text" name="name" id="name" placeholder="Nombre"></td>
          <td><input type="text" name="surname" id="surname" placeholder="Apellido"></td>
          <td><input type="text" name="username" id="username" placeholder="Nombre de usuario"></td>
          <td><input type="email" name="email" id="email" placeholder="Email"></td>
          <td>
            <select name="rol_id" id="rol_id">
              <?php
              $result = $conn->query("SELECT * FROM roles");
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
              }
              ?>
            </select>
          </td>
          <td>
            <button type="reset">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
              </svg>
            </button>
            <button type="submit" name="account">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
              </svg>
            </button>
          </td>
        </form>
      </tr>
    </table>
    <table>
      <tr>
        <th>Materia</th>
        <th>Curso</th>
        <th>Profesor</th>
        <th>Laboratorio</th>
        <th>Opciones</th>
      </tr>
      <?php
      $result = $conn->query("SELECT subjects.id, subjects.course, subjects.division, subjects.group, subjects_names.name, users.name AS professor, subjects.laboratory_id FROM subjects INNER JOIN subjects_names ON subjects.name_id = subjects_names.id INNER JOIN users ON subjects.professor_id = users.id");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["course"] . "°" . $row["division"] . " - " . $row["group"] ?></td>
            <td><?php echo $row["professor"]?></td>
            <td><?php echo $row["laboratory_id"] ?></td>
            <td>
              <a href="../actions/delete?id=<?php echo $row["id"] ?>&table=subjects">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
              </a>
              <a href="editRegister?id=<?php echo $row["id"] ?>&table=subjects">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                </svg>
              </a>
            </td>
          </tr>
      <?php }
      }
      ?>
      <tr>
        <form action="../actions/create" method="post">
                      <td><select  style='width:200px;' name="course" id="course">
              <?php
              $result = $conn->query("SELECT * FROM subjects_names");
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                          <option value='" . $row['id'] . "'>". $row['name'] . "</option>
                        ";
                }
              }
              ?>
            </select></td>
          <td>
            <select name="course" id="course">
              <?php
              $result = $conn->query("SELECT * FROM subjects ORDER BY course");
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                          <option value='" . $row['id'] . "'>
                            ". $row['course'] . "°" . $row['division'] . " - " . $row['group'] ."
                          </option>
                        ";
                }
              }
              ?>
            </select>
          </td>
          <td>
            <select name="professor" id="professor">
              <?php
              $result = $conn->query("SELECT * FROM users WHERE rol_id=1");
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['id'] . "'>" . $row['name'] . " " . $row['surname'] . "</option>";
                }
              }
              ?>
            </select>
          </td>
          <td>
            <select name="laboratory" id="laboratory">
              <?php
              $result = $conn->query("SELECT * FROM laboratories");
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                }
              }
              ?>
            </select>  
          </td>
          <td>
            <button type="reset">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
              </svg>
            </button>
            <button type="submit" name="subject">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
              </svg>
            </button>
          </td>
        </form>
      </tr>
    </table>
    <table>
      <tr>
        <th>Roles</th>
        <th>Opciones</th>
      </tr>
      <?php
      $result = $conn->query("SELECT * FROM roles");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row["name"] ?></td>
            <td>
            <a href="../actions/delete?id=<?php echo $row["id"] ?>&table=roles">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
              </a>
              <a href="editRegister?id=<?php echo $row["id"] ?>&table=roles">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                </svg>
              </a>
            </td>
          </tr>
      <?php }
      }
      ?>
      <tr>
        <form action="../actions/create" method="post">
          <td><input type="text" name="name" id="name" placeholder="Nombre"></td>
          <td>
            <button type="reset">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
              </svg>
            </button>
            <button type="submit" name="roles">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
              </svg>
            </button>
          </td>
        </form>
      </tr>
    </table>
    <table>
      <tr>
        <th>Laboratorio</th>
        <th>Computadoras</th>
        <th>Admin</th>
        <th>Opciones</th>
      </tr>
      <?php
      $result = $conn->query("SELECT laboratories.*,users.name,users.surname FROM laboratories INNER JOIN users ON users.id = laboratories.admin_id ");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row["id"] ?></td>
            <td><?php echo $row["computers_quantity"] ?></td>
            <td><?php echo $row["name"] . ' ' . $row["surname"] ?></td>
            <td>
              <a href="../actions/delete?id=<?php echo $row["id"] ?>&table=laboratories">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
              </a>
              <a href="editRegister?id=<?php echo $row["id"] ?>&table=laboratories">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                </svg>
              </a>
            </td>
          </tr>
      <?php }
      }
      ?>
      <tr>
        <form action="../actions/create" method="post">
          <td><input type="text" name="name" id="name" placeholder="Nombre"></td>
          <td><input type="text" name="computers" id="computers" placeholder="Numero de compus"></td>
          <td>
            <select name="admin_id" id="admin">
              <?php
              $result = $conn->query("SELECT * FROM users WHERE rol_id=2");
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['id'] . "'>" . $row['name'] . " " . $row['surname'] . "</option>";
                }
              }
              ?>
            </select>
          </td>
          <td>
            <button type="reset">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
              </svg>
            </button>
            <button type="submit" name="laboratories">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
              </svg>
            </button>
          </td>
        </form>
      </tr>
    </table>
    <table>
      <tr>
        <th>Nombre</th>
        <th>Opciones</th>
      </tr>
      <?php
      $result = $conn->query("SELECT * FROM subjects_names");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row["name"] ?></td>
            <td>
            <a href="../actions/delete?id=<?php echo $row["id"] ?>&table=courses">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
              </a>
              <a href="editRegister?id=<?php echo $row["id"] ?>&table=courses">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                </svg>
              </a>
            </td>
          </tr>
      <?php }
      }
      ?>
      <tr>
        <form action="../actions/create" method="post">
          <td><input type="text" name="name" id="name" placeholder="Nombre"></td>
          <td>
            <button type="reset">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
              </svg>
            </button>
            <button type="submit" name="courses">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
              </svg>
            </button>
          </td>
        </form>
      </tr>
    </table>
    <form action="actions/upload" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <select name="subject_id" id="subject_id">
          <?php
          $result = $conn->query("SELECT id, name FROM subjects_names");
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row['id'] . "'>" . $row['name'] ."</option>";
            }
          }
          ?>
        </select>
        <input type="submit" value="Subir">

    </form>
  </div>
</body>

</html>