<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
* @global CMain $APPLICATION
* @var array $arParams
* @var array $arResult
* @var CatalogSectionComponent $component
* @var CBitrixComponentTemplate $this
* @var string $templateName
* @var string $componentPath
* @var string $templateFolder
*/

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];

$namecode = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? 'NAIMENOVANIE_DLYA_SAYTA'
	: 'NAME';
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];

$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';
$templateFolder = $this->GetFolder();
?>
<!-- Под мобильный слайдер галерея -->
<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/lib/lightGallery/lightgallery.min.css" />
<script defer src="<?=SITE_TEMPLATE_PATH?>/lib/lightGallery/lightgallery.min.js"></script>
<!-- Подгрузка скриптов для страницы -->
<?
if ($_POST['ajax']=='Y'){
	?>
		<script type="text/javascript">
			function loadscripts() {
		        $.getScript( "<?=$templateFolder?>/newAjax.js" );
		    }
		    setTimeout(loadscripts, 200);
		</script>
	<?
}else{
	?>
		<script type="text/javascript">
			function loadscripts() {
		        $.getScript( "<?=$templateFolder?>/new.js" );
		    }
		    setTimeout(loadscripts, 200);
		</script>
	<?
}
//Размер
$array = array(
	'1,5-спальное',
	'Евро',
	'Евро (2-спальное)',
	'Семейное',
	'Семейное (2-пододеяльника)'
);
if (in_array($arResult["PROPERTIES"]['OBSHCHIY_RAZMER_DLYA_SAYTA']['VALUE'], $array)) {
    $RAZMER = $arResult["PROPERTIES"]['OBSHCHIY_RAZMER_DLYA_SAYTA']['VALUE'];
    $RAZMERCODE = "OBSHCHIY_RAZMER_DLYA_SAYTA";
  }else{
    $RAZMER = $arResult["PROPERTIES"]['RAZMER']['VALUE'];
	$RAZMERCODE = "RAZMER";}
?>
<script type="text/javascript">
	$(document).ready(function(){
		function FacebookElement() {
		    fbq('track', 'ViewContent', {
		    	value: "<?=$price['PRICE'];?>",
		    	currency: 'RUB',
	            content_name: "<?=$name;?>",
				// contents: [<?echo $arResult['ID'];?>],
				content_ids: [<?echo $arResult['ID'];?>],
	            content_type: 'product',
	            content_category: '<? echo $arResult[SECTION][NAME];?>',
	            // product_catalog_id: ''
	        });
        }setTimeout(FacebookElement, 1000);
    });
</script>
<?if ($_POST['ajax']!='Y'){?>
	<script type="text/javascript">
		// window.dataLayer = window.dataLayer || [];
		dataLayer.push({
		  'event': ' view_item',
		  'value': '<?=$price['PRICE']?>',
		  'items' : [{
		    'id': '<?=$arResult["ID"]?>',
		    'google_business_vertical': 'retail'
		  }]
		});
	</script>
<?}?>
<!-- Начало компонента -->
<div class="<?if ($_POST['ajax']=='Y'){?>d-flex wide mx-auto px-4 py-5<?}else{?>row<?}?>" id="<?=$itemIds['ID']?>" itemscope itemtype="http://schema.org/Product">
	<div class="w-100 d-flex flex-wrap">
		<?
		if (CUser::GetID() == 20078){
			// print_r($arResult['PROPERTIES']['VIDEO']);
		}
		?>
	    <div class="item element w-100 d-flex flex-wrap"
			data-id="<?=$arResult["ID"]?>"
			data-price="<?=$price['PRICE']?>"
			data-name="<?=$name?>"
			data-name-code="<?=$namecode?>"
			data-color="<?=$arResult["PROPERTIES"]['TSVET']['VALUE']?>"
			data-preview="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"
			data-size="<?=$RAZMER?>"
			data-size-code="<?=$RAZMERCODE?>">

			<!-- Микроразметка -->
			<meta itemprop="name" content="<?=$name?>" />
			<meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
			<meta itemprop="brand" content="Aryahome" />
			<meta itemprop="sku" content="<?=$arResult["PROPERTIES"]['CML2_ARTICLE']['VALUE']?>" />

	    	<?if ($_POST['ajax']=='Y'){?>
		    	<div class="close position-absolute">
	                <a href="#" onclick="closeQuickview(this); return false">
	                    <svg fill="#262626" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
	                        <rect x="1.50391" width="21.9719" height="2.12631" rx="1.06316" transform="rotate(45 1.50391 0)"></rect>
	                        <rect width="21.9719" height="2.12631" rx="1.06316" transform="matrix(-0.707107 0.707107 0.707107 0.707107 15.5391 0)"></rect>
	                    </svg>
	                </a>
	            </div>
            <?}else{
            	?>
            	<div class="w-100 d-none d-md-block">
            		<a href="#" onclick="GoBack(); return false" class="bg-light d-inline-block text-gold text-center font-weight-500 border-gold py-md-2 py-1 px-4 mb-1">Назад</a>
            	</div>
            	<?
            }?>
	        <div class="product-name fix-mobile-padding w-100 d-flex flex-wrap <?if ($_POST['ajax']!='Y'){?>justify-content-between<?}?> order-2 order-md-1">
	        	<?if ($_POST['ajax']=='Y'){?>
	        	<div class="col-12 col-md-9">
                    <div class="row">
                         <h1 class="product-title title-2 font-weight-800"><?=$name?></h1>
                    </div>
                </div>
                <?}else{?>
                	 <h1 class="product-title title-2 font-weight-800"><?=$name?></h1>
                <?}?>
	            <div class="d-flex flex-wrap justify-content-between <?if ($_POST['ajax']!='Y'){?>justify-content-md-end<?}?> flex-grow-1">
	                <div class="props d-md-none d-flex">
	                    <div class="name text-gray">Артикул :</div>
	                    <div class="value font-weight-bold">&nbsp;<?=$arResult["PROPERTIES"]['CML2_ARTICLE']['VALUE']?></div>
	                </div>
	                <div class="stars d-none align-items-baseline">
	                	<?if ($arParams['USE_VOTE_RATING'] === 'Y')
						{
							$APPLICATION->IncludeComponent(
								'bitrix:iblock.vote',
								'.default',
								array(
									'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
									'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
									'IBLOCK_ID' => $arParams['IBLOCK_ID'],
									'ELEMENT_ID' => $arResult['ID'],
									'ELEMENT_CODE' => '',
									'MAX_VOTE' => '5',
									'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
									'SET_STATUS_404' => 'N',
									'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
									'CACHE_TYPE' => $arParams['CACHE_TYPE'],
									'CACHE_TIME' => $arParams['CACHE_TIME']
								),
								$component,
								array('HIDE_ICONS' => 'Y')
							);
						}?>
	                </div>
	            </div>
	        </div>
	        <div class="col-12 <?if ($_POST['ajax']=='Y'){?>col-md-9<?}else{?>col-md-6 mt-md-4<?}?> order-1 order-md-1">
	            <div class="row">
	            	<a href="" class="addtofavorite d-md-none d-block" onclick="formtofavoriteElement(this);return false">
		                <svg fill="#FFF9ED" width="23" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
		                    <path d="M20.7151 1.959C19.5503 0.695744 17.9522 0 16.2146 0C14.9158 0 13.7264 0.410614 12.6793 1.22034C12.1509 1.62907 11.6721 2.12912 11.25 2.71276C10.8281 2.12929 10.3491 1.62907 9.82058 1.22034C8.77361 0.410614 7.58417 0 6.28538 0C4.54782 0 2.94949 0.695744 1.78476 1.959C0.633945 3.20749 0 4.91312 0 6.76191C0 8.66478 0.709133 10.4066 2.2316 12.2437C3.59356 13.8871 5.55101 15.5553 7.8178 17.487C8.59182 18.1467 9.46918 18.8944 10.3802 19.6909C10.6209 19.9017 10.9297 20.0178 11.25 20.0178C11.5701 20.0178 11.8791 19.9017 12.1195 19.6913C13.0305 18.8946 13.9083 18.1465 14.6827 17.4865C16.9492 15.5551 18.9066 13.8871 20.2686 12.2436C21.791 10.4066 22.5 8.66478 22.5 6.76174C22.5 4.91312 21.8661 3.20749 20.7151 1.959Z"/>
		                </svg>
		            </a>
	                <div class="product-images mobile owl-carousel" id="lightgallery">
	                	<?if (!empty($arResult["PROPERTIES"]['VIDEO']['VALUE'])){?>
							<div class="w-100" style="height: 100%;">
								<video controls="controls" class="text-center w-100" style="height: 100%;" autoplay muted>
									<source src="<?=CFile::GetPath($arResult["PROPERTIES"]['VIDEO']['VALUE'])?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
								</video>
							</div>
						<?}?>
	                	<?
	                	if (!empty($actualItem['MORE_PHOTO']))
						{
							foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
							{
								?>
								<a href="<?=$photo['SRC']?>" >
			                        <img src="<?=$photo['SRC']?>" class="w-100" loading="lazy">
			                    </a>
								<?
							}
						}
	                	?>
	                </div>
	                <div class="preview d-md-block d-none position-relative">
	                	<div class="slider-control up position-absolute w-100 justify-content-center py-2">
	                		<svg fill="#262626" width="17" height="10" viewBox="0 0 17 10" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.50003 -7.98981e-05C8.8047 -7.98714e-05 9.10934 0.116252 9.34163 0.348426L16.6513 7.65814C17.1162 8.12313 17.1162 8.87703 16.6513 9.34183C16.1865 9.80663 15.4327 9.80663 14.9677 9.34183L8.50003 2.87379L2.03233 9.3416C1.56735 9.8064 0.813674 9.8064 0.348911 9.3416C-0.116302 8.8768 -0.116302 8.1229 0.348911 7.65791L7.65843 0.3482C7.89083 0.115988 8.19547 -7.99247e-05 8.50003 -7.98981e-05Z"/>
							</svg>
	                	</div>
	                	<div class="slider-controls">
		                	<?if (!empty($arResult["PROPERTIES"]['VIDEO']['VALUE'])){?>
								<div class="product-item-detail-slider-controls-image mb-1" id="slider-controls-video" onmouseover="slidercontrolsvideo()">
									<span class="video-thumb-placeholder position-relative w-100 d-inline-block">
										<i class="i"></i>
										<b class="play-btn position-absolute w-100 d-inline-block"><span></span></b>
										<i class="i"></i>
									</span>
								</div>
							<?}?>
		                	<?
							if ($showSliderControls)
							{
								if ($haveOffers)
								{
									foreach ($arResult['OFFERS'] as $keyOffer => $offer)
									{
										if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
											continue;

										$strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
										?>
										<div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_OF_ID'].$offer['ID']?>" style="display: <?=$strVisible?>;">
											<?
											foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo)
											{
												?>
												<div class="product-item-detail-slider-controls-image<?=($key == 0 ? ' active current' : '')?> mb-1"
													data-entity="slider-control" 
													data-value="<?=$offer['ID'].'_'.$photo['ID']?>"
													data-slide="<?=$key?>" 
													data-slide-current="<?if($key=='0'){?>first<?}?><?if($key=='2'){?>third<?}?>">
													<img src="<?=$photo['SRC']?>">
												</div>
												<?
												if ($key > 2) {
													$sliderControlDown = 'active';
												}
											}
											?>
										</div>
										<?
									}
								}
								else
								{
									?>
									<div class="product-item-detail-slider-controls-block position-relative" id="<?=$itemIds['SLIDER_CONT_ID']?>">
										<?
										if (!empty($actualItem['MORE_PHOTO']))
										{
											$count = '0';
											foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
											{
												$count++;
												?>
												<div class="product-item-detail-slider-controls-image<?=($key == 0 ? ' active current' : '')?> mb-1"
													onmouseover="slidercontrolsimg()"
													data-entity="slider-control" 
													data-value="<?=$photo['ID']?>" 
													data-slide="<?=$key?>">
													<img src="<?=$photo['SRC']?>">
												</div>
												<?
											}
										}
										if (!empty($arResult["PROPERTIES"]['VIDEO']['VALUE'])){
											if ($count > 1) {
												$sliderControlDown = 'active';
												?><input type="text" name="max-sliders" value="<?=$count+1?>" hidden><?
											}
										}else{
											if ($count > 2) {
												$sliderControlDown = 'active';
												?><input type="text" name="max-sliders" value="<?=$count?>" hidden><?
											}
										}
										?>
									</div>
									<?
								}
							}
							?>
						</div>
						<div class="slider-control down <?=$sliderControlDown?> position-absolute w-100 justify-content-center py-2">
							<svg fill="#262626" width="17" height="10" viewBox="0 0 17 10" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.49997 9.69051C8.1953 9.69051 7.89066 9.57418 7.65837 9.342L0.348741 2.03229C-0.116247 1.5673 -0.116247 0.813401 0.348741 0.3486C0.813541 -0.1162 1.56729 -0.1162 2.03231 0.3486L8.49997 6.81664L14.9677 0.348826C15.4327 -0.115974 16.1863 -0.115974 16.6511 0.348826C17.1163 0.813627 17.1163 1.56753 16.6511 2.03251L9.34157 9.34223C9.10917 9.57444 8.80453 9.69051 8.49997 9.69051Z"/>
							</svg>
						</div>
	                </div>
	                <div class="product-image d-md-block d-none position-relative col">
	                	<?if (!empty($arResult["PROPERTIES"]['VIDEO']['VALUE'])){?>
							<div class="position-absolute w-100" data-entity="image" id="slider-video" data-id="<?=$photo['ID']?>" style="display: none;height: 100%;z-index: 100;">
								<video controls="controls" class="text-center w-100" id="movie" style="height: 100%;" muted>
									<source src="<?=CFile::GetPath($arResult["PROPERTIES"]['VIDEO']['VALUE'])?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
								</video>
							</div>
						<?}?>
						<?

							if ($arResult['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Желтый') {
		                    ?>
			                    <div class="label new position-absolute big-ellipse bg-red text-white Montserrat font-weight-bold d-flex align-items-center justify-content-center text-uppercase">
			                        New
			                    </div>
			                    <? 
			                }
			                elseif($arResult['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Зеленый') {
			                    ?>
			                    <div class="label new position-absolute big-ellipse bg-green text-white Montserrat font-weight-bold d-flex align-items-center justify-content-center text-uppercase">
			                        <span class="title-3">%</span>
			                    </div>
			                    <? 
			                }
			                elseif($arResult['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Оранжеый') {
			                    ?>
			                    <div class="label new position-absolute big-ellipse bg-orange text-white Montserrat font-weight-bold d-flex align-items-center justify-content-center text-uppercase">
			                        <span class="title-3">%</span>
			                    </div>
			                    <? 
			                }
			                
			            ?>
	                    <div class="product-item-detail-slider-container position-relative" id="<?=$itemIds['BIG_SLIDER_ID']?>">
							<span class="product-item-detail-slider-close" data-entity="close-popup"></span>
							<div class="product-item-detail-slider-block position-relative <?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '')?>"
								data-entity="images-slider-block">
								<span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
								<span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>
								<div class="product-item-detail-slider-images-container position-absolute" data-entity="images-container">
									<?
									if (!empty($actualItem['MORE_PHOTO']))
									{
										foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
										{
											?>
											<div class="product-item-detail-slider-image position-absolute<?=($key == 0 ? ' active' : '')?>" id="slider-img" data-entity="image" data-id="<?=$photo['ID']?>">
												<img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>"<?=($key == 0 ? ' itemprop="image"' : '')?>>
											</div>
											<?
										}
									}

									if ($arParams['SLIDER_PROGRESS'] === 'Y')
									{
										?>
										<div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar" style="width: 0;"></div>
										<?
									}
									?>
								</div>
							</div>
						</div>
	                </div>
	            </div>
	        </div>
	        <div class="col-12 <?if ($_POST['ajax']=='Y'){?>col-md-3<?}else{?>col-md-6 mt-md-4 pl-md-5<?}?> mt-3 order-4 order-md-1">
	            <div class="row">
	                <div class="position-relative w-100 <?if ($_POST['ajax']!='Y'){?>pt-md-3<?}?>">
	                	<?
						$showOffersBlock = $haveOffers && !empty($arResult['OFFERS_PROP']);
						$mainBlockProperties = array_intersect_key($arResult['DISPLAY_PROPERTIES'], $arParams['MAIN_BLOCK_PROPERTY_CODE']);
						$showPropsBlock = !empty($mainBlockProperties) || $arResult['SHOW_OFFERS_PROPS'];
						$showBlockWithOffersAndProps = $showOffersBlock || $showPropsBlock;
						?>
	                	<div class="price-mobile d-flex <?if ($_POST['ajax']=='Y'){?>flex-wrap<?}?> py-3 py-md-0">
                            <div class="<?if ($_POST['ajax']=='Y'){?>col-12 order-2<?}else{?>col-8 col-md-6<?}?>">
                                <div class="price row fix-mobile-padding align-items-center justify-content-between w-100 d-md-block">
                                	<?
                                	foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName)
										{
											switch ($blockName)
											{
												case 'price':

													$db_res = CPrice::GetList(
												        array(),
												        array(
												                "PRODUCT_ID" => $arResult["ID"],
												                "CATALOG_GROUP_ID" => '7'
												            )
													    );
													if ($ar_res = $db_res->Fetch())
													{
													    $RC = $ar_res["PRICE"];
													    $RC = round($RC);
													    $RC = floor($RC);
													}
													// echo CurrencyFormat($RC, $ar_res["CURRENCY"]);

													$db_res = CPrice::GetList(
												        array(),
												        array(
												                "PRODUCT_ID" => $arResult["ID"],
												                "CATALOG_GROUP_ID" => '8'
												            )
													    );
													if ($ar_res = $db_res->Fetch())
													{
													    $RCC = $ar_res["PRICE"];
													    $RCC = round($RCC);
													    $RCC = floor($RCC);
													}
													// echo CurrencyFormat($RCC, $ar_res["CURRENCY"]);
													if (!empty($RCC)){
													?>
													<span id="<?=$itemIds['PRICE_ID']?>" class="d-none"><?=$price['PRINT_RATIO_PRICE']?></span>
													<div class="product-item-detail-pay-block <?if ($_POST['ajax']=='Y'){?>mt-md-4<?}?>">
				                                        <span id="" class="<?if ($arResult['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Красный'){?>text-red<?}?>">
				                                        		<?=CurrencyFormat($price['PRICE'], $ar_res["CURRENCY"])?>
				                                        </span>
				                                    </div>
			                                    	<?
			                                    	}else{
			                                    		?>Нет цены<?
			                                    	}
			                                    	if ($RCC < $RC)
													{
														?>
														<div class="old font-weight-500 <?if ($_POST['ajax']!='Y'){?>mt-md-4<?}?>">
					                                        <del>
					                                        	<span class="d-md-inline d-block text-gray mr-2" id="">
					                                        		<?=CurrencyFormat($RC, $ar_res["CURRENCY"])?>
					                                        	</span>
					                                    	</del>
					                                    	<?
					                                    	if ($showDiscount) //Скидка, разнциа в рублях
															{
																?>	
																	<span class="d-none" id="<?=$itemIds['DISCOUNT_PRICE_ID']?>">
																		<span class="d-md-inline d-none" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>">Скидка: </span> <?echo $price['PRINT_RATIO_DISCOUNT'];?>
																	</span>
																<?
															}
					                                    	// if ($USER->IsAdmin()){
				                                    		$skidka = (($price['PRICE'] - $RC)/$RC)*100;
				                                    		$skidka = round($skidka);
				                                    		$skidka = floor($skidka);
				                                    		// echo floor($skidka).'%';
					                                    	// }
					                                    	?>
					                                        <span class="d-md-inline discount text-red">
																<span class="<?if ($arResult['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Красный'){?>d-none<?}else{?>d-inline<?}?>">
																	<span class="d-md-inline d-none">Скидка: </span> <?=$skidka?>%
																</span>
					                                        </span>
					                                    </div>
														<?
													}
													break;  // Цены
												case 'priceRanges':  // Диапазон цен
													if ($arParams['USE_PRICE_COUNT'])
													{
														$showRanges = !$haveOffers && count($actualItem['ITEM_QUANTITY_RANGES']) > 1;
														$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';
														?>
														<div class="mb-3"
															<?=$showRanges ? '' : 'style="display: none;"'?>
															data-entity="price-ranges-block">
															<?
															if ($arParams['MESS_PRICE_RANGES_TITLE'])
															{
																?>
																<div class="product-item-detail-info-container-title text-center">
																	<?= $arParams['MESS_PRICE_RANGES_TITLE'] ?>
																	<span data-entity="price-ranges-ratio-header">
																(<?= (Loc::getMessage(
																			'CT_BCE_CATALOG_RATIO_PRICE',
																			array('#RATIO#' => ($useRatio ? $measureRatio : '1').' '.$actualItem['ITEM_MEASURE']['TITLE'])
																		)) ?>)
															</span>
																</div>
																<?
															}
															?>
															<ul class="product-item-detail-properties" data-entity="price-ranges-body">
																<?
																if ($showRanges)
																{
																	foreach ($actualItem['ITEM_QUANTITY_RANGES'] as $range)
																	{
																		if ($range['HASH'] !== 'ZERO-INF')
																		{
																			$itemPrice = false;

																			foreach ($arResult['ITEM_PRICES'] as $itemPrice)
																			{
																				if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
																				{
																					break;
																				}
																			}

																			if ($itemPrice)
																			{
																				?>
																				<li class="product-item-detail-properties-item">
																				<span class="product-item-detail-properties-name text-muted">
																					<?
																					echo Loc::getMessage(
																							'CT_BCE_CATALOG_RANGE_FROM',
																							array('#FROM#' => $range['SORT_FROM'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
																						).' ';

																					if (is_infinite($range['SORT_TO']))
																					{
																						echo Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
																					}
																					else
																					{
																						echo Loc::getMessage(
																							'CT_BCE_CATALOG_RANGE_TO',
																							array('#TO#' => $range['SORT_TO'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
																						);
																					}
																					?>
																				</span>
																					<span class="product-item-detail-properties-dots"></span>
																					<span class="product-item-detail-properties-value"><?=($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE'])?></span>
																				</li>
																				<?
																			}
																		}
																	}
																}
																?>
															</ul>
														</div>
														<?
														unset($showRanges, $useRatio, $itemPrice, $range);
													}

													break;
											}
										}
									?>
                                </div> 
                            </div>
                            <div class="<?if ($_POST['ajax']=='Y'){?>col-12 order-1<?}else{?>col-4 col-md-6<?}?>">
                                <div class="row <?if ($_POST['ajax']!='Y'){?>justify-content-end<?}?>">
                                    <div class="d-block fix-mobile-padding">
                                        <div class="props d-md-flex d-none">
                                            <div class="name text-gray mr-3">Артикул :</div>
                                            <div class="value font-weight-500"><?=$arResult["PROPERTIES"]['CML2_ARTICLE']['VALUE']?></div>
                                        </div>
                                        <div class="tags <?if ($_POST['ajax']=='Y'){?>d-none<?}else{?>d-flex justify-content-end<?}?> mt-2">
                                        	<div>
	                                        	<?php if ($arResult["PROPERTIES"]['Bestseller']['VALUE_XML_ID'] == 'yes'): ?>
	                                        		<div class="bestseller bg-light text-gold text-center font-weight-500 border-gold py-md-2 py-1 px-2 mb-1">
		                                                Хит продаж
		                                            </div>
	                                        	<?php endif ?>
	                                        	<?php if ($arResult["PROPERTIES"]['Recommended']['VALUE_XML_ID'] == 'yes'): ?>
	                                        		<div class="bestseller bg-light text-gold text-center font-weight-500 border-gold py-md-2 py-1 px-2 mb-1">
		                                                Рекомендуем
		                                            </div>
	                                        	<?php endif ?>
                                        	</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="props fix-mobile-padding d-flex flex-wrap mt-4" data-type="<?if ($_POST['ajax']=='Y'){?>quickview<?}else{?>element<?}?>:props">
                        	<?
							if ($showBlockWithOffersAndProps) // Свойства предложения справа от картинки
							{
								foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName)
								{
									switch ($blockName)
									{
										case 'sku':
											if ($showOffersBlock)
											{
												?>
												<div class="mb-3" id="<?=$itemIds['TREE_ID']?>">
													<?
													foreach ($arResult['SKU_PROPS'] as $skuProperty)
													{
														if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
															continue;

														$propertyId = $skuProperty['ID'];
														$skuProps[] = array(
															'ID' => $propertyId,
															'SHOW_MODE' => $skuProperty['SHOW_MODE'],
															'VALUES' => $skuProperty['VALUES'],
															'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
														);
														?>
														<div data-entity="sku-line-block" class="mb-3">
															<div class="product-item-scu-container-title"><?=htmlspecialcharsEx($skuProperty['NAME'])?></div>
															<div class="product-item-scu-container">
																<div class="product-item-scu-block">
																	<div class="product-item-scu-list">
																		<ul class="product-item-scu-item-list">
																			<?
																			foreach ($skuProperty['VALUES'] as &$value)
																			{
																				$value['NAME'] = htmlspecialcharsbx($value['NAME']);

																				if ($skuProperty['SHOW_MODE'] === 'PICT')
																				{
																					?>
																					<li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
																						data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
																						data-onevalue="<?=$value['ID']?>">
																						<div class="product-item-scu-item-color-block">
																							<div class="product-item-scu-item-color" title="<?=$value['NAME']?>"
																								style="background-image: url('<?=$value['PICT']['SRC']?>');">
																							</div>
																						</div>
																					</li>
																					<?
																				}
																				else
																				{
																					?>
																					<li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
																						data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
																						data-onevalue="<?=$value['ID']?>">
																						<div class="product-item-scu-item-text-block">
																							<div class="product-item-scu-item-text"><?=$value['NAME']?></div>
																						</div>
																					</li>
																					<?
																				}
																			}
																			?>
																		</ul>
																		<div style="clear: both;"></div>
																	</div>
																</div>
															</div>
														</div>
														<?
													}
													?>
												</div>
												<?
											}

											break;

										case 'props':
											if ($showPropsBlock)
											{
												if (!empty($mainBlockProperties))
												{
													foreach ($mainBlockProperties as $property)
													{
														?>
														<div class="name text-gray col-4 col-md-2 mb-2">
															<div class="row">
							                                	<?=$property['NAME']?>
							                                </div>
							                            </div>
							                            <div class="value col-8 col-md-10 mb-2">
							                            	<div class="row">
							                                	<?=(is_array($property['DISPLAY_VALUE'])
																	? implode(' / ', $property['DISPLAY_VALUE'])
																	: $property['DISPLAY_VALUE'])?>
															</div>
							                            </div>
														<?
													}
												}

												if ($arResult['SHOW_OFFERS_PROPS'])
												{
													?>
													<ul class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_MAIN_PROP_DIV']?>"></ul>
													<?
												}
											}

											break;
									}
								}
							}
							?>
							<?if ($_POST['ajax']=='Y'){?>
								<?php if (!empty($arResult["PROPERTIES"]['SOSTAV']['VALUE'])): ?>
									<div class="name text-gray col-6 col-md-6 mb-2">
										<div class="row">
		                                	Состав:
		                                </div>
		                            </div>
		                            <div class="value col-6 col-md-6 mb-2">
		                            	<div class="row">
		                                	<?=$arResult["PROPERTIES"]['SOSTAV']['VALUE']?>
		                                </div>
		                            </div>
								<?php endif ?>
								<?php if (!empty($arResult["PROPERTIES"]['MATERIAL']['VALUE'])): ?>
									<div class="name text-gray col-6 col-md-6 mb-2">
		                            	<div class="row">
		                                	Материал:
		                                </div>
		                            </div>
		                            <div class="value col-6 col-md-6 mb-2">
		                            	<div class="row">
		                                	<?=$arResult["PROPERTIES"]['MATERIAL']['VALUE']?>
		                                </div>
		                            </div>
								<?php endif ?>
								<?php if (!empty($arResult["PROPERTIES"]['MATERIAL_CHEKHLA']['VALUE'])): ?>
									<div class="name text-gray col-6 col-md-6 mb-2">
		                            	<div class="row">
		                                	Материал чехла:
		                                </div>
		                            </div>
		                            <div class="value col-6 col-md-6 mb-2">
		                            	<div class="row">
		                                	<?=$arResult["PROPERTIES"]['MATERIAL_CHEKHLA']['VALUE']?>
		                                </div>
		                            </div>
								<?php endif ?>
								<?php if (!empty($arResult["PROPERTIES"]['VID_KREPLENIYA_SHTOR']['VALUE'])): ?>
									<div class="name text-gray col-6 col-md-6 mb-2">
		                            	<div class="row">
		                                	Вид крепления штор:
		                                </div>
		                            </div>
		                            <div class="value col-6 col-md-6 mb-2">
		                            	<div class="row">
		                                	<?=$arResult["PROPERTIES"]['VID_KREPLENIYA_SHTOR']['VALUE']?>
		                                </div>
		                            </div>
								<?php endif ?>
							<?}?>
							<div class="color w-100">
								<?php if (!empty($arResult["PROPERTIES"]['TSVET']['VALUE'])): ?>
									<div class="name text-gray col-12 mb-2">
										<div class="row">Цвет:</div>
									</div>
									<div class="value w-100 mb-2">
										<div class="w-100 d-flex flex-wrap">
											<?if ($_POST['ajax']=='Y'){?>
												<a href="#" onclick="UpdateParamAjaxCatalogElement(this); return false" class="active d-inline-block position-relative" data-id="<?=$arResult["ID"]?>"><img width="56px" height="56px" src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" loading="lazy" title="<?=$arResult["PROPERTIES"]['TSVET']['VALUE']?>"></a>
											<?}else{?>
												<a href="<?=$APPLICATION->GetCurPage(false);?>" class="active d-inline-block position-relative" data-name="<?=$name?>" data-color="<?=$arResult["PROPERTIES"]['TSVET']['VALUE']?>">
													<img width="56px" height="56px" src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" loading="lazy" title="<?=$arResult["PROPERTIES"]['TSVET']['VALUE']?>">
												</a>
											<?}?>
										</div>
									</div>
								<?php endif ?>
							</div>
							<div class="size w-100">
								<?php if (!empty($RAZMER)): ?>
									<div class="name text-gray col-12 mb-2">
										<div class="row">Размер:</div>
									</div>
									<div class="value w-100 mb-2">
										<div class="w-100 d-flex flex-wrap">
											<?if ($_POST['ajax']=='Y'){?>
												<a href="" onclick="UpdateParamAjaxCatalogElement(this); return false" class="active position-relative mb-1" data-id="<?=$arResult["ID"]?>"><span class="d-block bg-graylight text-gold px-2 py-2"><?=$RAZMER?></span></a>
											<?}else{?>
												<a href="<?=$APPLICATION->GetCurPage(false);?>" class="active position-relative mb-1" data-id="<?=$arResult["ID"]?>"><span class="d-block bg-graylight text-gold px-2 py-2"><?=$RAZMER?></span></a>
											<?}?>
										</div>
									</div>
								<?php endif ?>
							</div>
                        </div>
                        <div class="formtocart fix-mobile-padding d-md-block d-flex justify-content-between bg-white w-100 py-3 py-md-0">
                        	<?
							foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName)
							{
								switch ($blockName)
								{
									case 'quantityLimit':
										if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
										{
											if ($haveOffers)
											{
												?>
												<div class="mb-3" id="<?=$itemIds['QUANTITY_LIMIT']?>" style="display: none;">
													<div class="product-item-detail-info-container-title text-center">
														<?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
													</div>
													<span class="product-item-quantity" data-entity="quantity-limit-value"></span>
												</div>
												<?
											}
											else
											{
												if (
													$measureRatio
													&& (float)$actualItem['PRODUCT']['QUANTITY'] > 0
													&& $actualItem['CHECK_QUANTITY']
												)
												{
													?>
													<div class="mb-3 text-center" id="<?=$itemIds['QUANTITY_LIMIT']?>">
														<span class="product-item-detail-info-container-title"><?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:</span>
														<span class="product-item-quantity" data-entity="quantity-limit-value">
														<?
														if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
														{
															if ((float)$actualItem['PRODUCT']['QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
															{
																echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
															}
															else
															{
																echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
															}
														}
														else
														{
															echo $actualItem['PRODUCT']['QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
														}
														?>
													</span>
													</div>
													<?
												}
											}
										}

										break;

									case 'quantity':
										if ($arParams['USE_PRODUCT_QUANTITY'])
										{
											?>
											<div class="quantity w-100 <?=($actualItem['CAN_BUY'] ? 'd-md-block d-flex' : 'd-none')?> align-items-center" <?= (!$actualItem['CAN_BUY'] ? ' style="display: none;"' : '') ?> data-entity="quantity-block">
												<?
												if (Loc::getMessage('CATALOG_QUANTITY'))
												{
													?>
													<div class="name text-gray w-100 d-md-block d-none"><?= Loc::getMessage('CATALOG_QUANTITY') ?></div>
													<?
												}
												?>
				                                <div class="value d-flex w-100 mt-md-2 mb-md-3">
				                                	<span class="product-item-amount-field-btn-minus no-select btn border-gold round d-flex justify-content-center align-items-center" id="<?=$itemIds['QUANTITY_DOWN_ID']?>">
				                                		<svg fill="#D0A550" width="14" height="2" viewBox="0 0 14 2" xmlns="http://www.w3.org/2000/svg">
				                                            <rect width="14" height="2" rx="1"/>
				                                        </svg>
				                                	</span>
				                                	<input class="product-item-amount-field font-weight-500 text-center border-none" id="<?=$itemIds['QUANTITY_ID']?>" type="number" value="<?=$price['MIN_QUANTITY']?>">
				                                    <span class="product-item-amount-field-btn-plus no-select btn border-gold round d-flex justify-content-center align-items-center" id="<?=$itemIds['QUANTITY_UP_ID']?>">
				                                    	<svg fill="#D0A550" width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
				                                            <rect y="6" width="14" height="2" rx="1"/>
				                                            <rect x="8" width="14" height="2" rx="1" transform="rotate(90 8 0)"/>
				                                        </svg>
				                                    </span>
				                                </div>
				                                <div class="mt-2 d-none d-md-block">
				                                	<span class="product-item-amount-description-container">
														<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
													</span>
				                                </div>
				                            </div>
											<?
										}

										break;

									case 'buttons':
										?>
										<div class="<?=($actualItem['CAN_BUY'] ? 'd-flex' : 'd-none')?> align-items-center w-100 justify-content-md-start justify-content-end mt-md-2" data-entity="main-button-container" id="<?=$itemIds['BASKET_ACTIONS_ID']?>">
											<?
											if ($showAddBtn)
											{?>
												<a href="#" onclick="Add2BasketByProductID(this,$('input.product-item-amount-field').val()); return false" class="addtobasket btn text-uppercase round d-flex align-items-center bg-active text-white font-weight-500 py-3 px-3 px-md-4">
		                                            <svg fill="white" width="25" height="21" viewBox="0 0 25 21" xmlns="http://www.w3.org/2000/svg">
		                                                <path d="M0 7.10838C0 6.61526 0.399746 6.21552 0.892857 6.21552H24.1071C24.6003 6.21552 25 6.61526 25 7.10838V7.24574C25 7.73885 24.6003 8.1386 24.1071 8.1386H0.892857C0.399745 8.1386 0 7.73885 0 7.24574V7.10838Z"></path>
		                                                <path d="M8.65278 0.446578C8.89934 0.0195306 9.4454 -0.126786 9.87245 0.119769L10.1846 0.300014C10.6117 0.546569 10.758 1.09263 10.5114 1.51968L7.1119 7.40787C6.86535 7.83492 6.31928 7.98123 5.89224 7.73468L5.58004 7.55443C5.153 7.30788 5.00668 6.76182 5.25323 6.33477L8.65278 0.446578Z"></path>
		                                                <path d="M16.7283 0.446578C16.4818 0.0195306 15.9357 -0.126786 15.5087 0.119769L15.1965 0.300014C14.7694 0.546569 14.6231 1.09263 14.8697 1.51968L18.2692 7.40787C18.5158 7.83492 19.0618 7.98123 19.4889 7.73468L19.8011 7.55443C20.2281 7.30788 20.3745 6.76182 20.1279 6.33477L16.7283 0.446578Z"></path>
		                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.06703 9.10011C2.48616 9.10011 2.05995 9.646 2.20083 10.2095L4.63902 19.9623C4.73839 20.3597 5.09551 20.6386 5.50522 20.6386H19.4956C19.9053 20.6386 20.2624 20.3597 20.3618 19.9623L22.8 10.2095C22.9409 9.646 22.5146 9.10011 21.9338 9.10011H3.06703ZM8.58503 11.0232C8.09192 11.0232 7.69217 11.4229 7.69217 11.916V16.8611C7.69217 17.3542 8.09192 17.7539 8.58503 17.7539H8.72239C9.2155 17.7539 9.61525 17.3542 9.61525 16.8611V11.916C9.61525 11.4229 9.2155 11.0232 8.72239 11.0232H8.58503ZM11.5383 11.916C11.5383 11.4229 11.938 11.0232 12.4311 11.0232H12.5685C13.0616 11.0232 13.4613 11.4229 13.4613 11.916V16.8611C13.4613 17.3542 13.0616 17.7539 12.5685 17.7539H12.4311C11.938 17.7539 11.5383 17.3542 11.5383 16.8611V11.916ZM16.2772 11.0232C15.7841 11.0232 15.3843 11.4229 15.3843 11.916V16.8611C15.3843 17.3542 15.7841 17.7539 16.2772 17.7539H16.4146C16.9077 17.7539 17.3074 17.3542 17.3074 16.8611V11.916C17.3074 11.4229 16.9077 11.0232 16.4146 11.0232H16.2772Z"></path>
		                                            </svg>
		                                            <span class="d-block ml-3">В корзину</span>
		                                        </a>
		                                        <a href="#" class="addtofavorite d-md-inline d-none ml-1" onclick="formtofavoriteElement(this); return false">
		                                            <svg fill="#E3DDDD" width="23" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
		                                                <path d="M21.1754 2.00253C19.9848 0.711205 18.3511 0 16.5749 0C15.2473 0 14.0314 0.419739 12.961 1.24746C12.4209 1.66527 11.9315 2.17643 11.5 2.77305C11.0687 2.17661 10.5791 1.66527 10.0388 1.24746C8.96858 0.419739 7.75271 0 6.42506 0C4.64889 0 3.01503 0.711205 1.82442 2.00253C0.648033 3.27877 0 5.0223 0 6.91218C0 8.85733 0.724892 10.6379 2.28119 12.5158C3.67342 14.1957 5.67437 15.9009 7.99153 17.8756C8.78275 18.5499 9.67961 19.3143 10.6109 20.1285C10.8569 20.344 11.1726 20.4626 11.5 20.4626C11.8273 20.4626 12.1431 20.344 12.3888 20.1289C13.32 19.3145 14.2174 18.5498 15.009 17.875C17.3258 15.9008 19.3268 14.1957 20.719 12.5157C22.2753 10.6379 23 8.85733 23 6.912C23 5.0223 22.352 3.27877 21.1754 2.00253Z"></path>
		                                            </svg>
		                                        </a>
											<?}

											if ($showBuyBtn)
											{?>
												<a href="#" onclick="Add2BasketByProductID(this,$('input.product-item-amount-field').val()); return false" class="addtobasket btn text-uppercase round d-flex align-items-center bg-active text-white font-weight-500 py-3 px-3 px-md-4"
												>
		                                            <svg fill="white" width="25" height="21" viewBox="0 0 25 21" xmlns="http://www.w3.org/2000/svg">
		                                                <path d="M0 7.10838C0 6.61526 0.399746 6.21552 0.892857 6.21552H24.1071C24.6003 6.21552 25 6.61526 25 7.10838V7.24574C25 7.73885 24.6003 8.1386 24.1071 8.1386H0.892857C0.399745 8.1386 0 7.73885 0 7.24574V7.10838Z"></path>
		                                                <path d="M8.65278 0.446578C8.89934 0.0195306 9.4454 -0.126786 9.87245 0.119769L10.1846 0.300014C10.6117 0.546569 10.758 1.09263 10.5114 1.51968L7.1119 7.40787C6.86535 7.83492 6.31928 7.98123 5.89224 7.73468L5.58004 7.55443C5.153 7.30788 5.00668 6.76182 5.25323 6.33477L8.65278 0.446578Z"></path>
		                                                <path d="M16.7283 0.446578C16.4818 0.0195306 15.9357 -0.126786 15.5087 0.119769L15.1965 0.300014C14.7694 0.546569 14.6231 1.09263 14.8697 1.51968L18.2692 7.40787C18.5158 7.83492 19.0618 7.98123 19.4889 7.73468L19.8011 7.55443C20.2281 7.30788 20.3745 6.76182 20.1279 6.33477L16.7283 0.446578Z"></path>
		                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.06703 9.10011C2.48616 9.10011 2.05995 9.646 2.20083 10.2095L4.63902 19.9623C4.73839 20.3597 5.09551 20.6386 5.50522 20.6386H19.4956C19.9053 20.6386 20.2624 20.3597 20.3618 19.9623L22.8 10.2095C22.9409 9.646 22.5146 9.10011 21.9338 9.10011H3.06703ZM8.58503 11.0232C8.09192 11.0232 7.69217 11.4229 7.69217 11.916V16.8611C7.69217 17.3542 8.09192 17.7539 8.58503 17.7539H8.72239C9.2155 17.7539 9.61525 17.3542 9.61525 16.8611V11.916C9.61525 11.4229 9.2155 11.0232 8.72239 11.0232H8.58503ZM11.5383 11.916C11.5383 11.4229 11.938 11.0232 12.4311 11.0232H12.5685C13.0616 11.0232 13.4613 11.4229 13.4613 11.916V16.8611C13.4613 17.3542 13.0616 17.7539 12.5685 17.7539H12.4311C11.938 17.7539 11.5383 17.3542 11.5383 16.8611V11.916ZM16.2772 11.0232C15.7841 11.0232 15.3843 11.4229 15.3843 11.916V16.8611C15.3843 17.3542 15.7841 17.7539 16.2772 17.7539H16.4146C16.9077 17.7539 17.3074 17.3542 17.3074 16.8611V11.916C17.3074 11.4229 16.9077 11.0232 16.4146 11.0232H16.2772Z"></path>
		                                            </svg>
		                                            <span class="d-block ml-3">В корзину</span>
		                                        </a>
		                                        <a href="#" class="addtofavorite d-md-inline d-none ml-1" onclick="formtofavoriteElement(this); return false">
		                                            <svg fill="#E3DDDD" width="23" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
		                                                <path d="M21.1754 2.00253C19.9848 0.711205 18.3511 0 16.5749 0C15.2473 0 14.0314 0.419739 12.961 1.24746C12.4209 1.66527 11.9315 2.17643 11.5 2.77305C11.0687 2.17661 10.5791 1.66527 10.0388 1.24746C8.96858 0.419739 7.75271 0 6.42506 0C4.64889 0 3.01503 0.711205 1.82442 2.00253C0.648033 3.27877 0 5.0223 0 6.91218C0 8.85733 0.724892 10.6379 2.28119 12.5158C3.67342 14.1957 5.67437 15.9009 7.99153 17.8756C8.78275 18.5499 9.67961 19.3143 10.6109 20.1285C10.8569 20.344 11.1726 20.4626 11.5 20.4626C11.8273 20.4626 12.1431 20.344 12.3888 20.1289C13.32 19.3145 14.2174 18.5498 15.009 17.875C17.3258 15.9008 19.3268 14.1957 20.719 12.5157C22.2753 10.6379 23 8.85733 23 6.912C23 5.0223 22.352 3.27877 21.1754 2.00253Z"></path>
		                                            </svg>
		                                        </a>
											<?}
											if ($showSubscribe)
											{
												$APPLICATION->IncludeComponent(
													'bitrix:catalog.product.subscribe',
													'',
													array(
														'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
														'PRODUCT_ID' => $arResult['ID'],
														'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
														'BUTTON_CLASS' => 'btn u-btn-outline-primary product-item-detail-buy-button',
														'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
														'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
													),
													$component,
													array('HIDE_ICONS' => 'Y')
												);
											}
											?>
				                        </div>
				                        <div id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" class="mt-md-4" style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;">
											<a class="btn border-gray text-gray round px-3 py-2" href="javascript:void(0)" rel="nofollow"><?=$arParams['MESS_NOT_AVAILABLE']?></a>
											<?if ($_POST['ajax']=='Y') {
											?>
		                                        <a href="#" class="addtofavorite d-md-inline d-none ml-1" onclick="formtofavoriteElement(this); return false">
		                                            <svg fill="#E3DDDD" width="23" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
		                                                <path d="M21.1754 2.00253C19.9848 0.711205 18.3511 0 16.5749 0C15.2473 0 14.0314 0.419739 12.961 1.24746C12.4209 1.66527 11.9315 2.17643 11.5 2.77305C11.0687 2.17661 10.5791 1.66527 10.0388 1.24746C8.96858 0.419739 7.75271 0 6.42506 0C4.64889 0 3.01503 0.711205 1.82442 2.00253C0.648033 3.27877 0 5.0223 0 6.91218C0 8.85733 0.724892 10.6379 2.28119 12.5158C3.67342 14.1957 5.67437 15.9009 7.99153 17.8756C8.78275 18.5499 9.67961 19.3143 10.6109 20.1285C10.8569 20.344 11.1726 20.4626 11.5 20.4626C11.8273 20.4626 12.1431 20.344 12.3888 20.1289C13.32 19.3145 14.2174 18.5498 15.009 17.875C17.3258 15.9008 19.3268 14.1957 20.719 12.5157C22.2753 10.6379 23 8.85733 23 6.912C23 5.0223 22.352 3.27877 21.1754 2.00253Z"></path>
		                                            </svg>
		                                        </a>
											<?
											}else{
											?>
				                                <a href="" class="addtofavorite d-md-inline d-none ml-3" onclick="return false" data-modal="formtofavorite.element">
				                                    <svg fill="#E3DDDD" width="23" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
				                                        <path d="M21.1754 2.00253C19.9848 0.711205 18.3511 0 16.5749 0C15.2473 0 14.0314 0.419739 12.961 1.24746C12.4209 1.66527 11.9315 2.17643 11.5 2.77305C11.0687 2.17661 10.5791 1.66527 10.0388 1.24746C8.96858 0.419739 7.75271 0 6.42506 0C4.64889 0 3.01503 0.711205 1.82442 2.00253C0.648033 3.27877 0 5.0223 0 6.91218C0 8.85733 0.724892 10.6379 2.28119 12.5158C3.67342 14.1957 5.67437 15.9009 7.99153 17.8756C8.78275 18.5499 9.67961 19.3143 10.6109 20.1285C10.8569 20.344 11.1726 20.4626 11.5 20.4626C11.8273 20.4626 12.1431 20.344 12.3888 20.1289C13.32 19.3145 14.2174 18.5498 15.009 17.875C17.3258 15.9008 19.3268 14.1957 20.719 12.5157C22.2753 10.6379 23 8.85733 23 6.912C23 5.0223 22.352 3.27877 21.1754 2.00253Z"/>
				                                    </svg>
				                                </a>
												<?
											}?>
										</div>
										<?
										break;
								}
							}
							?>
                        </div>
                        <? if($_POST['ajax'] == 'Y'): ?>
                            <a class="btn d-block border-dark text-uppercase round w-100 py-3 px-3 mt-4 text-center" href="<?= $arResult['DETAIL_PAGE_URL']; ?>">Подробнее о товаре</a>
                        <? endif; ?>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="item element more fix-mobile-padding w-100 <?if ($_POST['ajax']=='Y'){?>d-none<?}?>">
        	<?
        	if ($arParams['DISPLAY_COMPARE'])
			{
				?>
				<div class="product-item-detail-compare-container py-3 py-md-3">
					<div class="product-item-detail-compare">
						<div class="checkbox">
							<label class="m-0" id="<?=$itemIds['COMPARE_LINK']?>">
								<input type="checkbox" data-entity="compare-checkbox">
								<span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
							</label>
						</div>
					</div>
				</div>
				<?
			}
        	?>
	    </div>
	    <div class="item element more fix-mobile-padding w-100 <?if ($_POST['ajax']=='Y'){?>d-none<?}?>">
	    	<?
			if ($haveOffers)
			{
				if ($arResult['OFFER_GROUP'])
				{
					?>
					<div class="w-100">
						<h2 class="title-2 font-weight-800 mt-md-5 mt-4 mb-md-4 mb-2 pt-md-0 pt-1">Подарочные наборы</h2>
						<?
						foreach ($arResult['OFFER_GROUP_VALUES'] as $offerId)
						{
							?>
							<span id="<?=$itemIds['OFFER_GROUP'].$offerId?>" style="display: none;">
								<?
								$APPLICATION->IncludeComponent(
									'bitrix:catalog.set.constructor',
									'bootstrap_v4',
									array(
										'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
										'IBLOCK_ID' => $arResult['OFFERS_IBLOCK'],
										'ELEMENT_ID' => $offerId,
										'PRICE_CODE' => $arParams['PRICE_CODE'],
										'BASKET_URL' => $arParams['BASKET_URL'],
										'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
										'CACHE_TYPE' => $arParams['CACHE_TYPE'],
										'CACHE_TIME' => $arParams['CACHE_TIME'],
										'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
										'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
										'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
										'CURRENCY_ID' => $arParams['CURRENCY_ID'],
										'DETAIL_URL' => $arParams['~DETAIL_URL']
									),
									$component,
									array('HIDE_ICONS' => 'Y')
								);
								?>
							</span>
							<?
						}
						?>
					</div>
					<?
				}
			}
			else
			{
				if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
				{
					?>
					<div class="w-100">
						<? $APPLICATION->IncludeComponent(
							'bitrix:catalog.set.constructor',
							'bootstrap_v4',
							array(
								'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'ELEMENT_ID' => $arResult['ID'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
					<?
				}
			}
			?>
	    </div>
	    <div class="item element more fix-mobile-padding w-100 <?if ($_POST['ajax']=='Y'){?>d-none<?}else{?>d-flex flex-wrap<?}?>">
	        <div class="col-12 col-md-6 mt-md-4 mt-0">
	            <div class="row">
	                <h2 class="title-2 font-weight-800 mt-md-5 mt-4 mb-md-4 mb-2 pt-md-0 pt-1">Описание товара</h2>
	                <div class="description element w-100 pr-md-5 pr-0">
	                    <?
	                    if ($showDescription)
						{
							?>
							<div class="product-item-detail-tab-content active"
								data-entity="tab-container"
								data-value="description"
								itemprop="description">
								<?
								if (
									$arResult['PREVIEW_TEXT'] != ''
									&& (
										$arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
										|| ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
									)
								)
								{
									echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>';
								}

								if ($arResult['DETAIL_TEXT'] != '')
								{
									echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>';
								}
								?>
							</div>
							<?
						}
	                    ?>
	                </div>
	                <h2 class="title-2 font-weight-800 mt-md-5 mt-4 mb-md-4 mb-2 pt-md-0 pt-1">Подробные характеристики</h2>
	                <div class="props w-100 d-flex flex-wrap pr-md-5 pr-0" data-entity="tab-container" data-value="properties">
	                	<?
	                	if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
						{
							if (!empty($arResult['DISPLAY_PROPERTIES']))
							{
								?>
									<?
									foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
									{
										?>
										<div class="name text-gray col-6 col-md-4 mb-2">
					                        <div class="row">
					                            <?=$property['NAME']?>
					                        </div>
					                    </div>
					                    <div class="value col-6 col-md-8 mb-2">
					                        <div class="row">
					                            <?=(
												is_array($property['DISPLAY_VALUE'])
													? implode(' / ', $property['DISPLAY_VALUE'])
													: $property['DISPLAY_VALUE']
												)?>
					                        </div>
					                    </div>
										<?
									}
									unset($property);
									?>
								<?
							}

							if ($arResult['SHOW_OFFERS_PROPS'])
							{
								?>
								<ul class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_PROP_DIV']?>"></ul>
								<?
							}
						}?>
	                </div>
	                <h2 class="title-2 font-weight-800 mt-md-5 mt-4 mb-md-4 mb-2 pt-md-0 pt-1" style="display: none;">Отзывы</h2>
	                <div class="props w-100 d-flex flex-wrap pr-md-5 pr-0" data-entity="tab-container" data-value="comments" style="display: none;">
	                	<?
	                	if ($arParams['USE_COMMENTS'] === 'Y')
						{
							$componentCommentsParams = array(
								'ELEMENT_ID' => $arResult['ID'],
								'ELEMENT_CODE' => '',
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
								'URL_TO_COMMENT' => '',
								'WIDTH' => '',
								'COMMENTS_COUNT' => '5',
								'BLOG_USE' => $arParams['BLOG_USE'],
								'FB_USE' => $arParams['FB_USE'],
								'FB_APP_ID' => $arParams['FB_APP_ID'],
								'VK_USE' => $arParams['VK_USE'],
								'VK_API_ID' => $arParams['VK_API_ID'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'BLOG_TITLE' => '',
								'BLOG_URL' => $arParams['BLOG_URL'],
								'PATH_TO_SMILE' => '',
								'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
								'AJAX_POST' => 'Y',
								'SHOW_SPAM' => 'Y',
								'SHOW_RATING' => 'N',
								'FB_TITLE' => '',
								'FB_USER_ADMIN_ID' => '',
								'FB_COLORSCHEME' => 'light',
								'FB_ORDER_BY' => 'reverse_time',
								'VK_TITLE' => '',
								'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
							);
							if(isset($arParams["USER_CONSENT"]))
								$componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
							if(isset($arParams["USER_CONSENT_ID"]))
								$componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
							if(isset($arParams["USER_CONSENT_IS_CHECKED"]))
								$componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
							if(isset($arParams["USER_CONSENT_IS_LOADED"]))
								$componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
							$APPLICATION->IncludeComponent(
								'bitrix:catalog.comments',
								'',
								$componentCommentsParams,
								$component,
								array('HIDE_ICONS' => 'Y')
							);
						}?>
	                </div>
	            </div>
	        </div>
	        <div class="col-12 col-md-6 mt-md-4 mt-0">
	            <div class="row">
	            	<div class="section w-100 mt-3 mt-md-0 <?if ($_POST['ajax']=='Y'){?>d-none<?}else{?>d-flex flex-wrap<?}?>">
						<div class="col">
							<?
							if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
							{
								$APPLICATION->IncludeComponent(
									'bitrix:sale.prediction.product.detail',
									'',
									array(
										'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
										'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
										'POTENTIAL_PRODUCT_TO_BUY' => array(
											'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
											'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
											'PRODUCT_PROVIDER_CLASS' => isset($arResult['~PRODUCT_PROVIDER_CLASS']) ? $arResult['~PRODUCT_PROVIDER_CLASS'] : '\Bitrix\Catalog\Product\CatalogProvider',
											'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
											'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

											'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
											'SECTION' => array(
												'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
												'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
												'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
												'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
											),
										)
									),
									$component,
									array('HIDE_ICONS' => 'Y')
								);
							}

							if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
							{
								?>
								<div data-entity="parent-container" style="display: none; opacity: 0;">
									<?
									if (!isset($arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
									{
										?>
										<h2 class="title-2 font-weight-800 mt-md-5 mt-4 mb-md-4 mb-2 pt-md-0 pt-1" data-entity="header" data-showed="false" style="display: none; opacity: 0;"><?=($arParams['GIFTS_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFT_BLOCK_TITLE_DEFAULT'))?></h2>
										<?
									}

									CBitrixComponent::includeComponentClass('bitrix:sale.products.gift');
									$APPLICATION->IncludeComponent('bitrix:sale.products.gift', 'bootstrap_v4', array(
										'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
										'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
										'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],

										'PRODUCT_ROW_VARIANTS' => "",
										'PAGE_ELEMENT_COUNT' => 0,
										'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
											SaleProductsGiftComponent::predictRowVariants(
												$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
												$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']
											)
										),
										'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],

										'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
										'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
										'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
										'PRODUCT_DISPLAY_MODE' => 'Y',
										'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],
										'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
										'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
										'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

										'TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],

										'LABEL_PROP_'.$arParams['IBLOCK_ID'] => array(),
										'LABEL_PROP_MOBILE_'.$arParams['IBLOCK_ID'] => array(),
										'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

										'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
										'MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
										'MESS_BTN_ADD_TO_BASKET' => $arParams['~GIFTS_MESS_BTN_BUY'],
										'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
										'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],

										'SHOW_PRODUCTS_'.$arParams['IBLOCK_ID'] => 'Y',
										'PROPERTY_CODE_'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE'],
										'PROPERTY_CODE_MOBILE'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE_MOBILE'],
										'PROPERTY_CODE_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
										'OFFER_TREE_PROPS_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
										'CART_PROPERTIES_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFERS_CART_PROPERTIES'],
										'ADDITIONAL_PICT_PROP_'.$arParams['IBLOCK_ID'] => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
										'ADDITIONAL_PICT_PROP_'.$arResult['OFFERS_IBLOCK'] => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),

										'HIDE_NOT_AVAILABLE' => 'Y',
										'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
										'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
										'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
										'PRICE_CODE' => $arParams['PRICE_CODE'],
										'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
										'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
										'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
										'BASKET_URL' => $arParams['BASKET_URL'],
										'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
										'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
										'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
										'USE_PRODUCT_QUANTITY' => 'N',
										'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
										'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
										'POTENTIAL_PRODUCT_TO_BUY' => array(
											'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
											'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
											'PRODUCT_PROVIDER_CLASS' => isset($arResult['~PRODUCT_PROVIDER_CLASS']) ? $arResult['~PRODUCT_PROVIDER_CLASS'] : '\Bitrix\Catalog\Product\CatalogProvider',
											'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
											'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

											'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
												? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID']
												: null,
											'SECTION' => array(
												'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
												'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
												'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
												'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
											),
										),

										'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
										'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
										'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
									),
										$component,
										array('HIDE_ICONS' => 'Y')
									);
									?>
								</div>
								<?
							}

							if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
							{
								?>
								<div data-entity="parent-container">
									<?
									if (!isset($arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
									{
										?>
										<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
											<?=($arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFTS_MAIN_BLOCK_TITLE_DEFAULT'))?>
										</div>
										<?
									}

									$APPLICATION->IncludeComponent('bitrix:sale.gift.main.products', 'bootstrap_v4',
										array(
											'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
											'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
											'LINE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
											'HIDE_BLOCK_TITLE' => 'Y',
											'BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

											'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
											'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],

											'AJAX_MODE' => $arParams['AJAX_MODE'],
											'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
											'IBLOCK_ID' => $arParams['IBLOCK_ID'],

											'ELEMENT_SORT_FIELD' => 'ID',
											'ELEMENT_SORT_ORDER' => 'DESC',
											//'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
											//'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
											'FILTER_NAME' => 'searchFilter',
											'SECTION_URL' => $arParams['SECTION_URL'],
											'DETAIL_URL' => $arParams['DETAIL_URL'],
											'BASKET_URL' => $arParams['BASKET_URL'],
											'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
											'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
											'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],

											'CACHE_TYPE' => $arParams['CACHE_TYPE'],
											'CACHE_TIME' => $arParams['CACHE_TIME'],

											'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
											'SET_TITLE' => $arParams['SET_TITLE'],
											'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
											'PRICE_CODE' => $arParams['PRICE_CODE'],
											'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
											'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

											'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
											'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
											'CURRENCY_ID' => $arParams['CURRENCY_ID'],
											'HIDE_NOT_AVAILABLE' => 'Y',
											'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
											'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
											'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],

											'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
											'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
											'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

											'ADD_PICT_PROP' => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
											'LABEL_PROP' => (isset($arParams['LABEL_PROP']) ? $arParams['LABEL_PROP'] : ''),
											'LABEL_PROP_MOBILE' => (isset($arParams['LABEL_PROP_MOBILE']) ? $arParams['LABEL_PROP_MOBILE'] : ''),
											'LABEL_PROP_POSITION' => (isset($arParams['LABEL_PROP_POSITION']) ? $arParams['LABEL_PROP_POSITION'] : ''),
											'OFFER_ADD_PICT_PROP' => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),
											'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : ''),
											'SHOW_DISCOUNT_PERCENT' => (isset($arParams['SHOW_DISCOUNT_PERCENT']) ? $arParams['SHOW_DISCOUNT_PERCENT'] : ''),
											'DISCOUNT_PERCENT_POSITION' => (isset($arParams['DISCOUNT_PERCENT_POSITION']) ? $arParams['DISCOUNT_PERCENT_POSITION'] : ''),
											'SHOW_OLD_PRICE' => (isset($arParams['SHOW_OLD_PRICE']) ? $arParams['SHOW_OLD_PRICE'] : ''),
											'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
											'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
											'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
											'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
											'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
											'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
											'DISPLAY_COMPARE' => (isset($arParams['DISPLAY_COMPARE']) ? $arParams['DISPLAY_COMPARE'] : ''),
											'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
										)
										+ array(
											'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
												? $arResult['ID']
												: $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
											'SECTION_ID' => $arResult['SECTION']['ID'],
											'ELEMENT_ID' => $arResult['ID'],

											'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
											'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
											'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
										),
										$component,
										array('HIDE_ICONS' => 'Y')
									);
									?>
								</div>
								<?
							}
							?>
						</div>
					</div>	
	                <h2 class="title-2 font-weight-800 mt-md-5 mt-4 mb-md-4 mb-2 pt-md-0 pt-1">С этим товаром рекомендуют</h2>
	                <div class="section w-100 d-flex flex-wrap mt-3 mt-md-0">
	                    <div class="position-relative d-block w-100">
	                        <?
                            $APPLICATION->IncludeComponent(
								"bitrix:catalog.section", 
								"recommended.element", 
								array(
									"COMPONENT_TEMPLATE" => "recommended.element",
									"IBLOCK_TYPE" => "catalog",
									"IBLOCK_ID" => "3",
									"SECTION_ID" => $_REQUEST["SECTION_ID"],
									"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
									"SECTION_USER_FIELDS" => array(
										0 => "",
										1 => "",
										),
									"FILTER_NAME" => "arrFilter",
									"INCLUDE_SUBSECTIONS" => "Y",
									"SHOW_ALL_WO_SECTION" => "Y",
									"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":{\"1\":{\"CLASS_ID\":\"CondIBProp:3:24\",\"DATA\":{\"logic\":\"Equal\",\"value\":4}}}}",
									"HIDE_NOT_AVAILABLE" => "Y",
									"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
									'ELEMENT_SORT_FIELD' => 'rand',
									'ELEMENT_SORT_ORDER' => '',
									'ELEMENT_SORT_FIELD2' => '',
									'ELEMENT_SORT_ORDER2' => '',
									"PAGE_ELEMENT_COUNT" => "8",
									"LINE_ELEMENT_COUNT" => "3",
									"OFFERS_LIMIT" => "5",
									"BACKGROUND_IMAGE" => "-",
									"TEMPLATE_THEME" => "blue",
									"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
									"ENLARGE_PRODUCT" => "STRICT",
									"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
									"SHOW_SLIDER" => "Y",
									"SLIDER_INTERVAL" => "3000",
									"SLIDER_PROGRESS" => "N",
									"ADD_PICT_PROP" => "-",
									"LABEL_PROP" => array(
										),
									"PRODUCT_SUBSCRIPTION" => "Y",
									"SHOW_DISCOUNT_PERCENT" => "Y",
									"SHOW_OLD_PRICE" => "Y",
									"SHOW_MAX_QUANTITY" => "N",
									"SHOW_CLOSE_POPUP" => "Y",
									"MESS_BTN_BUY" => "Купить",
									"MESS_BTN_ADD_TO_BASKET" => "В корзину",
									"MESS_BTN_SUBSCRIBE" => "Подписаться",
									"MESS_BTN_DETAIL" => "Подробнее",
									"MESS_NOT_AVAILABLE" => "Нет в наличии",
									"RCM_TYPE" => "personal",
									"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
									"SHOW_FROM_SECTION" => "N",
									"SECTION_URL" => "",
									"DETAIL_URL" => "",
									"SECTION_ID_VARIABLE" => "SECTION_ID",
									"SEF_MODE" => "N",
									"AJAX_MODE" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "Y",
									"AJAX_OPTION_HISTORY" => "N",
									"AJAX_OPTION_ADDITIONAL" => "",
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "36000000",
									"CACHE_GROUPS" => "Y",
									"SET_TITLE" => "N",
									"SET_BROWSER_TITLE" => "N",
									"BROWSER_TITLE" => "-",
									"SET_META_KEYWORDS" => "N",
									"META_KEYWORDS" => "-",
									"SET_META_DESCRIPTION" => "N",
									"META_DESCRIPTION" => "-",
									"SET_LAST_MODIFIED" => "N",
									"USE_MAIN_ELEMENT_SECTION" => "Y",
									"ADD_SECTIONS_CHAIN" => "N",
									"CACHE_FILTER" => "N",
									"ACTION_VARIABLE" => "action",
									"PRODUCT_ID_VARIABLE" => "id",
									"PRICE_CODE" => $arParams['PRICE_CODE'],
									"USE_PRICE_COUNT" => "N",
									"SHOW_PRICE_COUNT" => "1",
									"PRICE_VAT_INCLUDE" => "Y",
									"CONVERT_CURRENCY" => "N",
									"BASKET_URL" => "/personal/cart/",
									"USE_PRODUCT_QUANTITY" => "N",
									"PRODUCT_QUANTITY_VARIABLE" => "quantity",
									"ADD_PROPERTIES_TO_BASKET" => "Y",
									"PRODUCT_PROPS_VARIABLE" => "prop",
									"PARTIAL_PRODUCT_PROPERTIES" => "N",
									"ADD_TO_BASKET_ACTION" => "ADD",
									"DISPLAY_COMPARE" => "N",
									"USE_ENHANCED_ECOMMERCE" => "Y",
									"PAGER_TEMPLATE" => ".default",
									"DISPLAY_TOP_PAGER" => "N",
									"DISPLAY_BOTTOM_PAGER" => "N",
									"PAGER_TITLE" => "Товары",
									"PAGER_SHOW_ALWAYS" => "N",
									"PAGER_DESC_NUMBERING" => "N",
									"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
									"PAGER_SHOW_ALL" => "N",
									"PAGER_BASE_LINK_ENABLE" => "N",
									"LAZY_LOAD" => "N",
									"LOAD_ON_SCROLL" => "N",
									"SET_STATUS_404" => "Y",
									"SHOW_404" => "N",
									"MESSAGE_404" => "",
									"COMPATIBLE_MODE" => "Y",
									"DISABLE_INIT_JS_IN_COMPONENT" => "N",
									"SEF_RULE" => "#SECTION_CODE#",
									"SECTION_CODE_PATH" => "",
									"DISCOUNT_PERCENT_POSITION" => "bottom-right",
									"COMPOSITE_FRAME_MODE" => "A",
									"COMPOSITE_FRAME_TYPE" => "AUTO",
									"DATA_LAYER_NAME" => "dataLayer",
									"BRAND_PROPERTY" => "-"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);
                            ?>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="item element more fix-mobile-padding w-100 <?if ($_POST['ajax']=='Y'){?>d-none<?}else{?>d-flex flex-wrap<?}?>">
			<?
			if ($arParams['BRAND_USE'] === 'Y')
			{
			 	$APPLICATION->IncludeComponent(
					'bitrix:catalog.brandblock',
					'bootstrap_v4',
					array(
						'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
						'IBLOCK_ID' => $arParams['IBLOCK_ID'],
						'ELEMENT_ID' => $arResult['ID'],
						'ELEMENT_CODE' => '',
						'PROP_CODE' => $arParams['BRAND_PROP_CODE'],
						'CACHE_TYPE' => $arParams['CACHE_TYPE'],
						'CACHE_TIME' => $arParams['CACHE_TIME'],
						'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
						'WIDTH' => '',
						'HEIGHT' => ''
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
			}
			?>
		</div>	
		<div class="item element more fix-mobile-padding w-100 <?if ($_POST['ajax']=='Y'){?>d-none<?}else{?>d-flex flex-wrap<?}?>">
			<?
			if ($haveOffers)
			{
				foreach ($arResult['JS_OFFERS'] as $offer)
				{
					$currentOffersList = array();

					if (!empty($offer['TREE']) && is_array($offer['TREE']))
					{
						foreach ($offer['TREE'] as $propName => $skuId)
						{
							$propId = (int)substr($propName, 5);

							foreach ($skuProps as $prop)
							{
								if ($prop['ID'] == $propId)
								{
									foreach ($prop['VALUES'] as $propId => $propValue)
									{
										if ($propId == $skuId)
										{
											$currentOffersList[] = $propValue['NAME'];
											break;
										}
									}
								}
							}
						}
					}

					$offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
					?>
					<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
						<meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
						<meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
						<meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
						<link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
					</span>
					<?
				}

				unset($offerPrice, $currentOffersList);
			}
			else
			{
				?>
				<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
					<meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
					<link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
				</span>
				<?
			}
			?>
			<?
			if ($haveOffers)
			{
				$offerIds = array();
				$offerCodes = array();

				$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

				foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
				{
					$offerIds[] = (int)$jsOffer['ID'];
					$offerCodes[] = $jsOffer['CODE'];

					$fullOffer = $arResult['OFFERS'][$ind];
					$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

					$strAllProps = '';
					$strMainProps = '';
					$strPriceRangesRatio = '';
					$strPriceRanges = '';

					if ($arResult['SHOW_OFFERS_PROPS'])
					{
						if (!empty($jsOffer['DISPLAY_PROPERTIES']))
						{
							foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
							{
								$current = '<li class="product-item-detail-properties-item">
							<span class="product-item-detail-properties-name">'.$property['NAME'].'</span>
							<span class="product-item-detail-properties-dots"></span>
							<span class="product-item-detail-properties-value">'.(
									is_array($property['VALUE'])
										? implode(' / ', $property['VALUE'])
										: $property['VALUE']
									).'</span></li>';
								$strAllProps .= $current;

								if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
								{
									$strMainProps .= $current;
								}
							}

							unset($current);
						}
					}

					if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
					{
						$strPriceRangesRatio = '('.Loc::getMessage(
								'CT_BCE_CATALOG_RATIO_PRICE',
								array('#RATIO#' => ($useRatio
										? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
										: '1'
									).' '.$measureName)
							).')';

						foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
						{
							if ($range['HASH'] !== 'ZERO-INF')
							{
								$itemPrice = false;

								foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
								{
									if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
									{
										break;
									}
								}

								if ($itemPrice)
								{
									$strPriceRanges .= '<dt>'.Loc::getMessage(
											'CT_BCE_CATALOG_RANGE_FROM',
											array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
										).' ';

									if (is_infinite($range['SORT_TO']))
									{
										$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
									}
									else
									{
										$strPriceRanges .= Loc::getMessage(
											'CT_BCE_CATALOG_RANGE_TO',
											array('#TO#' => $range['SORT_TO'].' '.$measureName)
										);
									}

									$strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
								}
							}
						}

						unset($range, $itemPrice);
					}

					$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
					$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
					$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
					$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
				}

				$templateData['OFFER_IDS'] = $offerIds;
				$templateData['OFFER_CODES'] = $offerCodes;
				unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

				$jsParams = array(
					'CONFIG' => array(
						'USE_CATALOG' => $arResult['CATALOG'],
						'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
						'SHOW_PRICE' => true,
						'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
						'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
						'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
						'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
						'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
						'OFFER_GROUP' => $arResult['OFFER_GROUP'],
						'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
						'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
						'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
						'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
						'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
						'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
						'USE_STICKERS' => true,
						'USE_SUBSCRIBE' => $showSubscribe,
						'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
						'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
						'ALT' => $alt,
						'TITLE' => $title,
						'MAGNIFIER_ZOOM_PERCENT' => 200,
						'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
						'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
						'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
							? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
							: null
					),
					'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
					'VISUAL' => $itemIds,
					'DEFAULT_PICTURE' => array(
						'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
						'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
					),
					'PRODUCT' => array(
						'ID' => $arResult['ID'],
						'ACTIVE' => $arResult['ACTIVE'],
						'NAME' => $arResult['~NAME'],
						'CATEGORY' => $arResult['CATEGORY_PATH']
					),
					'BASKET' => array(
						'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
						'BASKET_URL' => $arParams['BASKET_URL'],
						'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
						'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
						'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
					),
					'OFFERS' => $arResult['JS_OFFERS'],
					'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
					'TREE_PROPS' => $skuProps
				);
			}
			else{
				$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
				if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
				{
					?>
					<div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
						<?
						if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
						{
							foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
							{
								?>
								<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
								<?
								unset($arResult['PRODUCT_PROPERTIES'][$propId]);
							}
						}

						$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
						if (!$emptyProductProperties)
						{
							?>
							<table>
								<?
								foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
								{
									?>
									<tr>
										<td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
										<td>
											<?
											if (
												$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
												&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
											)
											{
												foreach ($propInfo['VALUES'] as $valueId => $value)
												{
													?>
													<label>
														<input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
															value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
														<?=$value?>
													</label>
													<br>
													<?
												}
											}
											else
											{
												?>
												<select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
													<?
													foreach ($propInfo['VALUES'] as $valueId => $value)
													{
														?>
														<option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
															<?=$value?>
														</option>
														<?
													}
													?>
												</select>
												<?
											}
											?>
										</td>
									</tr>
									<?
								}
								?>
							</table>
							<?
						}
						?>
					</div>
					<?
				}

				$jsParams = array(
					'CONFIG' => array(
						'USE_CATALOG' => $arResult['CATALOG'],
						'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
						'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
						'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
						'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
						'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
						'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
						'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
						'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
						'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
						'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
						'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
						'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
						'USE_STICKERS' => true,
						'USE_SUBSCRIBE' => $showSubscribe,
						'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
						'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
						'ALT' => $alt,
						'TITLE' => $title,
						'MAGNIFIER_ZOOM_PERCENT' => 200,
						'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
						'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
						'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
							? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
							: null
						),
					'VISUAL' => $itemIds,
					'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
					'PRODUCT' => array(
						'ID' => $arResult['ID'],
						'ACTIVE' => $arResult['ACTIVE'],
						'PICT' => reset($arResult['MORE_PHOTO']),
						'NAME' => $arResult['~NAME'],
						'SUBSCRIPTION' => true,
						'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
						'ITEM_PRICES' => $arResult['ITEM_PRICES'],
						'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
						'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
						'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
						'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
						'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
						'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
						'SLIDER' => $arResult['MORE_PHOTO'],
						'CAN_BUY' => $arResult['CAN_BUY'],
						'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
						'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
						'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
						'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
						'CATEGORY' => $arResult['CATEGORY_PATH']
						),
					'BASKET' => array(
						'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
						'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
						'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
						'EMPTY_PROPS' => $emptyProductProperties,
						'BASKET_URL' => $arParams['BASKET_URL'],
						'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
						'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
						)
				);
				unset($emptyProductProperties);
			}

			if ($arParams['DISPLAY_COMPARE'])
			{
				$jsParams['COMPARE'] = array(
					'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
					'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
					'COMPARE_PATH' => $arParams['COMPARE_PATH']
				);
			}
			?>
		</div>
	</div>
</div>
<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
		BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
	});

	var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?
unset($actualItem, $itemIds, $jsParams);