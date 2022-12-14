/*
You can use this file with your scripts.
It will not be overwritten when you upgrade solution.
*/

function closeModal($this){
    $($this).parents('.js-overlay-campaign').first().fadeOut();
    $($this).parents('.js-overlay-close').first().fadeOut();
}
function add2waitingList(product_id, product_name){
    console.log('test');
    $.ajax({
        type: "POST",
        url: "/ajax/waiting-list.php",
        data: {product_id: product_id, product_name: product_name} ,
        success: function(html){
            // $(th).addClass('in_wishlist');
            // $('#wishcount').html(html);
        }
    });
};

function changeOfferListing(e){
    var product_color = $(e).data('product_color');
    var product_size = $(e).data('product_size');
	InitOwlSlider();
    console.log(window.location.href.indexOf('/catalog/'));
    if(window.location.href.indexOf('/catalog/') !== -1){
        var parts = new URL(window.location.href).pathname.split('/');
        var sectionCode = parts.pop() || parts.pop();  // handle potential trailing slash
    }else{
         var sectionCode = "";
    }

    if(!!product_size){
        product_color = $(e).closest('.item-offers').find('.active').data('product_color');
    }

    var _this = $(e);
	
	
	
	
    $.ajax({
        type: "POST",
        url: "/ajax/showproduct.php",//window.location.href
        data: {product_color: product_color, product_size: product_size, offer_ajax: "Y",sectionCode: sectionCode} ,
        success: function(html){
			
                //не помогает
                var product = _this.closest('.catalog-block-view__item').html(html);
                $(product).find('.colors > span').each(function(){
                    var span = $(this);
                    setTimeout(function(){
                        var src = span.data('img');
                        span.find('img').attr('src',src);
                        $(".owl_carousel_colors").owlCarousel({
                            responsive:{
                                0:{
                                    items:2
                                },
                                600:{
                                    items:3
                                },
                                1000:{
                                    items:5
                                },
                            },
                            loop: false,
                            nav: true,
                            dots: false,
                        }); 
                    },200);
                })
            }
        });
}

function changeOfferFastView(e){

    var product_page = $(e).data('url');
    var product_color = $(e).data('product_color');
    var product_size = $(e).data('product_size');

    if(!!product_size){
        product_color = $(e).closest('.item-offers').find('.active').data('product_color');
    }
	
	console.log(product_page, 'test1234124')
	
    var _this = $(e);
    $.ajax({
        type: "POST",
        url: product_page+"?FAST_VIEW=Y",
        data: {fast_view_custom: "Y",product_color: product_color, product_size: product_size} ,
        success: function(html){
            var product = $('#fast_view_item').html(html);
            $(product).find('.colors > span').each(function(){
                var span = $(this);
                setTimeout(function(){
                    var src = span.data('img');
                    span.find('img').attr('src',src);
                },200);
            });
            $(".fastview-product__info.item_info").mCustomScrollbar({
                mouseWheel: {
                  scrollAmount: 150,
                  preventDefault: true,
              },
          });

                // ломается слайдер
                // $(product).find('.product-detail-gallery__item').each(function(){
                //     var img = $(this).find('img');
                //     setTimeout(function(){
                //         var picture = img.data('src');
                //         img.attr('src',picture);
                //     },200);
                // })
            }
        });
}
