<?php
session_start();
include('../connection.php');
if(isset($_SESSION['user'])){
  $rol = $_SESSION['user']['rol_id'];
}
if(isset($_GET['id']))
	$result = $conn->query("SELECT * FROM files WHERE subject_id = $_GET[id]");

$validExt = array('png', 'jpg', 'jpeg', 'svg', 'pdf', 'mp3', 'wav' ,'mp4');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Tesla - Iniciar sesión</title>
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

.modal, .modal-subir {
    display: flex;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 4750;
    background: #2228;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.5s 0.3s;
}

.modal--show, .modal-subir--show{
    opacity: 1;
    pointer-events: unset;
    transition: opacity 0.5s;
}

.modal .background, .modal-subir .background{
    width: 100%;
    height: 100%;
    position: absolute;
}

.modal .container, .modal-subir .container {
    display: flex;
    align-items: center;
    max-width: 100%;
    max-height: 75%;
    opacity: 0;
    margin: auto;
    transform: translateY(-100vh);
    transition: transform, opacity, 1s;
}

.modal .container--show, .modal-subir .container--show  {
    opacity: 1;
    transform: translateY(0);
    transition: transform, opacity, 1s;
}
.modal-subir .container {
    background: var(--color-gris-e);
    max-width: 95%;
    flex-direction: column;
    justify-content: space-between;
    padding: 3rem;
    width: 90rem;
    height: 50rem;
    border-radius: 30px;
}

.modal-subir img {
    width: 15rem;
    margin: 2rem;
}

.modal-subir form {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.modal-subir input {
    font-size: 1.7rem;
    padding: 7.5rem 2rem;
    align-self: center;
    background: var(--color-fondo);
    border-radius: 30px;
}

.modal-subir input:hover {
    outline: 1px solid var(--color-naranja-alt);
}

.modal .content--img {
    width: 120rem;
    height: 70rem;
    object-fit: contain;
}

.modal .content--pdf {
    width: 120rem;
    height: 65rem;
}

.modal .content--audio {
    width: 50rem;
}

.modal .content--video {
    width: 120rem;
    overflow: scroll;
}

.modal .close-button, .modal-subir .close-button{
    background: #2227;
    color: #fff;
    padding: 1.5rem 1.5rem;
    font-size: 4rem;
    opacity: 0.7;
    cursor: pointer;
    position: absolute;
    display: flex;
    top: 0;
    right: 0;
    z-index: 4800;
    transition: opacity 0.3s;
}
.modal .close-button:hover {
    opacity: 1;
}
.modal .container {
    display: flex;
    align-items: center;
    max-width: 100%;
    width: auto;
    max-height: 75%;
    height: auto;
    opacity: 0;
    margin: auto;
    transform: translateY(-100vh);
    transition: transform, opacity, 1s;
  }
  .modal .container--show {
      opacity: 1;
      transform: translateY(0);
      transition: transform, opacity, 1s;
  }
  .subir-archivos {
    padding-bottom: 4rem;
    display: flex;
    justify-content: center;
}

  </style>
</head>
<body>
    <h1>Tesla - La plataforma web</h1>
    <?php if(isset($rol)){ ?>
    <section class="subir-archivos">
      <a href="#" class="button button--larger">
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
          <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z"/>
        </svg>
        <span>Subir archivo</span>
      </a>
    </section>
    <?php }?>
    <table>
      <tr>
        <th>Nombre</th>
        <th>Tipo de archivo</th>
        <th>Opciones</th>
      </tr>
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["file_type"] ?></td>
            <td>
              <?php
                if (in_array($row['file_type'], $validExt)) {
              ?>
            <a href="#" class="link--visualizar" id="<?php echo $row['id'] ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                </svg>
            </a>
              <?php
                }else{
              ?>
              <a href="#" class="link--disabled" title="Este archivo no se puede visualizar"">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                  <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                  <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                </svg>
              </a>
              <?php
                }
              ?>
            <a href="./uploads/<?php echo $row['name'] ?>.<?php echo $row['file_type'] ?>" download class="link--descargar" title="Descargar">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-cloud-download-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.5a.5.5 0 0 1 1 0V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.354 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V11h-1v3.293l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                </svg>
            </a>
            <a href="../actions/delete.php?id=<?php echo $row['id'] ?>&table=files&id_materia=<?php echo $_GET['id'] ?>"
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
    <section class="modal-subir">
      <div class="background"></div>
      <div class="container">
          <form action="../actions/upload" method="POST" enctype="multipart/form-data">
              <input type="text" name="subject_id" value="<?php echo $_GET['id'] ?>" hidden>
              <input type="file" name="file" id="file" required>
              <input class="button button--larger" type="submit" value="Subir Archivo">
          </form>
      </div>
      <div href="#" class="close-button">
              <i class="icon fa-solid fa-xmark"></i>
      </div>

    </section>
    <section class="modal">
      <div class="background"></div>
      <div class="container"></div>
      <div href="#" class="close-button">
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
        </svg>
      </div>
    </section>
    <script>
      function obtainFileById(idFile) {
        $.ajax({
            type:"POST",
            data:"id-file="+idFile,
            url:"./obtainFile.php",
            success:function(res){
                $('.modal .container').html(res);
            }
        });
      }
      const modal = document.querySelector(".modal");
      const modalContainer = document.querySelector(".modal .container");
      const modalBackground = document.querySelector(".modal .background");
      const modalContent = document.querySelector(".modal .content");
      const modalCloseButton = document.querySelector(".modal .close-button");

      const showButton = document.querySelectorAll("table .link--visualizar");
      const disabledShowButton = document.querySelectorAll("table .link--disabled");

      showButton.forEach(button => {
          button.addEventListener("click", (e) => {
              e.preventDefault();
              modal.classList.add("modal--show");
              modalContainer.classList.add("container--show");
              
              obtainFileById(button.id);
          });
      });

      modalCloseButton.addEventListener("click", () => {
          modal.classList.remove("modal--show");
          modalContainer.classList.remove("container--show");
          const modalAudio = document.querySelector(".modal .content--audio");
          const modalVideo = document.querySelector(".modal .content--video");
          if (modalAudio != null) modalAudio.pause();
          if (modalVideo != null) modalVideo.pause();
      });

      modalBackground.addEventListener("click", () => {
          modal.classList.remove("modal--show");
          modalContainer.classList.remove("modal .container--show");
          const modalAudio = document.querySelector(".modal .content--audio");
          const modalVideo = document.querySelector(".modal .content--video");
          if (modalAudio != null) modalAudio.pause();
          if (modalVideo != null) modalVideo.pause();
      });

      disabledShowButton.forEach(button => {
          button.addEventListener("click", (e) => {
              e.preventDefault();
          });
      });
      const modalUp = document.querySelector(".modal-subir");
      const modalUpContainer = document.querySelector(".modal-subir .container");
      const modalUpBackground = document.querySelector(".modal-subir .background");
      const modalUpCloseButton = document.querySelector(".modal-subir .close-button");

      const upShowButton = document.querySelector(".subir-archivos .button");

      if (upShowButton != null) {

          upShowButton.addEventListener("click", (e) => {
              e.preventDefault();
              modalUp.classList.add("modal-subir--show");
              modalUpContainer.classList.add("container--show");
          }); 

      }

      modalUpCloseButton.addEventListener("click", () => {
          modalUp.classList.remove("modal-subir--show");
          modalUpContainer.classList.remove("container--show");
      });

      modalUpBackground.addEventListener("click", () => {
          modalUp.classList.remove("modal-subir--show");
          modalUpContainer.classList.remove("container--show");
      });
    </script>
</body>
</html>