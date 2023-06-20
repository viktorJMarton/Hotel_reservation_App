<head>
    <link rel="stylesheet" type="text/css" href="../3rd_party/jquerry_seat_chart/jquery.seat-charts.css">
    <link rel="stylesheet" type="text/css" href="../3rd_party/jquerry_seat_chart/styles.css">
</head>

<?php
function renderSeatMap($db, $screeningId)
{
    $seatMap = $db->getSeatMapOfScreening($screeningId);
    $price = $db->getPriceOfScreening($screeningId);
    //$movieName = $db->getMovieNameByScreening($screeningId);
?>

<div class="container">
    <div id="seat-map-<?= $screeningId ?>"></div>
    <div class="booking-details">
        <h3> Kiválasztott Helyek (<span id="counter-<?= $screeningId ?>">0</span>):</h3>
        <ul id="selected-seats-<?= $screeningId ?>"></ul>
        Total: <b><span id="total-<?= $screeningId ?>">0</span> HUF</b>
        <button class="checkout-button" data-screening-id="<?= $screeningId ?>">Foglalás &raquo;</button>
    </div>
</div>

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
            var selectedSeats = sc.find('selected'); // Kiválasztott székek lekérése
            var seatIds = [];

            // Kiválasztott székek azonosítóinak gyűjtése
            selectedSeats.each(function () {
                seatIds.push(this.settings.id);
                var seatIdParts = this.settings.id.split('_');
                var i = seatIdParts[0] - 1;
                var j = seatIdParts[1] - 1;
                seatMap[i] = seatMap[i].replaceAt(j, 'b');
            });

            // AJAX kérés az adatok mentésére az adatbázisba
            $.ajax({
                url: '../../concerns/save_reservation.php',
                method: 'POST',
                data: {
                    seatIds: seatIds, // Kiválasztott székek azonosítói
                    screeningId: <?= $screeningId ?>, // A vetítés azonosítója
                    seatMap: seatMap // Seat map adatok
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.log(seatIds);
                    console.log(error);
                }
            });
        });
    });
</script>

<?php
}
?>
