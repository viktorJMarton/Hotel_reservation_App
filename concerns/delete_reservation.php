<?php require '../init/db_connect.php'; ?>

<?php

if (isset($_POST['screeningId']) && isset($_POST['email'])) {
    $screeningId = $_POST['screeningId'];
    $email = $_POST['email'];
var_dump($email);
var_dump($screeningId);
     $db->deleteReserv($screeningId, $email);

    echo "Törlés sikeres";
} else {

    var_dump($email);
    var_dump($screeningId);
    echo "Hiányzó adatok";
}
?>
