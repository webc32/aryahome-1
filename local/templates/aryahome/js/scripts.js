BX.showWait = function () {
    $('.preloader').fadeIn().end().delay(100);
};
BX.closeWait = function () {
   $('.preloader').fadeOut().end().delay(100);
};
//lazyload
window.addEventListener&&window.addEventListener('load',function(){'use strict';var e=document.body;if(e.getElementsByClassName&&e.querySelector&&e.classList&&e.getBoundingClientRect){var t,n='replace',i='preview',s='reveal',r=document.getElementsByClassName('progressive '+n),o=window.requestAnimationFrame||function(e){e()};['pageshow','scroll','resize'].forEach(function(e){window.addEventListener(e,a,{passive:!0})}),window.MutationObserver&&new MutationObserver(a).observe(e,{subtree:!0,childList:!0,attributes:!0}),c()}function a(){t=t||setTimeout(function(){t=null,c()},300)}function c(){r.length&&o(function(){for(var e,t,n=window.innerHeight,i=0;i<r.length;)0<(t=(e=r[i].getBoundingClientRect()).top)+e.height&&n>t?u(r[i]):i++})}function u(e,t){e.classList.remove(n);var r=e.getAttribute('data-href')||e.href,a=e.querySelector('img.'+i);if(r&&a){var c=new Image,l=e.dataset;l&&(l.srcset&&(c.srcset=l.srcset),l.sizes&&(c.sizes=l.sizes)),c.onload=function(){r===e.href&&(e.style.cursor='default',e.addEventListener('click',function(e){e.preventDefault()}));var t=c.classList;c.className=a.className,t.remove(i),t.add(s),c.alt=a.alt||'',o(function(){e.insertBefore(c,a.nextSibling).addEventListener('animationend',function(){e.removeChild(a),t.remove(s)})})},(t=1+(t||0))<3&&(c.onerror=function(){setTimeout(function(){u(e,t)},3e3*t)}),c.src=r}}},!1);

function checkBasketItems(){
    $.ajax({
        url: "/api/CSaleBasket.GetList.php",
        type: "POST",
        data: {
            action: "CSaleBasket::GetList"
        },
        success: function(data) {
            $('header .basket-quantity .ellipse').html(data);
            $('.header-mobile .basket-quantity .ellipse').html(data);
        }
    });
}
function closeModal($this){
    $($this).parents('.js-overlay-campaign').first().fadeOut();
    $($this).parents('.js-overlay-close').first().fadeOut();
}
function cleanFormToBasket(){
    var formtobasket = $(".formtobasket.pre-accept .element");
    formtobasket.find('.product-title').html('');
    formtobasket.find('.color').html('');
    formtobasket.find('.size').html('');
    
}
function MegamenuRecommended(){
    $('.mega-menu .catalog .section .recommended').fadeIn();
    $('.mega-menu .catalog .section .recommended').owlCarousel({
        items:2,
        responsive:{
            0:{
                items:1
            },
            1200:{
                items:2
            }
        },
        lazyLoad:true,
        loop:false,
        nav:true,
        dots: false,
        autoplay:true,
        autoplayTimeout: 2000, 
        autoplayHoverPause: true,
        navText : ['<img src="/local/templates/aryahome/img/menu/arrow-left.svg">','<img src="/local/templates/aryahome/img/menu/arrow-right.svg">']
    });
}

//header
$(document).ready(function(){
	//Обновление корзины
	checkBasketItems();

    //Скрытие попапов при скролле
    $(window).scroll(function(){  
        if ( $(window).width() > 734 ) {
            if ($(window).scrollTop() > 400 ){
                $('.mega-menu .js-overlay-campaign').fadeOut();
                $('.mega-menu').fadeOut();
                $(this).removeClass('active');
                $('*[data-modal="mega-menu"]').removeClass('active');
            }
        }
    });
    //Открытие mega-menu
    $('*[data-modal="mega-menu"]').on('click', function() {
        if ($(".overlay.mega-menu").hasClass('active')) {
            closeModal(this);
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
            $(".overlay.mega-menu").fadeIn();
        }  
    });
    //Показ 2 уровеня меню
    $('*[data-menu]*').on('mouseover', function() {
        var id = $(this).attr('data-menu');
        $('*[data-menu-lvl-2]*').removeClass('d-block');
        $('*[data-menu-lvl-2="'+id+'"]').addClass('d-block');
    });
    //Закрытие модального окна
    $('*[data-modal="close"]').on('click', function() {
        closeModal(this);
    });
    $('*[data-modal="closeBuyProduct"]').on('click', function() {
        $('.js-overlay-campaign').fadeOut();
        $('.js-overlay-close').fadeOut();
    });


    

    $(document).mouseup(function(e) { // событие клика по веб-документу
        var div = $(".js-popup-campaign"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            &&
            div.has(e.target).length === 0) { // и не по его дочерним элементам
                $('.js-overlay-campaign').fadeOut();
                $('.js-overlay-close').fadeOut();
                $('*[data-modal="mega-menu"]').removeClass('active');
                $('.menu-mobile-activate').removeClass('active');
                $('.quickview .catalog').html('');
                cleanFormToBasket();
        }
    });

    //Отложенная загрузка
    function documentOnLoadDelay() {
        if ( $(window).width() > 734 ) {
            MegamenuRecommended();
        }
    }
    setTimeout(documentOnLoadDelay, 1000);
});
//footer
$(document).ready(function(){
    if ($(window).width() < 734) {
        //Открытие или закрытие меню в подвале
        $(document).on("click", "footer .service h4", function(){
            var parent = $(this).parent();
            var elem = parent.find('ul');

            if (elem.css('display') == 'none') {
                elem.animate({height: 'show'}, 400);
                $(this).addClass('active');
            } else {
                elem.animate({height: 'hide'}, 50);
                $(this).removeClass('active');
            }
        });
    }
    // Браузер поддерживает `loading`.
    if ('loading' in HTMLImageElement.prototype) { 
        console.log('Браузер поддерживает `loading`.');
    } else {
       // Иначе - загрузить и применить полифилл или JavaScript-библиотеку для 
       // организации ленивой загрузки материалов.
       console.log('Загрузить и применить профиль или JavaScript-библиотеку');
    }
});