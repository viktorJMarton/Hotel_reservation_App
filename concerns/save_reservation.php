<?php require '../init/db_connect.php'; ?>


<?php
if (isset($_GET['seatIds']) && isset($_GET['screeningId']) && isset($_GET['seatMap'])&& isset($_POST['numOfRes'])) {
    $seatIds = $_GET['seatIds'];
    $screeningId = $_GET['screeningId'];
    $seatMap = $_GET['seatMap'];
    $numOfRes = $_GET['numOfRes'];


   echo 'number of reservation: ' . $numOfRes . '<br>';
    echo 'Seat IDs: ' . implode(', ', $seatIds) . '<br>';
   echo 'Screening ID: ' . $screeningId . '<br>';
   echo 'Seat Map: ' . json_encode($seatMap) . '<br>';


    $response = $db->saveReservation($seatIds, $screeningId, $seatMap,$numOfRes);

    if ($response) {
       
        echo 'success';
    } else {
       
        echo 'error';
    }
} else {
    echo 'invalid data';
}
?>
