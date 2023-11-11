<?php 
include("./functions/getDirShortName.php");
include("./functions/getDirFullName.php");

$validExt = array('png', 'jpg', 'jpeg', 'svg', 'pdf', 'mp3', 'wav' ,'mp4');
$files = array();
$subjects = array();
$selected_subject = array();

$selected_dir = "";

// Obtiene todas las materias que tiene el profesor actualmente.
if ($rol_id == PROFESSOR_ROLE) {
    $result_professor_subjects = $conn -> query("
        SELECT subjects.*, 
        subjects_names.name 
        FROM subjects_names 
        INNER JOIN subjects ON subjects.name_id = subjects_names.id
        INNER JOIN users ON subjects.professor_id = $user_id
        WHERE users.id = $user_id
    ");

    $professor_subjects = array();

    if ($result_professor_subjects -> num_rows > 0) {
        foreach ($result_professor_subjects as $subject)
            $professor_subjects[] = $subject;
    }
}

if (isset($_GET["courseId"]) && isset($_GET["divisionId"])) {
    $curso = $_GET['courseId'];
    $division = $_GET['divisionId'];
    $result = $conn -> query("
        SELECT subjects.*, 
        subjects_names.name, 
        users.name AS professor_name, 
        users.surname AS professor_surname
        FROM subjects_names 
        INNER JOIN subjects ON subjects.name_id = subjects_names.id
        INNER JOIN users ON subjects.professor_id = users.id
        WHERE course = $curso AND division = $division;
    ");

    foreach ($result as $subject)
        $subjects[] = $subject;
}

if (isset($_GET["subject_id"])) {

    foreach ($result as $file)
        $files[] = $file;

    $result_course_division = $conn -> query("
        SELECT subjects.course, subjects.division
        FROM subjects
        WHERE id = $subject_id;
    ");

    $subject_data = $result_course_division -> fetch_assoc();

    $result_subject = $conn -> query("
        SELECT subjects.*, 
        subjects_names.name, 
        users.name AS professor_name, 
        users.surname AS professor_surname
        FROM subjects_names 
        INNER JOIN subjects ON subjects.name_id = subjects_names.id
        INNER JOIN users ON subjects.professor_id = users.id
        WHERE course = " . $subject_data['course'] . " AND division = " . $subject_data['division']
    );

    foreach ($result_subject as $subject) {
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

            <a 
                href="./?courseId=<?php echo $selected_subject['course'] ?>&divisionId=<?php echo $selected_subject['division'] ?>" 
                class="library__go-back"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Atras
            </a>

            <h2 class="subject__name">
                <?php echo $selected_subject['name'] . " - ".  $selected_subject['course'] . "°"  .  $selected_subject['division'] . " " .  $selected_subject['group']?>
            </h2>
            <h3 class="subject__professor">
                <?php echo "Profesor: " . $selected_subject['professor_name'] . " " . $selected_subject['professor_surname'] ?>
            </h3> <?php
        } 

        if (isset($_GET["courseId"]) && isset($_GET["divisionId"])) { ?>

            <a href="./" class="library__go-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Atras
            </a>

            <h2 class="subject__name">
                <?php echo "Materias de " . $_GET["courseId"] . "°"  .  $_GET["divisionId"] ?>
            </h2> <?php

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

            // Analiza si hay archivos o carpetas cargados en la materia. Si no los hay muestra dicho mensaje.
            if (count(scandir($dir)) > 2) {
                include("./includes/files-table.php");
            } else { ?>
                <p>Aún no hay archivos ni carpetas cargadas.</p> <?php
            } ?>

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
                                
                                if (
                                    ($rol_id == PROFESSOR_ROLE && $professor_id == $user_id)
                                    ||
                                    $rol_id == AREA_CHIEF_ROLE
                                ) { ?>
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

                                if (
                                    ($rol_id == PROFESSOR_ROLE && $professor_id == $user_id)
                                    ||
                                    $rol_id == AREA_CHIEF_ROLE
                                ) { ?>
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
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                </svg>
                Biblioteca
            </h2> <?php

            if ($rol_id == PROFESSOR_ROLE) { ?> 
            
                <h3 class="library__subtitle">Tus materias</h3> <?php
                
                if (count($professor_subjects) > 0) { ?>
                    <ul> <?php
                        foreach ($professor_subjects as $subject) { ?>
                            <li>
                                <a href="?subject_id=<?php echo $subject['id'] ?>"> <?php
                                    if ($subject["group"]) { ?>
                                        <span><?php echo $subject["name"] . " " . $subject["course"] . "°" . $subject["division"] . " - " . "Grupo " . $subject["group"] ?></span> <?php
                                    } else { ?>
                                        <span><?php echo $subject["name"] . " " . $subject["course"] . "°" . $subject["division"] ?></span> <?php
                                    } ?>
                                </a>
                            </li> <?php
                        } ?>
                    </ul> <?php
    
                } else { ?>
                    <p>Aún no tenes materias asignadas.</p> <?php
                } ?>

                <h3 class="library__subtitle">Toda la biblioteca</h3> <?php
            } ?>

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