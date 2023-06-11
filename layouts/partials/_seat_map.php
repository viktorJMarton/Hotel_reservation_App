<head>
    <link rel="stylesheet" type="text/css" href="../3rd_party/jquerry_seat_chart/jquery.seat-charts.css">
    <link rel="stylesheet" type="text/css" href="../3rd_party/jquerry_seat_chart/styles.css">
</head>
<?php 
$seatMapJson = $db->query("SELECT seat_map FROM roomlayout;")['seat_map'];
$seatMapArray = array_values(json_decode($seatMapJson, true));
?> 
        <div class="container">
            <div id="seat-map">
            </div>
            <div class="booking-details">
                <div id="legend"></div>

                <h3> Kiválasztott Helyek (<span id="counter">0</span>):</h3>
                <ul id="selected-seats"></ul>

                Total: <b>$<span id="total">0</span></b>

                <button class="checkout-button">Checkout &raquo;</button>


            </div>


        </div>

    </div>
    <script>
       
      
       
        $(document).ready(function () {
            var seatMap = <?php echo json_encode($seatMapArray); ?>;
            var sc = $('#seat-map').seatCharts({
                map:seatMap,
                seats: {
                    a: {
                        price: 99.99,
                        classes: 'seat' //your custom CSS class
                    }

                },
                click: function () {
                    if (this.status() == 'available') {
                        //do some stuff, i.e. add to the cart
                        return 'selected';
                    } else if (this.status() == 'selected') {
                        //seat has been vacated
                        return 'available';
                    } else if (this.status() == 'unavailable') {
                        //seat has been already booked
                        return 'unavailable';
                    } else {
                        return this.style();
                    }
                }
            });

            //Make all available 'c' seats unavailable
            sc.find('c.available').status('unavailable');

            /*
            Get seats with ids 2_6, 1_7 (more on ids later on),
            put them in a jQuery set and change some css
            */
            sc.get(['2_6', '1_7']).node().css({
                color: '#ffcfcf'
            });

            console.log('Seat 1_2 costs ' + sc.get('1_2').data().price + ' and is currently ' + sc.status('1_2'));

        });
    </script>
