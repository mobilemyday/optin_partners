$(document).ready(function(){
	$(".btn-top-cont").hide();
	$(document).on('scroll', function() {
		var y = $(this).scrollTop();
	    var navWrap = $('.title-container').offset().top;
	    if (y > navWrap + 190) {
	        $(".btn-top-cont").fadeIn();
	    } else {
	        $(".btn-top-cont").hide();
	    }
	})
	$(".btn-top").on("click", function(){
		$('html,body').animate({ scrollTop: 0 }, 'slow');
        return false; 
	});

});