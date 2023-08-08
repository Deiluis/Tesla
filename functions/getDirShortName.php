<?php 

function getDirShortName($dirName, $subject_id) {            
    
    if ($dirName == ".")
        return ".";

    if ($dirName != ".." && is_dir("./uploads/subject-$subject_id/" . $dirName)) {
        return $dirName;
    } 
}

?>