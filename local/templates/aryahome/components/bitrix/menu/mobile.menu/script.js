//mobile menu
$(document).on("click", ".menu-mobile .parent", function(e) {
    e.preventDefault();
    $(".menu-mobile .activity").removeClass("activity");
    $(this).siblings("ul").addClass("loaded").addClass("activity");
    $('.menu-mobile .name').html('<div class="d-flex align-items-center"><img src="/bitrix/templates/aryahome/img/header/arrow-left.svg" class="mr-2"><span>'+$(this).find('span').html()+'</span></div>');
    $('.menu-mobile .name').addClass('back');
	$('.menu-mobile .block').animate({scrollTop: top}, 1);
});
$(document).on("click", ".menu-mobile .back", function(e) {
    e.preventDefault();
    var active = $(".menu-mobile .activity");
    active.removeClass("activity");
    active.removeClass("loaded");
    active.parent().parent().addClass("activity");
    active.parent().parent().addClass("loaded");
    $('.menu-mobile .name').html("Каталог");
    $('.menu-mobile .name').removeClass('back');
	$('.menu-mobile .block').animate({scrollTop: top}, 1);
});
$(document).on("click", ".menu-mobile-activate", function(e) {
    e.preventDefault();
    if ($(".menu-mobile").hasClass("loaded")) {
        closeMobileMenu();
        $('body').css('overflow','auto');
    }else{
        $(".menu-mobile-activate").addClass("active");
        $(".menu-mobile").find('ul').first().addClass("activity");
        $(".menu-mobile").addClass("loaded");
        $('body').css('overflow','hidden');
        $(".mobile-overlay").fadeIn();
    }
});
$(document).on("click", ".mobile-overlay", function(e) {
    $('.menu-mobile-activate').removeClass('active');
    closeMobileMenu();
});
function closeMobileMenu(){
    $(".menu-mobile-activate").removeClass("active");
    $(".menu-mobile").removeClass("loaded");
    $(".mobile-overlay").fadeOut(function() {
        $(".menu-mobile .loaded").removeClass("loaded");
        $(".menu-mobile .activity").removeClass("activity");
    });
}