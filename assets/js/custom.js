$(document).ready(function(){
    $('#card_type, #payment_type, #transaction_nominal').change(function(){
		console.log('aaaa');
        var cardType = $('#card_type').val();
        var paymentType = $('#payment_type').val();
        var transactionAmount = $('#transaction_nominal').val();
        if(cardType != '' && paymentType != '' && transactionAmount != '') {
            $.ajax({
                url: getCashbackOptionsUrl, // pake variabel global
                type: "POST",
                data: {
                    card_type: cardType,
                    payment_type: paymentType,
                    transaction_nominal: transactionAmount
                },
                success: function(data) {
                    $('#cashback').html(data);
                }
            });
        }
    });
});


$(document).ready(function() {
    $('#cashback').change(function() {
        var selectedCashback = $(this).find('option:selected').val();
                $('#cashback_value').val(selectedCashback);
    });
});
