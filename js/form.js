$(document).ready(function(){
    $('input, textarea').each(function() {

        $(this).on('focus', function() {
            $(this).parent('fieldset').addClass('active');
        });

        $(this).on('blur', function() {
            if ($(this).val().length == 0) {
              $(this).parent('fieldset').removeClass('active');
            }
        });

        if ($(this).val() != '') $(this).parent('fieldset').addClass('active');

    });

    $("form").validate();
});