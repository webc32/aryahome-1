BX.ready(function(){
	//Включение слайдера owl
	//Owl жля картинок товара
    var ProductImagesOwl = $('.catalog .element .product-images.mobile'),
    ProductImagesOwlOptions = {
        items:1,
        autoHeight:true,
        startPosition:1,
        lazyLoad:true,
        loop:false,
        nav:false
    };
    //Owl для ленты рекомендуемых товаров
    var RecommendedOwl = $('.catalog .element.more .recommended'),
    RecommendedOwlOptions = {
        items:2,
        lazyLoad:true,
        loop:false,
        nav:false,
        dots: true,
        autoplay:true,
        autoplayTimeout: 2000, 
        autoplayHoverPause: true
    };
    if ($(window).width() < 734) {
        var ProductImagesOwlActive = ProductImagesOwl.owlCarousel(ProductImagesOwlOptions);
        var RecommendedOwlActive = RecommendedOwl.owlCarousel(RecommendedOwlOptions);
    } else {
        ProductImagesOwl.addClass('off');
        RecommendedOwl.addClass('off');
    }
    $(window).resize(function() {
        if ($(window).width() < 734) {
            if ($('.owl-carousel').hasClass('off')) {
                var ProductImagesOwlActive = ProductImagesOwl.owlCarousel(ProductImagesOwlOptions);
                ProductImagesOwl.removeClass('off');

                var RecommendedOwlActive = RecommendedOwl.owlCarousel(RecommendedOwlOptions);
                RecommendedOwl.removeClass('off');
            }
        } else {
            if (!$('.owl-carousel').hasClass('off')) {
                ProductImagesOwl.addClass('off').trigger('destroy.owl.carousel');
                ProductImagesOwl.find('.owl-stage-outer').children(':eq(0)').unwrap();
                RecommendedOwl.addClass('off').trigger('destroy.owl.carousel');
                RecommendedOwl.find('.owl-stage-outer').children(':eq(0)').unwrap();
            }
        }
    });
	//Вертикальная карусель
    var first = 0,
        third = 3,
        last = Number($('input[name=max-sliders]').val()),
        sliderControl = $('.catalog .element .preview .slider-control'),
        sliderControlUp = $('.catalog .element .preview .slider-control.up'),
        sliderControlDown = $('.catalog .element .preview .slider-control.down'),
        contentHeight = 0;
        console.log(sliderControlDown);
    sliderControl.on('click', function() {
        if ($(this).hasClass('down')){
            if (third != last) {
                first += 1;
                third += 1;
                console.log(first);
                // console.log(third);
                contentHeight = ((-1 * first) * (174));
                console.log(contentHeight);
                $('.catalog .element .preview .slider-controls').css({
                  transform: 'translateY(' + contentHeight + 'px)'
                });
                sliderControlUp.addClass('active');
                if (third == last) {sliderControlDown.removeClass('active');}
            }else{
                sliderControlDown.removeClass('active');
            }
        }
        if ($(this).hasClass('up')){
            if (first != 0) {
                first += -1;
                third += -1;
                console.log(first);
                // console.log(third);
                contentHeight = (-1 * first * 174);
                console.log(contentHeight);
                $('.catalog .element .preview .slider-controls').css({
                  transform: 'translateY(' + contentHeight + 'px)'
                });
                sliderControlDown.addClass('active');
                if (first == 0) {sliderControlUp.removeClass('active');}
            }else{
                sliderControlUp.removeClass('active');
            }
        }
    });
    //Обновление цветов и размеров
    ProductParamsUpdate();
    $('#lightgallery').lightGallery({
    	selector: '.owl-item a'
    }); 
	//Скрытие большого текста описания
	$('.catalog .element:not(.sale):not(.blog) .description').readmore({
        speed: 100,
        maxHeight: 135,
        moreLink: '<a href="#" class="text-gold">Развернуть описание</a>',
        lessLink: '<a href="#" class="text-gold">Свернуть</a>'
    });
});
function slidercontrolsvideo(){
    $('#slider-video').show();
    $('#slider-img').hide();
    $('.product-item-detail-slider-left').hide();
    $('.product-item-detail-slider-right').hide();
    $('video').trigger('play');
}
function slidercontrolsimg(){
    $('#slider-video').hide();
    $('#slider-img').show();
    $('.product-item-detail-slider-left').show();
    $('.product-item-detail-slider-right').show();
    $('video').trigger('pause');
}
//Поиск цветов и размеров
function ProductParamsUpdate(){
    var item = $('.catalog .element');
    var id = $(item).attr('data-id');
    var name = $(item).attr('data-name');
    var namecode = $(item).attr('data-name-code');
    var colorActive = $(item).attr('data-color');
    var sizecode = $(item).attr('data-size-code');
    var sizeActive = $(item).attr('data-size');
    if (!activeSize) {var activeSize = '*';}
    CIBlockElementGetListColor(id, name, namecode, colorActive, sizecode, sizeActive);
    CIBlockElementGetListSize(id, name, namecode, colorActive, sizecode, sizeActive);
}   
function CIBlockElementGetListColor(id, name, namecode, colorActive, sizecode, sizeActive){
    var form = $('.content .catalog .element');
    $.ajax({
        url: "/api/CIBlockElement.GetList.Color.php",
        type: "POST",
        data: {
            action: "CIBlockElement::GetList.Color",
            name: name,
            namecode: namecode,
            sizecode: sizecode,
            size: sizeActive
        },
        success: function(data) {
            data = JSON.parse(data);
            var objectColors = '';
            var previousСolor = '';
            data.products.forEach(function(item, i, arr) {
                var color = item.TSVET;
                var PREVIEW_PICTURE = item.PREVIEW_PICTURE;
                var id = item.ID;
                var url = item.DETAIL_PAGE_URL;
                if (item.TSVET != null){
                    if (color != previousСolor) {
                        if (colorActive != color) {
                            objectColors += '<a href="'+url+'" class="d-inline-block position-relative" data-name="'+name+'" data-color="'+color+'"><img width="56px" height="56px" src="'+PREVIEW_PICTURE+'" loading="lazy" title="'+color+'"></a>';
                        }
                        previousСolor = color;
                    }
                }
            });
            if (objectColors != ''){
                form.find('.color .value div').append(objectColors);
            }
        }
    });
}
function CIBlockElementGetListSize(id, name, namecode, colorActive, sizecode, sizeActive){
    var form = $('.content .catalog .element');
    $.ajax({
        url: "/api/CIBlockElement.GetList.Size.php",
        type: "POST",
        data: {
            action: "CIBlockElement::GetList.Size",
            name: name,
            namecode: namecode,
            color: colorActive
        },
        success: function(data) {
            data = JSON.parse(data);
            var objectSizes = '';
            var previousSize = '';
            data.products.forEach(function(item, i, arr) {
                var size = item.RAZMER;
                var id = item.ID;
                var url = item.DETAIL_PAGE_URL;
                if (item.RAZMER != null){
                    if (size != previousSize){
                        if (sizeActive != size){
                            objectSizes += '<a href="'+url+'" class="position-relative mb-1" data-id="'+id+'"><span class="d-block bg-graylight text-gold px-2 py-2">'+size+'</span></a>';}
                        previousSize = size;
                    }
                }
            });
            if (objectSizes != '') {
                form.find('.size .value div').append(objectSizes);
            }
        }
    });
}
//Избранные товары
function formtofavoriteElement($this){
    var name = $($this).parents('.element').first().attr('data-name');
    var id = $($this).parents('.element').attr('data-id');
    var price = $($this).parents('.element').attr('data-price');
    $(".overlay.formtofavorite").fadeIn();

    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $('.overlay.formtofavorite .product-title').html('Товар “'+name+'” убран из вашего списка избранных товаров');
    }else{
        $.ajax({
            url: "/api/CSaleBasket.Add.php",
            type: "POST",
            data: {
                action: "CSaleBasket::Add:Delay",
                price: price,
                id: id
            },
            success: function(data) {
                console.log('Товар успешно добавлен в ваш список избранных товаров!');
                $('.overlay.formtofavorite .product-title').html('Товар “'+name+'” добавлен в ваш список избранных товаров');
            }
        });
        $(this).addClass('active');
    }
}

function GoBack(){
    //здесь можно добавить обработку какой-нибудь логики, при желании
    window.history.back();
};