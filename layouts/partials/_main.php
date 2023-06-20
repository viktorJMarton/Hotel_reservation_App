<?php
$date = '2023-06-20';
$screeningIds = $db->getScreeningsByTime($date);
include "_seat_map.php";

foreach ($screeningIds as $screeningId) {
    renderSeatMap($db,$screeningId);
    echo "<br></br>";
}
?>
