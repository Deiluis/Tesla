<?php 
$validExt = array('png', 'jpg', 'jpeg', 'svg', 'pdf', 'mp3', 'wav' ,'mp4');
?>

<div class="content-wrapper" id="biblioteca">
    <div class="content-section">
        <?php if(isset($_GET["courseId"]) && isset($_GET["divisionId"])){ print("<ul>");
                if ($result -> num_rows > 0) {
                    while ($row = $result -> fetch_assoc()) { ?>
                        <li><a href="?file_id=<?php echo $row['id'] ?>"><span><?php echo $row["name"] ?></span></a></li>
                <?php
                    }
                }
                ?>
        <?php  print("</ul>");} else if (isset($_GET["file_id"])) { ?>
            <table>
            <tr>
                <th>Nombre</th>
                <th style="width: 14%">Tipo de archivo</th>
                <th style="width: 14%">Opciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["name"] ?></td>
                    <td><?php echo strtoupper($row["file_type"]) ?></td>
                    <td>
                        <div class="button-wrapper">
                        <?php
                            if (in_array($row['file_type'], $validExt)) {
                        ?>
                            <a href="#" id="<?php echo $row['id'] ?>" class="library-items">
                                <button class='content-button status-button' style="display: flex;">
                                    <svg style="margin:0" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="#" id="<?php echo $row['id'] ?>">
                                <button class='content-button status-button' style="display: flex;  background-color: #444; cursor:no-drop;">
                                    <svg style="margin:0" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/></svg>
                                </button>
                            </a> 
                        <?php } ?>
                            <div class="menu">
                                <button class="dropdown">
                                    <ul>
                                        <li><a href="./uploads/<?php echo $row['name'] ?>.<?php echo $row['file_type'] ?>" download class="link--descargar" title="Descargar">Descargar</a></li>
                                        <?php if($rol_id > 0){ ?>
                                            <li><a href="./actions/delete.php?id=<?php echo $row['id'] ?>&table=files&id_materia=<?php echo $_GET['file_id'] ?>">Borrar</a></li>
                                        <?php } ?>
                                    </ul>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php }
            }
            ?>
            <?php if($rol_id > 0){ ?>
                <tr>
                    <form action="./actions/upload" method="POST" enctype="multipart/form-data">
                        <td><input type="file" name="file" id="file" required></td>
                        <td><input type="text" name="subject_id" value="<?php echo $_GET['file_id'] ?>" hidden></td>
                        <td><input class="content-button status-button button--larger" type="submit" value="Subir Archivo"></td>
                    </form>
                </tr>
            <?php } ?>
            </table>
            <?php }else{ print("<ul>"); for ($c = 1; $c <= 7; $c++) { ?>
            <li><span><?php echo $c ?>º año</span></li>
            <ul class="dropdown-list">
                <?php
                for ($d = 1; $d <= 6; $d++) { 
                    if ($c == 7 && $d > 4)
                        break;
                    ?>
                    <li>
                        <a href="./?courseId=<?php echo $c ?>&divisionId=<?php echo $d ?>">
                            <div class="card">
                                <span><?php echo $c ?>º<?php echo $d ?></span>
                            </div>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        <?php }
        print("</ul>"); } ?>
    </div>
</div>