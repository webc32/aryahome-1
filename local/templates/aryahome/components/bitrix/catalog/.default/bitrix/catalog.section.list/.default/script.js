BX.ready(function(){
    SectionListOwlActive();
});
BX.addCustomEvent('onAjaxSuccess', function(){
    SectionListOwlActive();
});
BX.addCustomEvent('onComponentAjaxHistorySetState', function(){
    SectionListOwlActive();
});
function SectionListOwlActive(){
    var SectionListOwl = $('.section-list'),
        SectionListOwlOptions = {
            items:2,
            responsive:{
                0:{
                    items:3,
                    stagePadding:0
                },
                600:{
                    items:4,
                    stagePadding:0
                },
                1000:{
                    items:6,
                    stagePadding:30
                },
                1400:{
                    items:7,
                    stagePadding:50
                }
            },
            center:false,
            lazyLoad:true,
            loop:false,
            nav:true,
            dots: false,
            stagePadding:50,
            navText : ['<img src="/local/templates/aryahome/img/menu/arrow-left.svg">','<img src="/local/templates/aryahome/img/menu/arrow-right.svg">']
        };
    var SectionListOwlActive = SectionListOwl.owlCarousel(SectionListOwlOptions);
}