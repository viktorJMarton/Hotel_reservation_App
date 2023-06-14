<head>
    <link rel="stylesheet" type="text/css" href="../3rd_party/jquerry_seat_chart/jquery.seat-charts.css">
    <link rel="stylesheet" type="text/css" href="../3rd_party/jquerry_seat_chart/styles.css">
</head>
        <div class="container">
            <div id="seat-map">
            </div>
            <div class="booking-details">
                <h3> Kiválasztott Helyek (<span id="counter">0</span>):</h3>
                <ul id="selected-seats"></ul>

                Total: <b>$<span id="total">0</span></b>

                <button class="checkout-button">Checkout &raquo;</button>


            </div>


        </div>

    </div>
    <script>
       
      
       
        $(document).ready(function () {
            var seatMap = <?php echo json_encode($db->getSeatMapOfRoom(1)); ?>;
            var firstSeatLabel = 1;
            var $cart = $('#selected-seats'),
		        $counter = $('#counter'),
		        $total = $('#total'),
                sc = $('#seat-map').seatCharts({
                map:seatMap,
                seats: {
                    a: {
                        price: 99.99,
                        classes: 'seat' //your custom CSS class
                    }

                },
                naming : {
						top : false,
						getLabel : function (character, row, column) {
							return firstSeatLabel++;
						},
					},
					click: function () {
						if (this.status() == 'available') {
							//let's create a new <li> which we'll add to the cart items
							$('<li>'+this.data().category+' Seat # '+this.settings.label+': <b>$'+this.data().price+'</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
								.attr('id', 'cart-item-'+this.settings.id)
								.data('seatId', this.settings.id)
								.appendTo($cart);
							
							/*
							 * Lets update the counter and total
							 *
							 * .find function will not find the current seat, because it will change its stauts only after return
							 * 'selected'. This is why we have to add 1 to the length and the current seat price to the total.
							 */
							$counter.text(sc.find('selected').length+1);
							$total.text(recalculateTotal(sc)+this.data().price);
							
							return 'selected';
						} else if (this.status() == 'selected') {
							//update the counter
							$counter.text(sc.find('selected').length-1);
							//and total
							$total.text(recalculateTotal(sc)-this.data().price);
						
							//remove the item from our cart
							$('#cart-item-'+this.settings.id).remove();
						
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

				//this will handle "[cancel]" link clicks
				$('#selected-seats').on('click', '.cancel-cart-item', function () {
					//let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
					sc.get($(this).parents('li:first').data('seatId')).click();
				});

		
		});

		function recalculateTotal(sc) {
			var total = 0;
		
			//basically find every selected seat and sum its price
			sc.find('selected').each(function () {
				total += this.data().price;
			});
			
			return total;
		}
    </script>
