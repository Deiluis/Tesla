<?php 
include("./functions/getDirShortName.php");
include("./functions/getDirFullName.php");

$validExt = array('png', 'jpg', 'jpeg', 'svg', 'pdf', 'mp3', 'wav' ,'mp4');
$files = array();

$selected_dir = "";

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

<div class="content-wrapper" id="biblioteca" style="padding: 0 40px;">

    <div class="content-section" style="margin-top: 0;"> <?php 
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

        } else if (isset($_GET["subject_id"])) { 
            $dir = $full_name_dirs[0];
            include("./includes/files-table.php"); ?>

            <ul> <?php 
                // Incluye las tablas de cada directorio de la materia.
                $index = 0;

                foreach ($full_name_dirs as $dir) { 
                    if ($selectable_dirs[$index] !== ".") { 
                        if (count(scandir($dir)) > 2) { ?>
                            <li> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                                    <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                                </svg> <?php
                                echo $selectable_dirs[$index]; 
                                
                                if ($rol_id > 0) { ?>
                                    <div class="menu">
                                        <button class="dropdown">
                                            <ul>
                                                <li>
                                                    <a 
                                                        href="#"
                                                        class="rename-folder"
                                                        data-old-name="<?php echo $selectable_dirs[$index] ?>"
                                                        data-subject="<?php echo $_GET["subject_id"] ?>"
                                                    >
                                                        Cambiar nombre
                                                    </a>
                                                </li> 
                                                <li>
                                                    <a 
                                                        href="#" 
                                                        class="delete-folder" 
                                                        data-folder="<?php echo $selectable_dirs[$index] ?>"
                                                        data-subject="<?php echo $_GET["subject_id"] ?>"
                                                    >
                                                        Borrar
                                                    </a>
                                                </li>
                                            </ul>
                                        </button>
                                    </div> <?php
                                } ?>     

                            </li>
                            <ul class="dropdown-list">
                                <?php include("./includes/files-table.php"); ?> 
                            </ul> <?php
                             
                        } else { ?>
                            <li> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-x" viewBox="0 0 16 16">
                                    <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zm6.339-1.577A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                                    <path d="M11.854 10.146a.5.5 0 0 0-.707.708L12.293 12l-1.146 1.146a.5.5 0 0 0 .707.708L13 12.707l1.146 1.147a.5.5 0 0 0 .708-.708L13.707 12l1.147-1.146a.5.5 0 0 0-.707-.708L13 11.293l-1.146-1.147z"/>
                                </svg> <?php
                                echo $selectable_dirs[$index];

                                if ($rol_id > 0) { ?>
                                    <div class="menu">
                                        <button class="dropdown">
                                            <ul>
                                                <li>
                                                    <a 
                                                        href="#"
                                                        class="rename-folder"
                                                        data-old-name="<?php echo $selectable_dirs[$index] ?>"
                                                        data-subject="<?php echo $_GET["subject_id"] ?>"
                                                    >
                                                        Cambiar nombre
                                                    </a>
                                                </li> 
                                                <li>
                                                    <a 
                                                        href="#" 
                                                        class="delete-folder" 
                                                        data-folder="<?php echo $selectable_dirs[$index] ?>"
                                                        data-subject="<?php echo $_GET["subject_id"] ?>"
                                                    >
                                                        Borrar
                                                    </a>
                                                </li>
                                            </ul>
                                        </button>
                                    </div> <?php
                                } ?> 

                            </li> <?php
                        }
                    } 
                    $index++;
                } ?>
            </ul> <?php

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