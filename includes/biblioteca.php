<?php 
include("./functions/getDirShortName.php");
include("./functions/getDirFullName.php");

$validExt = array('png', 'jpg', 'jpeg', 'svg', 'pdf', 'mp3', 'wav' ,'mp4');
$files = array();

if (isset($_GET["courseId"]) && isset($_GET["divisionId"])) {
    foreach ($result as $file)
        $files[] = $file;
}

if (isset($_GET["subject_id"])) {
    foreach ($result as $file)
        $files[] = $file;

    $subject_id = $_GET["subject_id"];
    $dir_names = scandir("./uploads/subject-$subject_id");

    $selectable_dirs = array();
    $full_name_dirs = array();

    foreach ($dir_names as $dir_name) {
        if (getDirShortName($dir_name, $subject_id) != NULL)
            $selectable_dirs[] = getDirShortName($dir_name, $subject_id);

        if (getDirFullName($dir_name, $subject_id) != NULL)
            $full_name_dirs[] = getDirFullName($dir_name, $subject_id);
    }
}

?>

<div class="content-wrapper" id="biblioteca">

    <div class="content-section"> <?php 
        if (isset($_GET["courseId"]) && isset($_GET["divisionId"])) { 
            print("<ul>");

            foreach ($files as $file) { ?>
                <li>
                    <a href="?subject_id=<?php echo $file['id'] ?>">
                        <span><?php echo $file["name"] ?></span>
                    </a>
                </li> <?php
            }
            print("</ul>");

        } else if (isset($_GET["subject_id"])) { ?> 
            
            
            <div class="content-section"> <?php
                $dir = $full_name_dirs[0];
                include("./includes/files-table.php"); 
                ?>
                <ul> <?php 
                    // Incluye las tablas de cada directorio de la materia.
                    $index = 0;

                    foreach ($full_name_dirs as $dir) { 
                        if ($selectable_dirs[$index] !== ".") { ?>
                        <li> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                                <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                            </svg> <?php
                            echo $selectable_dirs[$index]; ?>
                        </li>
                        <ul class="dropdown-list">
                            <?php include("./includes/files-table.php"); ?> 
                        </ul> <?php
                        } 
                        $index++;
                    } ?>
                </ul> 
                <button type="button" class="content-button status-button button--larger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                        <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2Zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672Z"/>
                        <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5Z"/>
                    </svg>
                    Crear carpeta
                </button>

                <form action="./create-folder?subject_id=<?php echo $_GET["subject_id"] ?>" method="post">
                    <input type="text" name="foldername" id="foldername" placeholder="Nombre de la carpeta">
                    <button class="login-button">Crear carpeta</button>
                </form>

                <button type="button" class="content-button status-button button--larger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                        <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
                        <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                    </svg>
                    Subir archivo
                </button>

                <form action="./actions/upload" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" id="file" required>
                    <input type="text" name="subject_id" value="<?php echo $_GET['subject_id'] ?>" hidden>
                    <select name="dir_name"> <?php
                        for ($i = 0; $i < count($selectable_dirs); $i++) {
                            if ($selectable_dirs[$i] == ".") {
                                echo "<option value=''>Sin carpeta</option>";
                            } else {
                                echo "<option>" . $selectable_dirs[$i] . "</option>";
                            }
                        } ?>
                    </select>
                    <input class="content-button status-button button--larger" type="submit" value="Subir Archivo">
                </form>

            </div>
            
            <?php

        } else { 
            print("<ul>"); 
            for ($c = 1; $c <= 7; $c++) { ?>
                <li><span><?php echo $c ?>º año</span></li>
                <ul class="dropdown-list"> <?php
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
                        </li> <?php
                    } ?>
                </ul> <?php 
            }
        print("</ul>"); 
        } ?>
    </div>
</div>