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
    $('#passwordN').on('input',function(e){
        if ($('#passwordN').val() == $('#confirmPasswordN').val()) {
            $('#btnRegister').removeClass('disabled');
        } else {
            $('#btnRegister').addClass('disabled');
        }
    });
    $('#confirmPasswordN').on('input',function(e){
        if ($('#passwordN').val() == $('#confirmPasswordN').val() && $('#btnRegister').hasClass('disabled')) {
            $('#btnRegister').removeClass('disabled');
        } else {
            $('#btnRegister').addClass('disabled');
        }
    });
});