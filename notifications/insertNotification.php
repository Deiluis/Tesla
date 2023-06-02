<?php
include('../connection.php');

$laboratory = $_POST['laboratory'];
$computer = $_POST['computer'];
$description = $_POST['description'];

$result = $conn -> query("
    INSERT INTO `notifications` (`id`, `laboratory_id`, `computer`, `description`, `status`) 
    VALUES (NULL, '$laboratory', '$computer', '$description', 'unresolved')
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
?>