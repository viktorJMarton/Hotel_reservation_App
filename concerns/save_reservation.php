<?php require '../init/db_connect.php'; ?>

<?php
if (isset($_POST['seatIds']) && isset($_POST['screeningId']) && isset($_POST['seatMap'])) {
    $seatIds = $_POST['seatIds'];
    $screeningId = $_POST['screeningId'];
    $seatMap = $_POST['seatMap'];

    // Debugging information
    echo 'Seat IDs: ' . implode(', ', $seatIds) . '<br>';
   echo 'Screening ID: ' . $screeningId . '<br>';
   echo 'Seat Map: ' . json_encode($seatMap) . '<br>';

    $response = $db->saveReservation($seatIds, $screeningId, $seatMap);

    if ($response) {
        // Successful database save
        echo 'success';
    } else {
        // Error during database save
        echo 'error';
    }
} else {
    // Invalid or missing POST values
    echo 'invalid data';
}
?>
