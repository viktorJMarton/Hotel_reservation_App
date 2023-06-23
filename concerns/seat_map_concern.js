function cancelCartItem() {
    var seatId = $(this).parents('li:first').data('seatId');
    var seat = sc.get(seatId);

   
    $counter.text(sc.find('selected').length - 1);

    
    $total.text(recalculateTotal(sc) - seat.data().price);

    
    $('#cart-item-' + seat.settings.id).remove();

   
    seat.status('available');
}

$('#selected-seats').on('click', '.cancel-cart-item', cancelCartItem);