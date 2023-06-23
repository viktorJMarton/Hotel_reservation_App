<?php

$screeningIds = $db->getScreeningsByReservation($_SESSION['email']);

include "_seat_map.php";
foreach ($screeningIds as $screeningId) {
   
    renderSeatMap($db, $screeningId,true);
    echo "<br></br>";
}
?>
