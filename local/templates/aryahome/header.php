<?
use Bitrix\Main\Page\Asset;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

$logoSrc = SITE_TEMPLATE_PATH . "/img/header/logo.svg";

$paginatorPageNumber = !empty($_REQUEST['PAGEN_1']) ? (int) $_REQUEST['PAGEN_1'] : 0;
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=7,IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="initial-scale=1.0, width=device-width">
    <title><? $APPLICATION->ShowTitle() ?><?= $paginatorPageNumber > 1 ? " - страница {$paginatorPageNumber}" : ''; ?></title>
    <?
    //Тут мета-теги
    $APPLICATION->ShowMeta("keywords");
    $APPLICATION->ShowMeta("description");
    ?>
    <meta name="author" content="IvanCosovan Ivancosovan@gmail.com">
    <!-- Мой тег ЯВ-->
    <meta name="yandex-verification" content="fa194eb53f146497" />
    <!-- Владимир Богданов тег ЯВ-->
    <meta name="yandex-verification" content="76a448417229051a" />
    <!-- sale@aryahome.ru тег ЯВ-->
    <meta name="yandex-verification" content="aa49eb55b59d43f0" />
    <link rel="shortcut icon" type="image/png" href="<?=SITE_TEMPLATE_PATH?>/img/favicon.png">

    <? if ($paginatorPageNumber > 1): ?>
        <link rel="canonical" href="<?= (CMain::IsHTTPS() ? 'https://' : 'http://') . SITE_SERVER_NAME . $APPLICATION->GetCurDir(); ?>"/>
    <? endif; ?>

    <?
    //Тут канонический url
    //$APPLICATION->ShowLink("canonical", null, false);
    //Тут свои стили
    ?>
    <meta name="robots" content="noindex, nofollow"/>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/font/Montserrat/style.min.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/font/Muller/style.min.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/lib/bootstrap/bootstrap-reboot.min.css?v=4.5.2">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/lib/bootstrap/bootstrap-grid.min.css?v=4.5.2">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/template.min.css?v=1.5">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/lib/owl/owl.carousel.min.css?v=1.0">
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/jquery.fancybox2.min.css">
    <script src="<?=SITE_TEMPLATE_PATH . '/lib/jquery/jquery.min.js'?>"></script>
	<script src="<?= SITE_TEMPLATE_PATH . '/js/jquery.zoom.js' ?>"></script>
	<script src="<?= SITE_TEMPLATE_PATH . '/js/swiper.min.js' ?>"></script>
	<script src="<?= SITE_TEMPLATE_PATH . '/js/jquery.fancybox2.min.js' ?>"></script>
    <?
	// Подключаем css
    $APPLICATION->ShowCSS(true);
    $APPLICATION->ShowHeadStrings();   // Отображает специальные стили, JavaScript
    $APPLICATION->ShowHeadScripts();   // Вывод скриптов
    ?>
    <?$APPLICATION->SetPageProperty('robots', "noindex, nofollow");?>
    <!-- Google Tag Manager -->
	<script>
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-52Q5Q4N');
	</script>
	<!-- End Google Tag Manager -->
</head>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-52Q5Q4N" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	
    <?//if($USER->IsAdmin())
        $APPLICATION->ShowPanel();
    ?>
    <div class="preloader bg-white position-fixed">
        <div class="preloader__image position-relative"></div>
    </div>
	<?global $USER;?>
    <header class="container-fluid bg-white <?if($USER->IsAdmin()):?>position-relative<?php else: ?>position-fixed<?endif;?>">
        <div class="d-flex wide mx-auto pt-4 pb-3 py-md-4 align-items-center justify-content-between">
		<?//if (!$USER->IsAdmin()) {?>
			<div class="logo_select_site">
		<?//}?>
            <?if ($APPLICATION->GetCurPage(false) === '/') {?>
                <a href="/" class="d-md-block d-none"><img src="<?=$logoSrc?>" width="275px" alt="ARYA HOME - оптовая и розничная продажа текстиля для дома" title="Более 25 лет компания ARYA HOME занимается оптовой и розничной продажей текстиля для дома"></a>
                <a href="/" class="d-md-none d-block pr-2 px-md-0"><img src="<?=$logoSrc?>" width="195px" alt="ARYA HOME - оптовая и розничная продажа текстиля для дома" title="Более 25 лет компания ARYA HOME занимается оптовой и розничной продажей текстиля для дома"></a>
				
		   
		   <?}else{?>
                <a href="/" class="d-md-block d-none"><img src="<?=$logoSrc?>" width="275px" alt="ARYA HOME - оптовая и розничная продажа текстиля для дома" title="Более 25 лет компания ARYA HOME занимается оптовой и розничной продажей текстиля для дома"></a>
                <a href="javascript:history.go(-1)" class="clip d-md-none d-block font-weight-bold title-3 pt-1 pt-md-0">
                    <span class="mr-2">
                        <svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip15)">
                        <path d="M19.5677 11.9844H3.47559L7.03861 8.43862C7.43617 8.04293 7.4377 7.39989 7.04201 7.00232C6.64632 6.60471 6.00323 6.60323 5.60566 6.99887L0.298816 12.2801L0.297902 12.2811C-0.0986487 12.6768 -0.0999182 13.3219 0.297801 13.7189L0.298715 13.7199L5.60556 19.0011C6.00307 19.3967 6.64617 19.3953 7.04191 18.9977C7.43759 18.6001 7.43607 17.9571 7.0385 17.5614L3.47559 14.0156H19.5677C20.1287 14.0156 20.5834 13.5609 20.5834 13C20.5834 12.4391 20.1287 11.9844 19.5677 11.9844Z" fill="#262626"/>
                        </g>
                        <defs><clipPath id="clip15"><rect width="26" height="26" fill="white"/></clipPath></defs>
                        </svg>
                    </span>
                    <?$APPLICATION->ShowTitle();?>
                </a>
            <?}?>

			<?
					/*if ($USER->IsAdmin()) {*/
						$APPLICATION->IncludeComponent(
	"bitrix:main.site.selector", 
	"custom_site_selection", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"SITE_LIST" => array(
			0 => "s1",
			1 => "MG",
		),
		"COMPONENT_TEMPLATE" => "custom_site_selection",
		"SHOW_LINK_SITE" => "N"
	),
	false
);
					/*}*/
					?>
			<?//if ($USER->IsAdmin()) {?>
				</div>
			<?//}?>
            <div class="text-center mt-md-2">
        		<a href="" onclick="return false" class="mega-burger mx-md-5 d-md-block d-none" data-modal="mega-menu">
	                <svg fill="#D0A550" width="24" height="21" viewBox="0 0 24 21" xmlns="http://www.w3.org/2000/svg">
	                    <rect width="24" height="3" rx="1.5"/>
	                    <rect y="9" width="16" height="3" rx="1.5"/>
	                    <rect y="18" width="24" height="3" rx="1.5"/>
	                </svg>
	                <span class="d-none text-gold d-md-block mt-2">Каталог</span>
	            </a>		
        	</div>
            <div class="col order-2 order-md-0 mt-3 mt-md-0 d-none d-md-block">
                <?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	".default", 
	array(
		"CATEGORY_0" => array(
			0 => "iblock_aspro_max_catalog",
		),
		"CATEGORY_0_TITLE" => "",
		"CHECK_DATES" => "Y",
		"CONTAINER_ID" => "title-search",
		"CONVERT_CURRENCY" => "N",
		"INPUT_ID" => "title-search-input",
		"NUM_CATEGORIES" => "1",
		"ORDER" => "rank",
		"PAGE" => "/search/",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PRICE_CODE" => array(
			0 => "СПЕЦ ЦЕНЫ для ИНТЕРНЕТ МАГАЗИНА WMS",
			1 => "Онлайн Розница со скидкой для ИНТЕРНЕТ МАГАЗИНА WMS",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"SHOW_PREVIEW" => "Y",
		"TEMPLATE_THEME" => "blue",
		"TOP_COUNT" => "5",
		"USE_LANGUAGE_GUESS" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "3",
		),
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
            </div>
            <div class="ml-md-5 d-flex justify-content-between align-items-md-center">
            	<div class="text-center mt-md-2">
            		<a href="<?if($GLOBALS["USER"]->IsAuthorized()){?>/personal/<?}else{?>/auth/<?}?>" class="<?php if ( ($APPLICATION->GetCurPage(false) == "/personal/") || ($APPLICATION->GetCurPage(false) == "/auth/")): ?>active<?php endif ?> pl-2 px-md-0">
	                    <svg fill="#D0A550" width="22" height="24" viewBox="0 0 22 24" xmlns="http://www.w3.org/2000/svg">
	                        <path d="M15.2426 1.75738C17.5857 4.10052 17.5857 7.89951 15.2426 10.2426C12.8995 12.5858 9.10048 12.5858 6.75735 10.2426C4.41422 7.89951 4.41422 4.10052 6.75735 1.75738C9.10048 -0.585795 12.8995 -0.585795 15.2426 1.75738Z"/>
	                        <path d="M20.6419 15.9184C14.9117 12.0272 7.0883 12.0272 1.3581 15.9184C0.507924 16.4952 0 17.4699 0 18.5264V24H22V18.5264C22 17.4699 21.492 16.4952 20.6419 15.9184Z"/>
	                    </svg>
	                    <span class="d-none d-md-block text-gold mt-2"><?if($GLOBALS["USER"]->IsAuthorized()){?>Кабинет<?}else{?>Войти<?}?></span>
	                </a>
            	</div>
            	<div class="text-center mt-md-2">
            		<a href="<?if($GLOBALS["USER"]->IsAuthorized()){?>/personal/wishlist/<?}else{?>/auth/<?}?>" class="<?php if ($APPLICATION->GetCurPage(false) == "/personal/wishlist/"): ?>active<?php endif ?> mx-md-5 d-md-block d-none">
	                    <svg fill="#D0A550" width="29" height="29" viewBox="0 0 29 29" xmlns="http://www.w3.org/2000/svg">
	                        <path d="M24.9374 7.25085C23.5915 5.79939 21.7447 5 19.7369 5C18.2361 5 16.8616 5.47179 15.6516 6.40215C15.041 6.87176 14.4878 7.44631 14 8.11691C13.5124 7.44651 12.959 6.87176 12.3482 6.40215C11.1384 5.47179 9.76393 5 8.26311 5C6.25526 5 4.40829 5.79939 3.06239 7.25085C1.73256 8.68534 1 10.6451 1 12.7693C1 14.9556 1.81944 16.957 3.57874 19.0678C5.15256 20.9559 7.41451 22.8727 10.0339 25.0922C10.9283 25.8501 11.9422 26.7093 12.9949 27.6245C13.273 27.8667 13.6299 28 14 28C14.3699 28 14.727 27.8667 15.0047 27.6249C16.0574 26.7095 17.0719 25.8499 17.9667 25.0916C20.5857 22.8725 22.8476 20.9559 24.4215 19.0676C26.1808 16.957 27 14.9556 27 12.7691C27 10.6451 26.2674 8.68534 24.9374 7.25085Z"/>
	                    </svg>
	                    <span class="wishlist d-none d-md-block text-gold mt-2">Избранное</span>
	                </a>
            	</div>
            	<div class="text-center mt-md-2">
            		<a href="/personal/cart/" class="<?php if ($APPLICATION->GetCurPage(false) == "/personal/cart/"): ?>active<?php endif ?> position-relative d-md-block d-none mr-2">
	                    <div class="position-absolute basket-quantity">
	                        <div class="ellipse bg-red text-white text-center font-weight-bold"></div>
	                    </div>
	                    <svg fill="#D0A550" width="30" height="26" viewBox="0 0 30 26" xmlns="http://www.w3.org/2000/svg">
	                        <rect y="8.04688" width="30" height="2.30769" rx="1"/>
	                        <path d="M2.61923 12.7513C2.46144 12.1202 2.9388 11.5088 3.58937 11.5088H26.4124C27.063 11.5088 27.5404 12.1202 27.3826 12.7513L24.421 24.5975C24.3097 25.0426 23.9098 25.3549 23.4509 25.3549H6.55091C6.09204 25.3549 5.69206 25.0426 5.58077 24.5975L2.61923 12.7513Z"/>
	                        <rect x="10.9185" y="0.196289" width="2.57544" height="10.3018" rx="1" transform="rotate(30 10.9185 0.196289)"/>
	                        <rect width="2.57544" height="10.3018" rx="1" transform="matrix(-0.866025 0.5 0.5 0.866025 19.5386 0.196289)"/>
	                        <rect x="9.23047" y="13.8164" width="2.30769" height="8.07692" rx="1" fill="white"/>
	                        <rect x="13.8457" y="13.8164" width="2.30769" height="8.07692" rx="1" fill="white"/>
	                        <rect x="18.4609" y="13.8164" width="2.30769" height="8.07692" rx="1" fill="white"/>
	                    </svg>
	                    <span class="d-none d-md-block text-gold mt-2">Корзина</span>
	                </a>
            	</div>
            </div>
        </div>
    </header>
    <section class="content <?if($USER->IsAdmin()):?>ShowPanel<?endif;?> container-fluid main-content-block">
		<?if($_GET['test'] == 1):?>
		<div class="ny-tree"></div>
		<div class="ny-ring"></div>
		<div class="ny-snow"></div>
		<div class="ny-cake"></div>
		<div class="ny-sock"></div>
		<div class="ny-star"></div>
		<?endif;?>