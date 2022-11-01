var myMap;
ymaps.ready(init);


function init(){ 
myMap = new ymaps.Map("map", {
    center: [55.76, 37.64],
    zoom: 10,
}); 
//Добавляем элементы управления	
 myMap.controls
	// Кнопка изменения масштаба
	 .add('zoomControl', { right: 5, top: 250 })
// Расположим её справа

myPlacemark196253 = new ymaps.Placemark([55.845855, 37.662093], {
    hintContent: 'ТРЦ Золотой Вавилон',
    balloonContent: '<div class="ballon">ТРЦ Золотой Вавилон Г. Москва<br><p>Проспект Мира, д.211, корпус 2</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark196253);

// myPlacemark196251 = new ymaps.Placemark([55.743649, 37.508122], {
//     hintContent: 'ТЦ Филион',
// 	balloonContent: '<div class="ballon">ТЦ "Филион" Г. Москва<br><p>Багратионовский проезд, д.5</p></div> '   }, {
//          // Изображение иконки метки
//         iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
//         // Размеры изображения иконки
//         iconImageSize: [30, 30],  
//         // смещение картинки
//         iconImageOffset: [-15, -15],
// });

// myMap.geoObjects.add(myPlacemark196251);

// myPlacemark196250 = new ymaps.Placemark([55.825664, 37.516530], {
//     hintContent: 'ТЦ Петровский',
// 	balloonContent: '<div class="ballon">ТЦ "Петровский" Г. Москва<br><p>Новопетровская, д.6</p></div> '   }, {
//          // Изображение иконки метки
//         iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
//         // Размеры изображения иконки
//         iconImageSize: [30, 30],  
//         // смещение картинки
//         iconImageOffset: [-15, -15],
// });

// myMap.geoObjects.add(myPlacemark196250);

myPlacemark196249 = new ymaps.Placemark([55.809420, 37.464970], {
    hintContent: 'ТРЦ Щука',
	balloonContent: '<div class="ballon">ТРЦ "Щука" Г. Москва<br><p>ул. Щукинская, д.42</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark196249);

myPlacemark196248 = new ymaps.Placemark([55.779875, 37.601375], {
    hintContent: 'ТЦ Дружба',
	balloonContent: '<div class="ballon">ТЦ "Дружба" Г. Москва<br><p>ул. Новослободская, д.4</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark196248);

myPlacemark196247 = new ymaps.Placemark([55.856622, 37.653484], {
    hintContent: 'ТРЦ Свиблово',
	balloonContent: '<div class="ballon">ТРЦ "Свиблово" Г. Москва<br><p>ул. Снежная, д.27</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark196247);

// myPlacemark196246 = new ymaps.Placemark([55.586784, 37.724562], {
//     hintContent: 'ТРЦ Вегас Каширский',
// 	balloonContent: '<div class="ballon">ТРЦ "Вегас Каширский" Г. Москва<br><p>24-й км МКАД<br></p></div> '   }, {
//          // Изображение иконки метки
//         iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
//         // Размеры изображения иконки
//         iconImageSize: [30, 30],  
//         // смещение картинки
//         iconImageOffset: [-15, -15],
// });

// myMap.geoObjects.add(myPlacemark196246);

myPlacemark196241 = new ymaps.Placemark([55.812605, 37.832886], {
    hintContent: 'ТЦ Щелково',
	balloonContent: '<div class="ballon">ТЦ "Щелково" Г. Москва<br><p>ул. Щелковское шоссе, д.100</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark196241);

myPlacemark196240 = new ymaps.Placemark([ 55.710766, 37.675587], {
    hintContent: 'ТЦ Мозаика',
	balloonContent: '<div class="ballon">ТЦ "Мозайка" Г. Москва<br><p>ул. 7-ая Кожуховская, д.9</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark196240);

// myPlacemark196239 = new ymaps.Placemark([ 55.819062, 37.346502], {
//     hintContent: 'ТРЦ Июнь Красногорск',
// 	balloonContent: '<div class="ballon">ТРЦ "Июнь" Московская область Г. Красногорск<br><p>ул. Знаменская, д.5</p></div> '   }, {
//          // Изображение иконки метки
//         iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
//         // Размеры изображения иконки
//         iconImageSize: [30, 30],  
//         // смещение картинки
//         iconImageOffset: [-15, -15],
// });

// myMap.geoObjects.add(myPlacemark196239);

myPlacemark196019 = new ymaps.Placemark([55.612168, 37.606558], {
    hintContent: 'ТРЦ Columbus',
	balloonContent: '<div class="ballon">ТРЦ "Columbus"<br>ул. Кировоградская, д.13А, -1 этаж Г. Москва<br></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark196019);

myPlacemark194706 = new ymaps.Placemark([55.722507, 37.726960], {
    hintContent: 'Текстильщики',
	balloonContent: '<div class="ballon">Текстильщики. Г. Москва <br>ул. 1-й грайвороновский проезд, д.20, стр.20, Пятый этаж</div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark194706);

myPlacemark192606 = new ymaps.Placemark([55.891751, 37.748812], {
    hintContent: 'ТРЦ XL-3',
	balloonContent: '<div class="ballon">ТРЦ "XL-3" Г. Москва<br><p>ул. Ярославское шоссе, 1 км от МКАД<br></p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark192606);

myPlacemark187345 = new ymaps.Placemark([55.888760, 37.433526], {
    hintContent: 'ТЦ Лига Химки',
	balloonContent: '<div class="ballon">ТЦ "Лига Химки" Московская область&nbsp;Г. Химки<br><p> ул. Ленинградское шоссе, владение 5</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark187345);

myPlacemark187341 = new ymaps.Placemark([55.916776, 37.759302], {
    hintContent: 'ТРК Красный Кит',
	balloonContent: '<div class="ballon">ТРК "Красный Кит" Московская область Г. Мытищи<br><p>ул. Шараповский проезд, владение 2</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark187341);

myPlacemark187339 = new ymaps.Placemark([55.777084, 37.523653], {
    hintContent: 'ТРЦ Хорошо',
	balloonContent: '<div class="ballon">ТРЦ "Хорошо" Г. Москва<br><p>ул. Хорошевское шоссе, д.27</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark187339);

myPlacemark187338 = new ymaps.Placemark([55.727911, 37.475971], {
    hintContent: 'ТРЦ Океания',
	balloonContent: '<div class="ballon">ТРЦ&nbsp;"Океания" Г. Москва<br><p>ул. Славянский бульвар, д. 57</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark187338);

myPlacemark187337 = new ymaps.Placemark([55.663156, 37.910585], {
    hintContent: 'ТРЦ Орбита',
	balloonContent: '<div class="ballon">ТРЦ "Орбита" Московская область Г. Люберцы<br><p>ул. Октябрьский проспект, д.366</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark187337);

myPlacemark187336 = new ymaps.Placemark([55.919972, 37.708527], {
    hintContent: 'ТРЦ Июнь',
	balloonContent: '<div class="ballon">ТРЦ "Июнь" Московская область Г. Мытищи<br><p>ул. Мира, д.51</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark187336);

myPlacemark185294 = new ymaps.Placemark([55.791081, 37.530366], {
    hintContent: 'ТВК Авиапарк',
	balloonContent: '<div class="ballon">ТВК "Авиапарк" Г. Москва<br><p>ул. Ходынский бульвар, д.4</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185294);

myPlacemark185293 = new ymaps.Placemark([55.744778, 37.566156], {
    hintContent: 'ТРЦ Европейский',
	balloonContent: '<div class="ballon">ТРЦ "Европейский" Г. Москва<br><p>ул. Площадь Киевского вокзала, д.2</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185293);

myPlacemark185289 = new ymaps.Placemark([57.010955, 41.006811], {
    hintContent: 'ОТК ТекстильПрофи-Иваново',
	balloonContent: '<div class="ballon">ОТК "ТекстильПрофи-Иваново" Г. Иваново<br><p>ул.Сосновая, д.1 корпус А</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185289);

myPlacemark185095 = new ymaps.Placemark([55.8402537, 37.4890935], {
    hintContent: 'ТЦ Водный',
	balloonContent: '<div class="ballon">ТРЦ "Водный" Г. Москва<br><p>ул. Головинское шоссе, д.5</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185095);

myPlacemark185094 = new ymaps.Placemark([55.863736, 37.5436533,17], {
    hintContent: 'ТРЦ XL-1',
	balloonContent: '<div class="ballon">ТРЦ "XL-1" Г. Москва<br><p>ул. Дмитровское шоссе, д.89</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185094);

myPlacemark185017 = new ymaps.Placemark([55.795319, 37.616871], {
    hintContent: 'ТРЦ Райкин Плаза',
	balloonContent: '<div class="ballon">ТРЦ "Райкин Плаза" Г. Москва<br><p>ул. Шереметьевская, д.6, корпус 1</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185017);

myPlacemark185016 = new ymaps.Placemark([55.607509, 37.532608], {
    hintContent: 'ТЦ Калита',
	balloonContent: '<div class="ballon">ТЦ "Калита" Г. Москва<br><p>ул. Новоясеневский пр-т, д.7</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185016);

myPlacemark185015 = new ymaps.Placemark([56.008596, 37.439982], {
    hintContent: 'ТЦ Поворот',
	balloonContent: '<div class="ballon">ТЦ "Поворот" Московская область Г. Лобня<br><p>ул. Краснополянский пр-д, д.2</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185015);

myPlacemark185014 = new ymaps.Placemark([55.877994, 37.331776], {
    hintContent: 'ТП Отрада',
	balloonContent: '<div class="ballon">ТП "Отрада" Г. Москва<br><p>ул. 7-й км Пятницкого шоссе, владение 2</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185014);

myPlacemark185013 = new ymaps.Placemark([55.565193, 37.556354], {
    hintContent: 'ТЦ Вива',
	balloonContent: '<div class="ballon">ТЦ "Вива" Г. Москва<br><p>ул. Поляны, д.8</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185013);

// myPlacemark185012 = new ymaps.Placemark([55.853732, 37.596549], {
//     hintContent: 'ТЦ Парк Хаус Сигнальный',
// 	balloonContent: '<div class="ballon">ТЦ "Парк Хаус" Сигнальный Г. Москва<br><p>ул. Сигнальный проезд, д.17</p></div> '   }, {
//          // Изображение иконки метки
//         iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
//         // Размеры изображения иконки
//         iconImageSize: [30, 30],  
//         // смещение картинки
//         iconImageOffset: [-15, -15],
// });

// myMap.geoObjects.add(myPlacemark185012);

myPlacemark185011 = new ymaps.Placemark([55.68942, 37.60213], {
    hintContent: 'ТРЦ РИО Севастопольский',
	balloonContent: '<div class="ballon">ТРЦ "РИО Севастопольский" Г. Москва<br><p>ул. Большая Черемушкинская, д.1</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185011);

myPlacemark185010 = new ymaps.Placemark([55.69587, 37.664896], {
    hintContent: 'ТЦ Мегаполис',
	balloonContent: '<div class="ballon">ТЦ "Мегаполис" Г. Москва<br><p>ул. Проспект Андропова, д.8</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185010);

myPlacemark185009 = new ymaps.Placemark([55.569846, 37.579044], {
    hintContent: 'ТЦ Круг',
	balloonContent: '<div class="ballon">ТЦ "Круг" Г. Москва<br><p>ул. Старокачаловская, д.5А</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185009);

// myPlacemark185008 = new ymaps.Placemark([55.625191, 37.761006], {
//     hintContent: 'ТЦ Парк Хаус Братеево',
// 	balloonContent: '<div class="ballon">ТЦ "Парк Хаус" Братеево Г. Москва<br><p>ул. Бесединское шоссе, д.15</p></div> '   }, {
//          // Изображение иконки метки
//         iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
//         // Размеры изображения иконки
//         iconImageSize: [30, 30],  
//         // смещение картинки
//         iconImageOffset: [-15, -15],
// });

// myMap.geoObjects.add(myPlacemark185008);

myPlacemark185007 = new ymaps.Placemark([55.752211, 37.887523], {
    hintContent: 'ТРЦ Реутов Парк',
	balloonContent: '<div class="ballon">ТРЦ "Реутов Парк"Московская область Г. Реутов<br><p>ул. Носовихинское шоссе, д.45</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185007);

myPlacemark185006 = new ymaps.Placemark([55.611948, 37.976773], {
    hintContent: 'ТЦ Текстиль Профи',
	balloonContent: '<div class="ballon">ТЦ "Текстиль Профи" Московская область, Люберецкий р-н, п. Октябрьский<br> ул. Ленина, д.47</div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185006);

myPlacemark185004 = new ymaps.Placemark([55.875137, 37.66521], {
    hintContent: 'ТРЦ Клен',
	balloonContent: '<div class="ballon">ТРЦ "Клен" Г. Москва<br><p>ул. Староватутинский проезд, д.14</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185004);

myPlacemark185003 = new ymaps.Placemark([55.91282, 37.58566], {
    hintContent: 'ТРЦ Весна',
	balloonContent: '<div class="ballon">ТРЦ "Весна" Г. Москва<br><p>ул. Алтуфьевское шоссе, 1-й километр, владение 3, строение 1</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185003);

myPlacemark185002 = new ymaps.Placemark([55.65354, 37.62083], {
    hintContent: 'ТДЦ Варшавский',
	balloonContent: '<div class="ballon">ТДЦ "Варшавский" Г. Москва<br><p>ул. Варшавское шоссе, д.87Б</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185002);

myPlacemark185001 = new ymaps.Placemark([55.87788, 37.73081], {
    hintContent: 'ТЦ Ханой',
	balloonContent: '<div class="ballon">ТЦ "Ханой" Г. Москва<br><p>ул. Ярославское шоссе, д.146, корпус 1</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185001);

myPlacemark185000 = new ymaps.Placemark([55.88819, 37.58886], {
    hintContent: 'ТЦ Маркос-Молл',
	balloonContent: '<div class="ballon">ТЦ "Маркос-Молл" Г. Москва<br><p>ул. Алтуфьевское шоссе, д.70/1</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185000);

myPlacemark184999 = new ymaps.Placemark([55.59439, 37.59924], {
    hintContent: 'ТЦ Сомбреро',
	balloonContent: '<div class="ballon">ТЦ "Сомбреро" Г. Москва<br><p>ул. Варшавское шоссе, д.152А</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark184999);

myPlacemark185018 = new ymaps.Placemark([55.794310, 37.926476], {
    hintContent: 'ТРЦ Светофор',
    balloonContent: '<div class="ballon">ТРЦ "Светофор" Г. Москва<br><p>Балашиха, ул. Шоссе Энтузиастов, д.1Б</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185018);
 
myPlacemark185019 = new ymaps.Placemark([55.998774, 37.258104], {
    hintContent: 'ТРЦ Zеленопарк',
    balloonContent: '<div class="ballon">ТРЦ "Zеленопарк" <br><p>2-ый микрорайон, рабочий поселок Ржавки . Телефон +7 (916) 620-63-93</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185019);

myPlacemark185020 = new ymaps.Placemark([55.982473, 37.175465], {
    hintContent: 'ТРЦ Иридиум',
    balloonContent: '<div class="ballon">ТРЦ "Иридиум" г. Зеленоград <br><p>ул. Крюковская площадь, д.1</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185020);

myPlacemark185021 = new ymaps.Placemark([55.819469, 37.320357], {
    hintContent: 'ТРЦ Красный Кит',
    balloonContent: '<div class="ballon">ТРЦ "Красный Кит" Московская область г. Красногорск <br><p>ул. Ленина д.2</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185021);

myPlacemark185022 = new ymaps.Placemark([55.911143, 37.396800], {
    hintContent: 'ТЦ Мега',
    balloonContent: '<div class="ballon">ТЦ "Мега" Московская область, г. Химки <br><p> 1 район Новокуркино, 8-й микрорайон</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185022);

myPlacemark185023 = new ymaps.Placemark([55.691609, 37.896678], {
    hintContent: 'ТЦ Светофор',
    balloonContent: '<div class="ballon">ТЦ "Светофор" Московская область г. Люберцы <br><p>ул. Побратимов, д.7</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185023);

myPlacemark185024 = new ymaps.Placemark([55.623569, 37.422243], {
    hintContent: 'ТЦ Саларис',
    balloonContent: '<div class="ballon">ТЦ "Саларис" г. Москва <br><p>Киевское шоссе, 23-й километр, 1</p></div> '   }, {
         // Изображение иконки метки
        iconImageHref: 'https://aryahome.ru/local/templates/aryahome/components/bitrix/news.list/map/images/icon.png',
        // Размеры изображения иконки
        iconImageSize: [30, 30],  
        // смещение картинки
        iconImageOffset: [-15, -15],
});

myMap.geoObjects.add(myPlacemark185024);

}