$(document).ready(function(){
    var load_more = false;
    $(window).scroll(function() {
        if($(".load-product").length && !load_more) {
            var targetContainer = $('.catalog-section'),          //  Контейнер, в котором хранятся элементы
                url =  $('.load-product a.btn').attr('data-url');    //  URL, из которого будем брать элементы

            if (url !== undefined) {
                load_more = true;
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'html',
                    success: function(data){

                        //  Удаляем старую навигацию
                        $('.load-product').remove();

                        var elements = $(data).find('.product-item-small-card'),  //  Ищем элементы
                            pagination = $(data).find('.load-product');//  Ищем навигацию

                        targetContainer.append(elements);   //  Добавляем посты в конец контейнера
                        targetContainer.append(pagination); //  добавляем навигацию следом
                        load_more = false;
                    }
                })
            }
        }

    });

});