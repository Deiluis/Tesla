<table>
    <tr>
        <th>Nombre</th>
        <th style="width: 14%">Tipo de archivo</th>
        <th style="width: 14%">Opciones</th>
    </tr> <?php
    
    foreach ($files as $file) { 
        
        if (pathinfo($file['path'], PATHINFO_DIRNAME) == $dir) { ?>
            <tr>
                <td><?php echo $file["name"] ?></td>
                <td><?php echo strtoupper($file["file_type"]) ?></td>
                <td>
                    <div class="button-wrapper"> <?php
                        if (in_array($file['file_type'], $validExt)) { ?>
                            <a href="#" id="<?php echo $file['id'] ?>" class="library-items">
                                <button class='content-button status-button' style="display: flex;">
                                    <svg style="margin:0" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>
                                </button>
                            </a> <?php 

                        } else { ?>
                            <a href="#" id="<?php echo $file['id'] ?>">
                                <button class='content-button status-button' style="display: flex;  background-color: #444; cursor:no-drop;">
                                    <svg style="margin:0" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/></svg>
                                </button>
                            </a> <?php 
                        } ?>

                        <div class="menu">
                            <button class="dropdown">
                                <ul>
                                    <li>
                                        <a href="<?php echo $dir ?>/<?php echo $file['name'] ?>.<?php echo $file['file_type'] ?>" download class="link--descargar" title="Descargar">Descargar</a>
                                    </li> <?php 
                                    
                                    if($rol_id == PROFESSOR_ROLE && $professor_id == $user_id) { ?>
                                        <li>
                                            <a href="./actions/delete.php?id=<?php echo $file['id'] ?>&table=files">Borrar</a>
                                        </li> <?php 
                                    } ?>
                                </ul>
                            </button>
                        </div>
                    </div>
                </td>
            </tr> <?php
        }
    } ?>
</table>