<?php
    if(isset($_POST['laboratory']) || isset($_POST['computer']) || isset($_POST['description']) ){
        include('../connection.php');
        $laboratory = $_POST['laboratory'];
        $computer = $_POST['computer'];
        $description = $_POST['description'];

        $result = $conn -> query("
            INSERT INTO `notifications` (`id`, `laboratory_id`, `computer`, `description`, `status_id`) 
            VALUES (NULL, '$laboratory', '$computer', '$description', 3)
        ");

        if ($result) {
            echo '
                <script>
                    alert("Observación enviada exitosamente.");
                    window.location = "../dashboard";
                </script>
            ';
        } else
            echo $conn -> error;
    }
?>