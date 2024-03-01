$(document).ready(function(){
    $('#card_type, #payment_type, #transaction_nominal').change(function(){
        var cardType = $('#card_type').val();
        var paymentType = $('#payment_type').val();
        console.log($('#transaction_nominal').val());
        var transactionAmount = parseInt($('#transaction_nominal').val().replace(/\./g,''));
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
                    console.log(data);
                    $('#cashback').html(data);
                }
            });
        }else if(transactionAmount == "0" || cardType == "" || paymentType == ""){
            $('#cashback').html('<option value="">Please Select</option>');
        }
    });
});


$(document).ready(function() {
    $('#cashback').change(function() {
        var selectedCashback = $(this).find('option:selected').val();
        $('#cashback_value').val(selectedCashback);
    });
});
