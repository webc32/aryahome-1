$(document).ready(function(){
    //Сообщение об добавлении товара в корзину
    $('*[data-modal="formtobasket-accept"]').on('click', function() {
        Add2BasketByProductID(this);
    });
});
function formtobasket($this){
    cleanFormToBasket();
    //Сбор информации
    var item = $($this).parents('.item').first();
    var id = $(item).attr('data-id');
    var name = $(item).attr('data-name'); 
    var namecode = $(item).attr('data-name-code');
    var colorActive = $(item).attr('data-color');
    var preview = $(item).attr('data-preview');
    var sizecode = $(item).attr('data-size-code');
    var sizeActive = $(item).attr('data-size');
    //Обработка формы
    var form = $('.formtobasket.pre-accept');
    form.find('.product-title').html(name);
    var colorProps = document.querySelector('[data-type="item:color"]');
    colorProps.append(
        BX.create('DIV', {
            props: {className: 'name text-gray col-12 mb-2'},
            children: [
                BX.create('DIV', {
                    props: {className: 'row'},
                    children: [
                        BX.create('DIV', {html: 'Цвет:'})
                    ]
                })
            ]
        }),
        BX.create('DIV', {
            props: {className: 'value w-100 mb-2'},
            children: [
                BX.create('DIV', {
                    props: {className: 'w-100 d-flex flex-wrap'},
                    html: '<a href="#" onclick="colorActivated(this); return false" class="d-inline-block position-relative active" data-name="'+name+'" data-name-code="'+namecode+'" data-color="'+colorActive+'" data-id="'+id+'"><img width="56px" height="56px" src="'+preview+'" loading="lazy" title="'+colorActive+'"></a>'
                })
            ]
        })
    );
    //Подгрузка других
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
                var size = item.RAZMER;
                var id = item.ID;
                if (item.TSVET != null){
                    if (color != previousСolor) {
                        if (colorActive != color) {
                            objectColors += '<a href="#" onclick="colorActivated(this); return false" class="d-inline-block position-relative" data-name="'+name+'" data-name-code="'+namecode+'" data-color="'+color+'" data-id="'+id+'"><img width="56px" height="56px" src="'+PREVIEW_PICTURE+'" loading="lazy" title="'+color+'"></a>';
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
    CIBlockItemGetListSize(id,name,namecode,colorActive,sizecode,sizeActive);
    form.fadeIn();
}
function CIBlockItemGetListSize(id,name,namecode,colorActive,sizecode,sizeActive){
    //Обработка формы
    var form = $('.formtobasket.pre-accept');
    var sizeProps = document.querySelector('[data-type="item:size"]');
    if (Object.keys(sizeActive).length != 0) {
        sizeProps.append(
            BX.create('DIV', {
                props: {className: 'name text-gray col-12 mb-md-3'},
                children: [
                    BX.create('DIV', {
                        props: {className: 'row'},
                        children: [
                            BX.create('DIV', {html: 'Размер:'})
                        ]
                    })
                ]
            }),
            BX.create('DIV', {
                props: {className: 'value w-100 mb-md-3'},
                children: [
                    BX.create('DIV', {
                        props: {className: 'w-100 d-flex flex-wrap'},
                        html: '<a href="" onclick="sizeActivated(this); return false" class="active position-relative mb-1" data-id="'+id+'"><span class="d-block bg-graylight text-gold px-2 py-2">'+sizeActive+'</span></a>'
                    })
                ]
            })
        );
    }
    //Подгрузка других
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
                if (item.RAZMER != null)
                {
                    if (size != previousSize) {
                        if (sizeActive != size) {
                            objectSizes += '<a href="" onclick="sizeActivated(this); return false" class="position-relative mb-1" data-id="'+id+'"><span class="d-block bg-graylight text-gold px-2 py-2">'+size+'</span></a>';
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
function colorActivated($this){
    var name = $($this).attr('data-name');
    var namecode = $($this).attr('data-name-code');
    var color = $($this).attr('data-color');
    var props = $('[data-type="item:props"]');
    $.ajax({
        url: "/api/CIBlockElement.GetList.Size.php",
        type: "POST",
        data: {
            action: "CIBlockElement::GetList.Size",
            name: name,
            namecode: namecode,
            color: color
        },
        success: function(data) {
            data = JSON.parse(data);
            var objectSizes = '';
            var previousSize = '';
            data.products.forEach(function(item, i, arr) {
                var size = item.RAZMER;
                var id = item.ID;
                if (item.RAZMER == null)
                {objectSizes == null}else{
                    if (size != previousSize) {
                        if (i == '0 ') {
                            objectSizes += '<a href="" onclick="sizeActivated(this); return false" class="position-relative active" data-id="'+id+'"><span class="d-block bg-graylight text-gold px-2 py-2">'+size+'</span></a>';
                        }else{
                            objectSizes += '<a href="" onclick="sizeActivated(this); return false" class="position-relative" data-id="'+id+'"><span class="d-block bg-graylight text-gold px-2 py-2">'+size+'</span></a>';
                        }
                        previousSize = size;
                    }
                }
            });
            if (objectSizes == '') {props.find('.size').html('');}else{
                props.find('.size .value div').html(objectSizes);}
        }
    });
    $($this).parents().first('.color').find('.active').removeClass('active');
    $($this).addClass('active');
}
function sizeActivated($this){
    $($this).parents().first('.size').find('.active').removeClass('active');
    $($this).addClass('active');
}
function formtofavorite($this){
    var name = $($this).parents('.item').attr('data-name');
    var id = $($this).parents('.item').attr('data-id');
    var price = $($this).parents('.item').attr('data-price');
    $(".overlay.formtofavorite").fadeIn();

    if ($($this).hasClass('active')) {
        $($this).removeClass('active');
        $('.overlay.formtofavorite .product-title').html('Товар “'+name+'” убран из вашего списка избранных товаров');

    }else{
        $($this).addClass('active');
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
        
    } 
}
function Add2BasketByProductID($this,$amount){
    var form = $('.formtobasket.pre-accept');
    var name = $($this).parents('.element').first().find('.product-title').html();
    var id = $($this).parents('.element').first().find('.size .value .active').attr('data-id');
    var price = $($this).parents('.item').attr('data-price');
    if (id == undefined) {var id = $($this).parents('.element').first().find('.color .value .active').attr('data-id');}
    if (id == undefined) {var id = $($this).parents('.element').first().attr('data-id');}
    if ($amount == undefined) {$amount = 1;}
    // console.log(id);
    // console.log($amount);
    $.ajax({
        url: "/api/Add2BasketByProductID.php",
        type: "POST",
        data: {
            action: "Add2BasketByProductID",
            amount: $amount,
            id: id
        },
        success: function(data) {
            console.log(data);
            dataLayer.push({
              'event': 'addToCart',
              'ecommerce': {
                'currencyCode': 'RUB',
                'add': {
                  'products': [{
                    'name': name,
                    'id': id,
                    'price': price,
                    'quantity': $amount
                   }]
                }
              }
            });
            dataLayer.push({
              'event': 'add_to_cart',
              'value': price,
              'items' : [{
                'id': id,
                'google_business_vertical': 'retail'
              }]
            });
            ym(28747751,'reachGoal','cart');
            console.log('Товар успешно добавлен в корзину!');
            checkBasketItems();
        }
    });
    // form.find('.product-title').html('Товар “'+name+'” успешно добавлен в корзину!');
    form.fadeOut();
}
function AjaxCatalogElement($this){
    var item = $($this).parents('.item').first();
    var id = $(item).attr('data-id');
    var form = $(".overlay.quickview");
    //Подгрузка детальной страницы товара
    BX.ajax({
        url: '/api/catalog.element.php',
        data: {
            ajax:'Y',
            id: id
        },
        method: 'POST',
        dataType: 'html',
        timeout: 30,
        async: true,
        processData: true,
        scriptsRunFirst: false,
        emulateOnload: true,
        start: true,
        cache: false,
        onsuccess: function(data){
          form.find('.catalog').html(data);
        },
        onfailure: function(){

        }
    });
    form.fadeIn();
}
function UpdateParamAjaxCatalogElement($this){
    var id = $($this).attr('data-id');
    var form = $(".overlay.quickview");
    //Подгрузка детальной страницы товара
    BX.ajax({
        url: '/api/catalog.element.php',
        data: {
            ajax:'Y',
            id: id
        },
        method: 'POST',
        dataType: 'html',
        timeout: 30,
        async: true,
        processData: true,
        scriptsRunFirst: false,
        emulateOnload: true,
        start: true,
        cache: false,
        onsuccess: function(data){
          form.find('.catalog').html(data);
        },
        onfailure: function(){

        }
    });
}
function closeQuickview($this){
    closeModal($this);
    $($this).parents('.catalog').first().html('');
}
