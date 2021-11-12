$(document).ready(function () {
    $('#passwordRS').on('input',function(e){
        if ($('#passwordRS').val() == $('#confirmPasswordRS').val()) {
            $('#btnChangePasswordRS').removeClass('disabled');
        } else {
            $('#btnChangePasswordRS').addClass('disabled');
        }
    });
    $('#confirmPasswordRS').on('input',function(e){
        if ($('#passwordRS').val() == $('#confirmPasswordRS').val() && $('#btnChangePasswordRS').hasClass('disabled')) {
            $('#btnChangePasswordRS').removeClass('disabled');
        } else {
            $('#btnChangePasswordRS').addClass('disabled');
        }
    });
});