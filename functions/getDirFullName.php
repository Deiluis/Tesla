<?php

function getDirFullName($dirName, $subject_id) {  
    
    if ($dirName == ".")
        return "./uploads/subject-$subject_id";

    if ($dirName != ".." && is_dir("./uploads/subject-$subject_id/" . $dirName)) {
        return "./uploads/subject-$subject_id/" . $dirName;
    } 
}

?>