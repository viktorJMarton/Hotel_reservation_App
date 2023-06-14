function cancelCartItem() {
    var seatId = $(this).parents('li:first').data('seatId');
    var seat = sc.get(seatId);

    // Update the counter
    $counter.text(sc.find('selected').length - 1);

    // Update the total
    $total.text(recalculateTotal(sc) - seat.data().price);

    // Remove the item from the cart
    $('#cart-item-' + seat.settings.id).remove();

    // Seat has been vacated
    seat.status('available');
}

// Attach event listener to the cancel-cart-item class
$('#selected-seats').on('click', '.cancel-cart-item', cancelCartItem);