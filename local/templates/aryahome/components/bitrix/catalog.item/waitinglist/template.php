<?
/**
 * @global CMain $APPLICATION
 * @var array $price
 */
//Цена
$db_res = CPrice::GetList(
    array(),
    array(
            "PRODUCT_ID" => $arResult['ITEM']['ID'],
            "CATALOG_GROUP_ID" => '7'
        )
    );
if ($ar_res = $db_res->Fetch())
{
    $RC = $ar_res["PRICE"];
}
// echo CurrencyFormat($RC, $ar_res["CURRENCY"]);

$db_res = CPrice::GetList(
    array(),
    array(
            "PRODUCT_ID" => $arResult['ITEM']['ID'],
            "CATALOG_GROUP_ID" => '8'
        )
    );
if ($ar_res = $db_res->Fetch())
{
    $RCC = $ar_res["PRICE"];
    $RCC = floor($RCC);
}
// echo CurrencyFormat($RCC, $ar_res["CURRENCY"]);
//Размер
$array = array(
    '1,5-спальное',
    'Евро',
    'Евро (2-спальное)',
    'Семейное',
    'Семейное (2-пододеяльника)'
);
if (in_array($arResult['ITEM']["PROPERTIES"]['OBSHCHIY_RAZMER_DLYA_SAYTA']['VALUE'], $array)){
    $RAZMER = $arResult['ITEM']["PROPERTIES"]['OBSHCHIY_RAZMER_DLYA_SAYTA']['VALUE'];
    $RAZMERCODE = "OBSHCHIY_RAZMER_DLYA_SAYTA";}
else{
    $RAZMER = $arResult['ITEM']["PROPERTIES"]['RAZMER']['VALUE'];
    $RAZMERCODE = "RAZMER";}
//Название товара
if (empty($arResult['ITEM']['PROPERTIES']['NAIMENOVANIE_DLYA_SAYTA']['VALUE'])){
    $name = $arResult['ITEM']['NAME'];}
else{
    $name = $arResult['ITEM']['PROPERTIES']['NAIMENOVANIE_DLYA_SAYTA']['VALUE'];}
//Код названия
if (empty($arResult['ITEM']['PROPERTIES']['NAIMENOVANIE_DLYA_SAYTA']['VALUE'])){
    $namecode = 'NAME';}
else{
    $namecode = 'NAIMENOVANIE_DLYA_SAYTA';}
?>
<?php if (!empty($arResult)): ?>
    <div class="item">
        <div class="images text-center position-relative">
        	<?php if ($arResult['ITEM']['PROPERTIES']['New']['VALUE_XML_ID'] == 'yes'): ?>
                <div class="label new position-absolute">
                    <div class="big-ellipse bg-red text-white Montserrat font-weight-bold d-flex align-items-center justify-content-center">NEW</div>
                </div>
       		<?php endif ?>
            <?php if (empty($arResult['ITEM']['PREVIEW_PICTURE']['SRC'])): 
                $arResult['ITEM']['PREVIEW_PICTURE']['SRC'] = SITE_TEMPLATE_PATH.'/img/no-photo.svg';
            endif ?>
            <a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>">
                <picture>
                    <?if ($arResult['ITEM']['PREVIEW_PICTURE']["SRC_WEBP"]) :?>
                        <source type="image/webp" srcset="<?=$arResult['ITEM']['PREVIEW_PICTURE']["SRC_WEBP"]?>">
                    <?endif;?>
                    <img loading="lazy" src="<?=$arResult['ITEM']['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arResult['ITEM']['PREVIEW_PICTURE']["ALT"]?>" class="w-100">
                </picture>
            </a>
            <?php if (!empty($arResult['ITEM']['PROPERTIES']['RAZMER']['VALUE'])): ?>
                <div class="label size d-flex position-absolute">
                    <div class="bestseller bg-light text-gold text-center font-weight-500 border-gold px-1 mb-1 mr-1">
                        <?=$arResult['ITEM']['PROPERTIES']['RAZMER']['VALUE']?>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <div class="product-name mt-3">
            <a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>" class="d-block"><?=$name?></a>
        </div>
        <?php if (!empty($price['PRINT_RATIO_PRICE'])): ?>
            <div class="d-flex w-100 mt-3 justify-content-between">
                <div class="price flex-grow-1">
                    <span class="current d-block mb-md-1">
                        <?=$price['PRINT_RATIO_PRICE']?>
                    </span>
                    <?php if ($price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE']): ?>
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="old font-weight-500 text-gray mr-2">
                                <del><?=$price['PRINT_RATIO_BASE_PRICE']?></del>
                            </span>
                            <span class="discount font-weight-500 text-red">
                                <span class="d-md-inline d-none">Скидка:</span> -<?=$price['PERCENT']?>%
                            </span>
                        </div>
                    <?php endif ?>  
                </div>
            </div>
        <?php else: ?>
            Нет цены
        <?php endif ?>
        <div class="d-flex flex-wrap tags mt-2">
        	<?php if ($arResult['ITEM']['PROPERTIES']['Bestseller']['VALUE_XML_ID'] == 'yes'): ?>
        		<div class="bestseller bg-light text-gold text-center font-weight-500 border-gold mb-1 mr-1">
                    Хит продаж
                </div>
        	<?php endif ?>
            <?php if ($arResult['ITEM']['PROPERTIES']['Recommended']['VALUE_XML_ID'] == 'yes'): ?>
                <div class="bestseller bg-light text-gold text-center font-weight-500 border-gold mb-1 mr-1">
                    Рекомендуем
                </div>
            <?php endif ?>
        </div>
    </div>
<?php else: ?>
    <div class="my-5 title-3">
        Товаров пока нет, продолжите покупки в <a href="/catalog/" class="text-gold">других разделах</a>
    </div>
<?php endif ?>