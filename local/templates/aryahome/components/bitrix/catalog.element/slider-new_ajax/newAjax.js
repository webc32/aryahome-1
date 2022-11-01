$(document).ready(function(){
	//Вертикальная карусель
    // var first = 0,
    //     third = 3,
    //     last = Number($('.catalog .element .preview .product-item-detail-slider-controls-image:last-child').attr('data-slide')),
    //     sliderControl = $('.catalog .element .preview .slider-control'),
    //     sliderControlUp = $('.catalog .element .preview .slider-control.up'),
    //     sliderControlDown = $('.catalog .element .preview .slider-control.down'),
    //     contentHeight = 0;
    // sliderControl.on('click', function() {
    //     if ($(this).hasClass('down')){
    //         if (third != last) {
    //             first += 1;
    //             third += 1;
    //             console.log(first);
    //             // console.log(third);
    //             contentHeight = ((-1 * first) * (174));
    //             console.log(contentHeight);
    //             $('.catalog .element .preview .slider-controls').css({
    //               transform: 'translateY(' + contentHeight + 'px)'
    //             });
    //             sliderControlUp.addClass('active');
    //             if (third == last) {sliderControlDown.removeClass('active');}
    //         }else{
    //             sliderControlDown.removeClass('active');
    //         }
    //     }
    //     if ($(this).hasClass('up')){
    //         if (first != 0) {
    //             first += -1;
    //             third += -1;
    //             console.log(first);
    //             // console.log(third);
    //             contentHeight = (-1 * first * 174);
    //             console.log(contentHeight);
    //             $('.catalog .element .preview .slider-controls').css({
    //               transform: 'translateY(' + contentHeight + 'px)'
    //             });
    //             sliderControlDown.addClass('active');
    //             if (first == 0) {sliderControlUp.removeClass('active');}
    //         }else{
    //             sliderControlUp.removeClass('active');
    //         }
    //     }
    // });
    //Обновление параметров
    //QuickElementParamsUpdate();

    /* */
	// Инициализация превью слайдера
	const sliderThumbs1 = new Swiper('.slider__thumbs_aj .swiper-container', { // ищем слайдер превью по селектору
		// задаем параметры
		direction: 'vertical', // вертикальная прокрутка
		loop: 'true',
		slidesPerView: 3, // показывать по 3 превью
		spaceBetween: 24, // расстояние между слайдами
		//mousewheel: true, // можно прокручивать изображения колёсиком мыши
		navigation: { // задаем кнопки навигации
			nextEl: '.slider__next_aj', // кнопка Next
			prevEl: '.slider__prev_aj' // кнопка Prev
		},
		freeMode: true, // при перетаскивании превью ведет себя как при скролле
		breakpoints: { // условия для разных размеров окна браузера
			0: { // при 0px и выше
				direction: 'horizontal', // горизонтальная прокрутка
			},
			768: { // при 768px и выше
				direction: 'vertical', // вертикальная прокрутка
			}
		}
	});
	// Инициализация слайдера изображений
	const sliderImages2 = new Swiper('.slider__images_aj .swiper-container', { // ищем слайдер превью по селектору
		// задаем параметры
		direction: 'horizontal', // вертикальная прокрутка
		loop: 'true',
		slidesPerView: 1, // показывать по 1 изображению
		spaceBetween: 32, // расстояние между слайдами
		//mousewheel: true, // можно прокручивать изображения колёсиком мыши
		navigation: { // задаем кнопки навигации
			nextEl: '.slider__next_aj', // кнопка Next
			prevEl: '.slider__prev_aj' // кнопка Prev
		},
		//grabCursor: true, // менять иконку курсора
		 thumbs: { // указываем на превью слайдер
			swiper: sliderThumbs1 // указываем имя превью слайдера
		 },
		breakpoints: { // условия для разных размеров окна браузера
			0: { // при 0px и выше
				direction: 'horizontal', // горизонтальная прокрутка
			},
			768: { // при 768px и выше
				direction: 'vertical', // вертикальная прокрутка
			}
		}
	});
    $('.zoom_aj').zoom();
    $('.zoom_aj').on("mouseover", function(){
        $(".slider__images_aj ").css({"position":"relative", "z-index": "5000"});
    })
    $('.zoom_aj').on("mouseleave", function(){
        $(".slider__images_aj ").css({"position":"relative", "z-index": "0"});
    })
});



//    jQuery( "body" ).on('click', '.zoomImg', function(evt) {
//     $(this).closest('.lider__image').find('.zoom1').click();
//     evt.stopImmediatePropagation();
//    })

$.fancybox.defaults.backFocus = false;
//Поиск цветов и размеров
function QuickElementParamsUpdate(){
    var item = $('.quickview').find('.item');
    var id = $(item).attr('data-id');
    var name = $(item).attr('data-name');
    var namecode = $(item).attr('data-name-code');
    var colorActive = $(item).attr('data-color');
    var sizecode = $(item).attr('data-size-code');
    var sizeActive = $(item).attr('data-size');
    if (!activeSize) {var activeSize = '*';}
    CIBlockQuickElementGetListColor(id, name, namecode, colorActive, sizecode, sizeActive);
    CIBlockQuickElementGetListSize(id, name, namecode, colorActive, sizecode, sizeActive);
}
function CIBlockQuickElementGetListColor(id, name, namecode, colorActive, sizecode, sizeActive){
    var form = $('.quickview .catalog .element');
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
                if (item.TSVET != null){
                    if (color != previousСolor) {
                        if (colorActive != color) {
                            objectColors += '<a href="#" onclick="UpdateParamAjaxCatalogElement(this); return false" class="d-inline-block position-relative" data-id="'+id+'"><img width="56px" height="56px" src="'+PREVIEW_PICTURE+'" loading="lazy" title="'+color+'"></a>';
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
function CIBlockQuickElementGetListSize(id, name, namecode, colorActive, sizecode, sizeActive){
    var form = $('.quickview .catalog .element');
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
                if (item.RAZMER != null){
                    if (size != previousSize) {
                        if (sizeActive != size) {
                            objectSizes += '<a href="" onclick="UpdateParamAjaxCatalogElement(this); return false" class="position-relative mb-1" data-id="'+id+'"><span class="d-block bg-graylight text-gold px-2 py-2">'+size+'</span></a>';
                        }
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
    var name = $($this).parents('.element').attr('data-name');
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