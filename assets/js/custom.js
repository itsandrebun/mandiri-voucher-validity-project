$(document).ready(function(){
    $('#card_type, #payment_type, #transaction_nominal').change(function(){
        var cardType = $('#card_type').val();
        var paymentType = $('#payment_type').val();
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

    $('.upper-case-input').on('keyup', function(){
        $(this).val($(this).val().toUpperCase());
    });

    $('input[name="customer_phone"]').on('keyup', function(){
        customer_phone_number = $(this).val();
    
        customer_phone_number = validate_numeric(customer_phone_number);
    
        $(this).val(customer_phone_number);
    });

    $('.seen_value_button').click(function(){
        var private_input_type = $(this).parent().siblings('.private-input-only').css('-webkit-text-security');

        if(private_input_type == "square"){
            $(this).parent().siblings('.private-input-only').css('-webkit-text-security','none')
        }else{
            $(this).parent().siblings('.private-input-only').css('-webkit-text-security','square')
        }
    })

    $('input.private-input-only').on('keyup', function(){
        digit_value = $(this).val();
    
        digit_value = validate_numeric(digit_value, "non_phone_number");
    
        $(this).val(digit_value);
    });

    function validate_numeric(input_value, input_name = "phone_number"){
        input_value = input_value.replace(/\D/g,'');

        if(input_name == "phone_number"){
            if(input_value.charAt(0) == "0"){
                input_value = input_value.substring(1);
            }else if(input_value.substring(0,2) == "62"){
                input_value = input_value.substring(2);
            }
        }       

        return input_value;
    }
});
