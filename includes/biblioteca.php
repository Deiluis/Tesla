<?php 
include("./functions/getDirShortName.php");
include("./functions/getDirFullName.php");

$validExt = array('png', 'jpg', 'jpeg', 'svg', 'pdf', 'mp3', 'wav' ,'mp4');
$files = array();
$subjects = array();
$selected_subject = array();

$selected_dir = "";

if (isset($_GET["courseId"]) && isset($_GET["divisionId"])) {
    foreach ($result as $subject)
        $subjects[] = $subject;

    $_SESSION['subjects'] = $subjects;
}

if (isset($_GET["subject_id"])) {

    $subject_id = $_GET["subject_id"];

    foreach ($result as $file)
        $files[] = $file;

    foreach ($_SESSION['subjects'] as $subject) {
        if ($subject['id'] == $subject_id)
            $selected_subject = $subject;
    }

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
        
        if ($selected_subject) { ?>
            <h2 class="subject__name">
                <?php echo $selected_subject['name'] . " - ".  $selected_subject['course'] . "°"  .  $selected_subject['division'] . " " .  $selected_subject['group']?>
            </h2>
            <h3 class="subject__professor">
                <?php echo "Profesor: " . $selected_subject['professor_name'] . " " . $selected_subject['professor_surname'] ?>
            </h3> <?php
        } 

        if (isset($_GET["courseId"]) && isset($_GET["divisionId"])) { ?>

            <h2 class="subject__name">
                <?php echo "Materias de " . $_GET["courseId"] . "°"  .  $_GET["divisionId"] ?>
            </h2> 
            
            <a href="./">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Atras
            </a> <?php

            if (count($subjects) > 0) { ?>
                <ul> <?php
                    foreach ($subjects as $subject) { ?>
                        <li>
                            <a href="?subject_id=<?php echo $subject['id'] ?>"> <?php
                                if ($subject["group"]) { ?>
                                    <span><?php echo $subject["name"] . " - " . "Grupo " . $subject["group"] ?></span> <?php
                                } else { ?>
                                    <span><?php echo $subject["name"] ?></span> <?php
                                } ?>
                            </a>
                        </li> <?php
                    } ?>
                </ul> <?php

            } else { ?>
                <p>Aún no hay materias cargadas.</p> <?php
            }

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
                                
                                if ($rol_id == PROFESSOR_ROLE && $professor_id == $user_id) { ?>
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
                            <li title="Esta carpeta esta vacía."> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-x" viewBox="0 0 16 16">
                                    <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zm6.339-1.577A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                                    <path d="M11.854 10.146a.5.5 0 0 0-.707.708L12.293 12l-1.146 1.146a.5.5 0 0 0 .707.708L13 12.707l1.146 1.147a.5.5 0 0 0 .708-.708L13.707 12l1.147-1.146a.5.5 0 0 0-.707-.708L13 11.293l-1.146-1.147z"/>
                                </svg> <?php
                                echo $selectable_dirs[$index];

                                if ($rol_id == PROFESSOR_ROLE && $professor_id == $user_id) { ?>
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

        } else { ?>
            <h2>Biblioteca</h2>

            <ul> <?php
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
                } ?>
            </ul> <?php
        } ?>
    </div>
</div>