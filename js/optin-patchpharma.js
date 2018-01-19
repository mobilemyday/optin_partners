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
	$("select").on("change", function(){
		if($(this).val()=="other"){
			console.log("other");
			$(this).closest("fieldset").next("fieldset").removeClass("hidden");
			$(this).closest("fieldset").next("fieldset").find("input").prop("disabled",false);
		}else{
			console.log("nother");
			$(this).closest("fieldset").next("fieldset").addClass("hidden");
			$(this).closest("fieldset").next("fieldset").find("input").prop("disabled",true);
		}
	});

    $("form").validate();
});