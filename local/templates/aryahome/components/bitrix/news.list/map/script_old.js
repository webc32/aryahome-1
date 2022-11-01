//map
$(document).ready(function() {
    $('.catalog .region .type .title-5').on('click', function() {
        $(this).parents('.region').first().find('.type').removeClass('active');
        $(this).parents('.type').addClass('active');
        regionActive(this);
    });
    $('.catalog .shops .view').on('click', function() {
        $(this).parents('.shops').first().find('.view').removeClass('active');
        $(this).addClass('active');
        console.log(1);
        viewMapActive(this);
    });
});
function regionActive(elem){
    var active = $(elem).parents('.region').find('.type.active').attr('data-tab');
    $('.catalog .region .select').find('select').removeClass('active');
    $('.catalog .region .select').find('select[data-tab="'+active+'"]').addClass('active');
}
function viewMapActive(elem){
    var active = $(elem).parents('.shops').find('.view.active').attr('data-tab');
    $('.catalog .shops').find('.list').removeClass('active');
    $('.catalog .shops').find('.list[data-tab="'+active+'"]').addClass('active');
}
function ajaxLoadShops(url,town){
    var targetContainer = $('.content .shops .list[data-tab="1"]');          //  Контейнер, в котором хранятся элементы
    //var mapContainer = $('.content .shops .list[data-tab="2"]');
    if (url !== undefined) {
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'html',
            success: function(data){
                $('.catalog .shops h2').find('span').html(town);
                var elements = $(data).find('.shops .list[data-tab="1"] .shop'),    //  Ищем элементы
                    //map = $(data).find('.shops .list[data-tab="2"] #map'),
                    pagination = $(data).find('.load-product');//  Ищем навигацию
                    targetContainer.html(elements);   //  Добавляем посты
                    targetContainer.append(pagination); //  добавляем навигацию следом
                    //mapContainer.html(map);
            }
        })
    }
}