$(document).ready(function(){

    //Добавляем поиск
    if ( $(window).width() < 734 ) {
        var targetContainer = $('.catalog.search'), //  Контейнер, куда разместить
        elements = $('header .search')  //  Ищем поиск
        targetContainer.append(elements);   //  Добавляем поиск
    }

    if ($(window).width() < 734) {
        $('.section .description.list').readmore({
            speed: 100,
            maxHeight: 300,
            moreLink: '<a href="#" class="text-center text-gold">Читать полностью</a>',
            lessLink: '<a href="#" class="text-center text-gold">Свернуть</a>'
        });

        $('*[data-mobile="filter"]').on('click', function(e) {
            e.preventDefault();
            $(".filter-mobile").addClass("loaded");
            $(".mobile-overlay").fadeIn();
            $(".filter").removeClass("d-none");
        });
        
        $(document).on("click", ".mobile-overlay", function(e) {
            filterMobileClose()
        });

        $(document).on("click", ".filter-mobile .close", function(e) {
            filterMobileClose()
        });

        function filterMobileClose(){
            $(".filter-mobile").removeClass("loaded");
            $(".filter").addClass("d-none");
            $(".mobile-overlay").fadeOut(function() {
                $(".filter-mobile .loaded").removeClass("loaded");
                $(".filter-mobile .activity").removeClass("activity");
            });
        }
    }
});