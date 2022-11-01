$(document).ready(function(){
	function owl() {
	    $.getScript( "/bitrix/templates/aryahome/lib/owl/owl.carousel.min.js" );
	}
	setTimeout(owl, 100);
	function scripts() {
	    $.getScript( "/bitrix/templates/aryahome/js/scripts.min.js" );
	}
	setTimeout(scripts, 1000);
	function maskedinput() {
	    $.getScript( "/bitrix/templates/aryahome/lib/maskedinput/jquery.maskedinput.min.js" );
	}
	setTimeout(maskedinput, 2000);
	function readmore() {
	    $.getScript( "/bitrix/templates/aryahome/lib/readmore/readmore.min.js" );
	}
	setTimeout(readmore, 2000);
});