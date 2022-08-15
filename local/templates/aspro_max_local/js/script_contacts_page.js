var myMap;
ymaps.ready(init);

function init(){ 
    myMap = new ymaps.Map("map", {
        center: [55.722507, 37.726960],
        zoom: 15,
    }); 

    //Добавляем элементы управления 
	myMap.controls
    // Кнопка изменения масштаба
	.add('zoomControl', { right: 5, top: 100 })
    // Расположим её справа
    myPlacemark = new ymaps.Placemark([55.722507, 37.726960], {
        hintContent: 'ARYAHOME',
		balloonContent: '<div class="ballon">109518, город Москва, 1-й Грайвороновский проезд, дом 20, строение 20</div> '}, {
             // Изображение иконки метки
            iconImageHref: 'https://aryahome.ru/bitrix/templates/aryahome/img/map/icon.png',
            // Размеры изображения иконки
            iconImageSize: [30, 30],  
            // смещение картинки
            iconImageOffset: [-15, -15],
    });
 
    myMap.geoObjects.add(myPlacemark);
}