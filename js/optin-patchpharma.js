$(document).ready(function(){
    $('input, textarea').each(function() {

        $(this).on('focus', function() {
            $(this).parent('.inputstyle').addClass('active');
        });

        $(this).on('blur', function() {
            if ($(this).val().length == 0) {
              $(this).parent('.inputstyle').removeClass('active');
            }
        });

        if ($(this).val() != '') $(this).parent('.inputstyle').addClass('active');
    });

	$("select.software-select").on("change", function(){
		var $select = $(this);
		toogleOtherSoftware($select);
	});

	toogleOtherSoftware($('#software-select'));
	toogleOtherSoftware($('#old-software-select'));


	$('#software-has-change-checkbox').on('change', function(event){
		toogleOldSoftware();
	});

	toogleOldSoftware();

    $("form").validate();
});

var toogleOtherSoftware = function($select)
{
	if($select.val()=="other"){
		$select.closest("fieldset").next("fieldset").removeClass("hidden");
		$select.closest("fieldset").next("fieldset").find("input").prop("disabled",false).prop("required",true);
	}else{
		$select.closest("fieldset").next("fieldset").addClass("hidden");
		$select.closest("fieldset").next("fieldset").find("input").prop("disabled",true).prop("required",false);
	}
};

var toogleOldSoftware = function()
{
	var isChecked = $('#software-has-change-checkbox').is(':checked');

	if(isChecked)
	{
		$('#software-has-change-checkbox').closest("fieldset").next("fieldset").removeClass("hidden");
		$('#software-has-change-checkbox').closest("fieldset").next("fieldset").find("select").prop("disabled",false).prop("required",true);
	}
	else {
		$('#software-has-change-checkbox').closest("fieldset").next("fieldset").addClass("hidden");
		$('#software-has-change-checkbox').closest("fieldset").next("fieldset").find("select").prop("disabled",true).prop("required",false);
	}
};