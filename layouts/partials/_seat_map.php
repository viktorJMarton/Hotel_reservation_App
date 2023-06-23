<head>
    <link rel="stylesheet" type="text/css" href="../3rd_party/jquerry_seat_chart/jquery.seat-charts.css">
    <link rel="stylesheet" type="text/css" href="../3rd_party/jquerry_seat_chart/styles.css">
</head>

<?php
function renderSeatMap($db, $screeningId, $isRes)
{
    $email=$_SESSION['email'];
    $seatMap = $db->getSeatMapOfScreening($screeningId);
    $price = $db->getPriceOfScreening($screeningId);
    $movie = $db->getMovieByScreening($screeningId);
    $start = $db->getStartOfScreening($screeningId);
    $duration = $db->getDurationOfScreening($screeningId);
    $is_already_booked = $db->checkIfAlreadyBooked($email,$screeningId);
    if($isRes){
    $seats=$db ->query("SELECT seats FROM reservations WHERE email = '".$email."' AND screening_id = '".$screeningId."'");
     $values = array_values($seats);
    }
?>

<div class="container">
      
    <div id="seat-map-<?= $screeningId ?>"></div>
    <div class="booking-details">
        <h3>Kiválasztott Helyek (<span id="counter-<?= $screeningId ?>">0</span>):</h3>
        <ul id="selected-seats-<?= $screeningId ?>"></ul>
      
        Total: <b><span id="total-<?= $screeningId ?>">0</span> HUF</b>
        
        <?php if ($isRes): ?>
            <button class="delete-button" data-screening-id="<?= $screeningId ?>">Törlés</button>
        <?php else: ?>

            <button class="checkout-button" data-screening-id="<?= $screeningId ?>">Foglalás</button>
        <?php endif; ?>
    </div>
    <div class="movie-details">
        <h3>Film :</h3>
        <p>Név: <?= $movie['name'] ?></p>
        <p>Korhatár: <?= $movie['age_rating'] ?></p>
        <p>Leírás: <?= $movie['description'] ?></p>
    </div>
    <div class="screening-details">
        <h3>Vetítés:</h3>
        <p>Kezdete: <?= $start ?></p>
        <p>Hossz:<?= $duration ?></p>
    </div>

    <div class="movie-poster">
        <img src="<?= $movie['poster_path'] ?>" alt="Movie Poster" style="height: 100%;">
    </div>
</div>
<br>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../3rd_party/jquerry_seat_chart/jquery.seat-charts.js"></script>

<script>
    function recalculateTotal(sc) {
        var total = 0;
        sc.find("selected").each(function () {
            total += this.data().price;
        });
        return total;
    }

    function reloadPage() {
        location.reload();
    }

    $(document).ready(function () {
        var scr_id = <?= $screeningId ?>;
        var seatMap = <?= json_encode($seatMap) ?>;
        var firstSeatLabel = 1;
        var price = <?= $price ?>;
        var $cart = $("#selected-seats-<?= $screeningId ?>");
        var $counter = $("#counter-<?= $screeningId ?>");
        var $total = $("#total-<?= $screeningId ?>");
        var sc = $("#seat-map-<?= $screeningId ?>").seatCharts({
            map: seatMap,
            seats: {
                a: { price: price, classes: "seat" },
                b: { price: price, classes: "seat unavailable" },
                c: { price: price, classes: "seat" },
                d: { price: price, classes: "seat" }
            },
            naming: { top: false, getLabel: function (character, row, column) { return firstSeatLabel++; } },
            
            click: function () {
                <?php if (!$isRes): ?>
                if (this.status() == "available") {
                    $("<li>" + this.data().category + " Seat # " + this.settings.label + ": <b>" + this.data().price + " HUF</b> <a href='#' class='cancel-cart-item'>[cancel]</a></li>")
                        .attr("id", "cart-item-" + this.settings.id)
                        .data("seatId", this.settings.id)
                        .appendTo($cart);

                    $counter.text(sc.find("selected").length + 1);
                    $total.text(recalculateTotal(sc) + this.data().price);
                    return "selected";
                } else if (this.status() == "selected") {
                    $counter.text(sc.find("selected").length - 1);
                    $total.text(recalculateTotal(sc) - this.data().price);
                    $("#cart-item-" + this.settings.id).remove();
                    return "available";
                } else if (this.status() == "unavailable") {
                    return "unavailable";
                } else {
                    return this.style();
                }
                <?php endif; ?>
            }
        });

        var bSeats = sc.find("b");
        bSeats.status("unavailable");

        $("#selected-seats-<?= $screeningId ?>").on("click", ".cancel-cart-item", function () {
            event.preventDefault();
            sc.get($(this).parents("li:first").data("seatId")).click();
        });

        String.prototype.replaceAt = function (index, replacement) {
            if (index >= this.length) {
                return this.valueOf();
            }
            return this.substring(0, index) + replacement + this.substring(index + 1);
        };

        $('.checkout-button[data-screening-id="<?= $screeningId ?>"]').click(function () {
            var selectedSeats = sc.find('selected'); 
            var seatIds = [];

            selectedSeats.each(function () {
                seatIds.push(this.settings.id);
                var seatIdParts = this.settings.id.split('_');
                var i = seatIdParts[0] - 1;
                var j = seatIdParts[1] - 1;
                seatMap[i] = seatMap[i].replaceAt(j, 'b');
            });

            $.ajax({
                url: '../../concerns/save_reservation.php',
                method: 'GET',
                data: {
                    seatIds: seatIds,
                    screeningId: <?= $screeningId ?>,
                    seatMap: seatMap,
                    numOfRes: selectedSeats.length 
                },
                success: function (response) {
                    console.log(response);
                    reloadPage(); 
                },
                error: function (xhr, status, error) {
                    console.log(seatIds);
                    console.log(error);
                }
            });
        });

       

        <?php if ($isRes): ?>
            var seatId = "<?=$values[0]?>";
           // console.log(seatId);
            var seatsArray = seatId.split(",");
            //console.log(seatsArray);

            for(var i =0; i<seatsArray.length;i++){
              console.log(seatsArray[i]);
            }

            for(var seatid in seatsArray){
             
            }
            $('.seatCharts-seat').unbind('mouseenter mouseleave click');
            $('.seatCharts-seat').css('cursor', 'not-allowed');


        <?php endif; ?>

        <?php  if ($is_already_booked): ?>
         
            $('#counter-<?= $screeningId ?>').html(seatsArray.length);

          $('.checkout-button').css('cursor', 'not-allowed','disabled');
          $('.checkout-button').prop('disabled', true);
          
      
          
        <?php endif; ?>

        $('.delete-button[data-screening-id="<?= $screeningId ?>"]').click(function () {
            event.preventDefault();
            var screeningId = $(this).data("screening-id");

            $.ajax({
                url: '../../concerns/delete_reservation.php',
                method: 'POST',
                data: {
                    screeningId: screeningId,
                    email: "<?php echo $_SESSION['email'] ?>"
                },
                success: function (response) {
                    console.log(response);
                     reloadPage(); 
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });

    });
</script>

<?php
}
?>
