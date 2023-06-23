<?php
$date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');

$selectedMovie = isset($_POST['movie']) ? $_POST['movie'] : NULL;

$screeningIds = $db->getScreenings($date, $selectedMovie);

if (!empty($screeningIds)) { 
    include "_seat_map.php";

    foreach ($screeningIds as $screeningId) {
        renderSeatMap($db, $screeningId,false);
        echo "<br></br>";
    }
} elseif(!empty($selectedMovie)) {
    echo "<div>Sajnos a kiválasztott filmet nem vetítjük a megadott napon.</div>"; 
}else{
    echo "<div>ezen a napon nincsenek vetítések.</div>";
}
?>
