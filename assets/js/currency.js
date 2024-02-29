format_currency();

function format_currency(){
    $('.format-currency').inputmask({ 
        alias : "currency",
        rightAlign: false,
        removeMaskOnSubmit:true,
        radixPoint: ",", 
        digitsOptional: true, 
        prefix: "" 
    });   
}