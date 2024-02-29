$(document).ready(function() {
    var errors = $("#error_messages").data("errors");
    if (errors) {
        Swal.fire({ 
            icon: 'error',
            title: 'Oops...',
            text: errors
        });
    }
});
