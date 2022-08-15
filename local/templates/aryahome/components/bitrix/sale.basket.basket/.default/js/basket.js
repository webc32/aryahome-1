jQuery(document).ready(function($) {
	var weight = $('#weight').text();
	var result = weight.match(/([0-9]+)/g);
	console.log('Вес: '+result[0]);
	// if (result[0] >= 24) {
	// 	weightpopup();
	// 	$('#finish').addClass('d-none');
	// 	$('#finish').removeClass('d-block');
	// }else{
	// 	$('#finish').addClass('d-block');
	// 	$('#finish').removeClass('d-none');
	// }
});

function UpdateBasketItems(){
	setTimeout(function(){
	    $.ajax({
	        url: "/api/CSaleBasket.GetList.php",
	        type: "POST",
	        data: {
	            action: "CSaleBasket::GetList"
	        },
	        success: function(data) {
	            $('header .basket-quantity .ellipse').html(data);
	            $('.header-mobile .basket-quantity .ellipse').html(data);
	            console.log('Кол. т.: '+data);
	        }
	    });
		var weight = $('#weight').text();
		var result = weight.match(/([0-9]+)/g);
		console.log('Вес: '+result[0]);
		// if (result[0] >= 24) {
		// 	weightpopup();
		// 	$('#finish').addClass('d-none');
		// 	$('#finish').removeClass('d-block');
		// }else{
		// 	$('#finish').addClass('d-block');
		// 	$('#finish').removeClass('d-none');
		// }
    }, 1000);
}

// function weightpopup(){
//     $(".overlay.weightpopup").fadeIn();
// };
