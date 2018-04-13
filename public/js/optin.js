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
    $("form#confirm-optin").validate({
		  rules: {
			code: "required",
			optin: "required"
		  },
		  messages: {
			code: "Verplicht veld",
			optin: "Verplicht veld"
		  },
		  errorPlacement: function(error, element) {
			error.appendTo(element.parent("fieldset"));
		  },
		  errorElement : "div"
	});
});