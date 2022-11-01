$(document).ready(function(){

    $(document).on('click', '.load-product a.btn', function(){

        var targetContainer = $('.content .shops .list'),          //  Контейнер, в котором хранятся элементы
            url =  $('.load-product a.btn').attr('data-url');    //  URL, из которого будем брать элементы

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function(data){

                    //  Удаляем старую навигацию
                    $('.load-product').remove();

                    var elements = $(data).find('.shops .list .shop'),    //  Ищем элементы
                        pagination = $(data).find('.load-product');//  Ищем навигацию

                    targetContainer.append(elements);   //  Добавляем посты в конец контейнера
                    targetContainer.append(pagination); //  добавляем навигацию следом

                }
            })
        }

    });

});