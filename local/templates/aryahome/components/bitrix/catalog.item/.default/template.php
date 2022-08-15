<?php if (!empty($arResult['ITEM'])):


    // echo "<div style='display:none;'><pre>";
    // print_r($arResult);
    // echo "</pre></div>";


    //Лейбл new
    $newlabel = false;

    $sectionList = \CIBlockElement::getElementGroups($arResult['ITEM']['ID'], true, array("ID","NAME"));
    while ($section = $sectionList->fetch()) {
        if ($section['NAME'] == 'НОВИНКИ') {
            $newlabel = true;
        }
    }

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
        $RC = round($RC);
        $RC = floor($RC);
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

    //Цена
    $price = $arResult['ITEM']['ITEM_PRICES'][$arResult['ITEM']['ITEM_PRICE_SELECTED']];

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
	if (empty($arResult['ITEM']['PREVIEW_PICTURE']['SRC'])){
	    $arResult['ITEM']['PREVIEW_PICTURE']['SRC'] = SITE_TEMPLATE_PATH.'/img/no-photo.svg';
	}

    if ($_GET["sort"] == "Main"){
       $O_RAZMER = array();

        if ($namecode == 'NAME') {
            $o_nameforsite = '';
            $o_name = $name;}
        else{
            $o_nameforsite = $name;
            $o_name = '';}

        if(CModule::IncludeModule('iblock')) {
            $arSort= Array("NAME"=>"ASC");
            $arSelect = Array("ID","NAME","DETAIL_PAGE_URL","PROPERTY_NAIMENOVANIE_DLYA_SAYTA","PROPERTY_RAZMER", "PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA","PROPERTY_TSVET");
            $arFilter = Array(
                "IBLOCK_ID" => array(3), 
                ">=CATALOG_QUANTITY" => "1",
                "NAME" => array($o_ame),
                "PROPERTY_NAIMENOVANIE_DLYA_SAYTA" => array($o_nameforsite), 
                "PROPERTY_TSVET" => array($arResult['ITEM']['PROPERTIES']['TSVET']['VALUE'])
            );
            $res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
            while($ob = $res->GetNextElement()){
              $arFields = $ob->GetFields();
              if (in_array($arFields['PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE'], $array)) {
                if ($arFields['PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE'] != $RAZMER) {
                    $O_RAZMER[] = $arFields['PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE'];
                }
              }else{
                if ($arFields['PROPERTY_RAZMER_VALUE'] != $RAZMER) {
                    $O_RAZMER[] = $arFields['PROPERTY_RAZMER_VALUE'];
                }}
            }
        }
    }
	?>
    <div class="item"
        data-name="<?=$name?>"
        data-name-code="<?=$namecode?>"
        data-id="<?=$arResult['ITEM']['ID']?>"
        data-price="<?=$RCC?>"
        data-color="<?=$arResult['ITEM']['PROPERTIES']['TSVET']['VALUE']?>"
        data-preview="<?=$arResult['ITEM']['PREVIEW_PICTURE']['SRC']?>"
        data-size="<?=$RAZMER?>"
        data-size-code="<?=$RAZMERCODE?>">

        <? if (empty($arParams['HIDE_MICRODATA']) || $arParams['HIDE_MICRODATA'] != 'Y'): ?>
            <!-- Микроразметка -->
            <div itemtype="http://schema.org/Offer" itemscope>
                <meta itemprop="name" content="<?=$name?>" />
                <link itemprop="image" href="<?=$arResult['ITEM']['PREVIEW_PICTURE']['SRC']?>">
                <link itemprop="url" href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>">
                <meta itemprop="price" content="<?=$RCC?>">
                <meta itemprop="priceCurrency" content="RUB"/>
            </div>
        <? endif; ?>

        <div class="images lazy text-center position-relative w-100">
            <?  
                if ($arResult['ITEM']['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Желтый') {
                    ?>
                    <div class="label new position-absolute big-ellipse bg-red text-white Montserrat font-weight-bold d-flex align-items-center justify-content-center text-uppercase">
                        New
                    </div>
                    <? 
                }
                elseif($arResult['ITEM']['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Зеленый') {
                    ?>
                    <div class="label new position-absolute big-ellipse bg-green text-white Montserrat font-weight-bold d-flex align-items-center justify-content-center text-uppercase">
                        <span class="title-3">%</span>
                    </div>
                    <? 
                }
                elseif($arResult['ITEM']['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Оранжеый') {
                    ?>
                    <div class="label new position-absolute big-ellipse bg-orange text-white Montserrat font-weight-bold d-flex align-items-center justify-content-center text-uppercase">
                        <span class="title-3">%</span>
                    </div>
                    <? 
                }
            ?>
            <div class="addtofavorite d-md-none d-block" onclick="formtofavorite(this);">
                <svg fill="#E1E1E1" width="23" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.7151 1.959C19.5503 0.695744 17.9522 0 16.2146 0C14.9158 0 13.7264 0.410614 12.6793 1.22034C12.1509 1.62907 11.6721 2.12912 11.25 2.71276C10.8281 2.12929 10.3491 1.62907 9.82058 1.22034C8.77361 0.410614 7.58417 0 6.28538 0C4.54782 0 2.94949 0.695744 1.78476 1.959C0.633945 3.20749 0 4.91312 0 6.76191C0 8.66478 0.709133 10.4066 2.2316 12.2437C3.59356 13.8871 5.55101 15.5553 7.8178 17.487C8.59182 18.1467 9.46918 18.8944 10.3802 19.6909C10.6209 19.9017 10.9297 20.0178 11.25 20.0178C11.5701 20.0178 11.8791 19.9017 12.1195 19.6913C13.0305 18.8946 13.9083 18.1465 14.6827 17.4865C16.9492 15.5551 18.9066 13.8871 20.2686 12.2436C21.791 10.4066 22.5 8.66478 22.5 6.76174C22.5 4.91312 21.8661 3.20749 20.7151 1.959Z"/>
                </svg>
            </div>
            <div class="d-none d-md-flex z-index-2 position-absolute justify-content-center align-items-center w-100 h-100">
	        	<div class="quickview position-absolute justify-content-center font-weight-500 text-white py-3" onclick="AjaxCatalogElement(this);">
	                Быстрый просмотр
	            </div>
	             <a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>" class="z-index-2 bg-dark w-100 h-100"></a>
            </div>
            <a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>" class="position-absolute z-index-2 w-100 h-100 d-block d-md-none"></a>
            <a href="<?=$arResult['ITEM']['PREVIEW_PICTURE']['SRC']?>" class="progressive replace position-absolute">
            	<img loading="lazy" src="" alt="<?=$name?>" class="preview">
            	<div class="padding loading"></div>
            </a>
            <?php if (!empty($RAZMER)): ?>
                <div class="label size d-flex position-absolute">
                    <div class="bestseller bg-light text-gold text-center font-weight-500 border-gold px-1 mb-1 mr-1">
                        <?=$RAZMER?>
                    </div>
                    <?if ($_GET["sort"] == "Main"){
                        foreach ($O_RAZMER as $key => $value) {
                        ?>
                            <div class="bestseller bg-light text-gold text-center font-weight-500 border-gold px-1 mb-1 mr-1">
                                <?=$value?>
                            </div>
                        <?
                        }
                    }?>
                </div>
            <?php endif ?>
        </div>
        <div class="product-name mt-3">
            <a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>" class="d-block"><?=$name?></a>
        </div>
        <?php if (!empty($RCC)): ?>
            <div class="d-flex w-100 mt-3 justify-content-between">
                <div class="price flex-grow-1">
                    <span class="current <?if($arResult['ITEM']['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Красный'){?>text-red<?}?> d-block mb-md-1">
                        <?=$price['PRINT_RATIO_PRICE']?>
                    </span>
                    <?php if ($RCC < $RC): ?>
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="old font-weight-500 text-gray mr-2">
                                <del><?=CurrencyFormat($RC, $ar_res["CURRENCY"])?></del>
                            </span>
                            <span class="discount font-weight-500 text-red <?if ($arResult['ITEM']['PROPERTIES']['TSVET_TSENNIKA']['VALUE'] == 'Красный'){?>d-none<?}else{?>d-inline<?}?>">
                                <?
                                $skidka = (($price['RATIO_PRICE'] - $RC)/$RC)*100;
                                $skidka = round($skidka);
                                $skidka = floor($skidka);
                                ?>
                                <span class="d-md-inline d-none">Скидка:</span> <?=$skidka?>%
                            </span>
                        </div>
                    <?php endif ?>  
                </div>
                <div class="d-flex flex-wrap justify-content-end">
                    <a href="" class="addtofavorite d-md-inline d-none" onclick="formtofavorite(this);return false">
                        <svg fill="#E3DDDD" width="28" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.1754 2.00253C19.9848 0.711205 18.3511 0 16.5749 0C15.2473 0 14.0314 0.419739 12.961 1.24746C12.4209 1.66527 11.9315 2.17643 11.5 2.77305C11.0687 2.17661 10.5791 1.66527 10.0388 1.24746C8.96858 0.419739 7.75271 0 6.42506 0C4.64889 0 3.01503 0.711205 1.82442 2.00253C0.648033 3.27877 0 5.0223 0 6.91218C0 8.85733 0.724892 10.6379 2.28119 12.5158C3.67342 14.1957 5.67437 15.9009 7.99153 17.8756C8.78275 18.5499 9.67961 19.3143 10.6109 20.1285C10.8569 20.344 11.1726 20.4626 11.5 20.4626C11.8273 20.4626 12.1431 20.344 12.3888 20.1289C13.32 19.3145 14.2174 18.5498 15.009 17.875C17.3258 15.9008 19.3268 14.1957 20.719 12.5157C22.2753 10.6379 23 8.85733 23 6.912C23 5.0223 22.352 3.27877 21.1754 2.00253Z"/>
                        </svg>
                    </a>
                    <?if (!empty($RCC)){?>
                        <a href="" class="addtobasket ml-3 d-md-inline d-none" onclick="formtobasket(this);return false">
                            <svg fill="#D0A550" width="28" height="24" viewBox="0 0 28 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 7.96138C0 7.4091 0.447715 6.96138 1 6.96138H27C27.5523 6.96138 28 7.4091 28 7.96138V8.11523C28 8.66751 27.5523 9.11523 27 9.11523H1C0.447715 9.11523 0 8.66751 0 8.11523V7.96138Z"/>
                                <path d="M9.69112 0.500167C9.96726 0.0218743 10.5788 -0.142001 11.0571 0.134142L11.4068 0.336015C11.8851 0.612158 12.049 1.22375 11.7728 1.70204L7.96533 8.29681C7.68919 8.77511 7.0776 8.93898 6.5993 8.66284L6.24965 8.46097C5.77136 8.18482 5.60748 7.57323 5.88362 7.09494L9.69112 0.500167Z"/>
                                <path d="M18.7358 0.500167C18.4596 0.0218743 17.848 -0.142001 17.3697 0.134142L17.0201 0.336015C16.5418 0.612158 16.3779 1.22375 16.654 1.70204L20.4615 8.29681C20.7377 8.77511 21.3493 8.93898 21.8276 8.66284L22.1772 8.46097C22.6555 8.18482 22.8194 7.57323 22.5432 7.09494L18.7358 0.500167Z"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.43507 10.1921C2.7845 10.1921 2.30714 10.8035 2.46493 11.4347L5.1957 22.3577C5.30699 22.8029 5.70697 23.1152 6.16584 23.1152H21.8351C22.2939 23.1152 22.6939 22.8029 22.8052 22.3577L25.536 11.4347C25.6938 10.8035 25.2164 10.1921 24.5658 10.1921H3.43507ZM9.61523 12.3459C9.06295 12.3459 8.61523 12.7936 8.61523 13.3459V18.8844C8.61523 19.4367 9.06295 19.8844 9.61523 19.8844H9.76908C10.3214 19.8844 10.7691 19.4367 10.7691 18.8844V13.3459C10.7691 12.7936 10.3214 12.3459 9.76908 12.3459H9.61523ZM12.9229 13.3459C12.9229 12.7936 13.3706 12.3459 13.9229 12.3459H14.0767C14.629 12.3459 15.0767 12.7936 15.0767 13.3459V18.8844C15.0767 19.4367 14.629 19.8844 14.0767 19.8844H13.9229C13.3706 19.8844 12.9229 19.4367 12.9229 18.8844V13.3459ZM18.2305 12.3459C17.6782 12.3459 17.2305 12.7936 17.2305 13.3459V18.8844C17.2305 19.4367 17.6782 19.8844 18.2305 19.8844H18.3843C18.9366 19.8844 19.3843 19.4367 19.3843 18.8844V13.3459C19.3843 12.7936 18.9366 12.3459 18.3843 12.3459H18.2305Z" />
                            </svg>
                        </a>
                        <a href="" class="addtobasket d-md-none d-block" onclick="formtobasket(this);return false" data-modal="formtobasket">
                            <svg fill="#D0A550" width="37" height="37" viewBox="0 0 37 37" xmlns="http://www.w3.org/2000/svg">
                                <rect y="0.00610352" width="37" height="36.9875" rx="18.4937"/>
                                <path d="M7 15.5458C7 15.0921 7.36777 14.7244 7.82143 14.7244H29.1786C29.6322 14.7244 30 15.0921 30 15.5458V15.6722C30 16.1258 29.6322 16.4936 29.1786 16.4936H7.82143C7.36777 16.4936 7 16.1258 7 15.6722V15.5458Z" fill="white"/>
                                <path d="M14.9606 9.41695C15.1874 9.02407 15.6898 8.88946 16.0827 9.11629L16.3699 9.28212C16.7628 9.50895 16.8974 10.0113 16.6705 10.4042L13.5429 15.8213C13.3161 16.2142 12.8137 16.3488 12.4209 16.122L12.1336 15.9562C11.7408 15.7294 11.6061 15.227 11.833 14.8341L14.9606 9.41695Z" fill="white"/>
                                <path d="M22.3901 9.41695C22.1632 9.02407 21.6609 8.88946 21.268 9.11629L20.9808 9.28212C20.5879 9.50895 20.4533 10.0113 20.6801 10.4042L23.8077 15.8213C24.0345 16.2142 24.5369 16.3488 24.9298 16.122L25.217 15.9562C25.6099 15.7294 25.7445 15.227 25.5177 14.8341L22.3901 9.41695Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.82167 17.3782C9.28727 17.3782 8.89515 17.8804 9.02476 18.3989L11.2679 27.3714C11.3593 27.7371 11.6879 27.9936 12.0648 27.9936H24.9359C25.3129 27.9936 25.6414 27.7371 25.7328 27.3714L27.976 18.3989C28.1056 17.8804 27.7135 17.3782 27.1791 17.3782H9.82167ZM14.8982 19.1474C14.4446 19.1474 14.0768 19.5152 14.0768 19.9688V24.5183C14.0768 24.9719 14.4446 25.3397 14.8982 25.3397H15.0246C15.4783 25.3397 15.846 24.972 15.846 24.5183V19.9688C15.846 19.5152 15.4783 19.1474 15.0246 19.1474H14.8982ZM17.6152 19.9688C17.6152 19.5152 17.983 19.1474 18.4366 19.1474H18.563C19.0167 19.1474 19.3844 19.5152 19.3844 19.9688V24.5183C19.3844 24.972 19.0167 25.3397 18.563 25.3397H18.4366C17.983 25.3397 17.6152 24.9719 17.6152 24.5183V19.9688ZM21.975 19.1474C21.5214 19.1474 21.1536 19.5152 21.1536 19.9688V24.5183C21.1536 24.9719 21.5214 25.3397 21.975 25.3397H22.1014C22.5551 25.3397 22.9228 24.972 22.9228 24.5183V19.9688C22.9228 19.5152 22.5551 19.1474 22.1014 19.1474H21.975Z" fill="white"/>
                            </svg>
                        </a>
                    <?}?>
                </div>
            </div>
        <?php else: ?>
            Нет цены
        <?php endif ?>
        <div class="d-flex flex-wrap tags mt-2">
        	<?if ($arResult['ITEM']['PROPERTIES']['Bestseller']['VALUE_XML_ID'] == 'yes'){?>
        		<div class="bestseller bg-light text-gold text-center font-weight-500 border-gold mb-1 mr-1">
                    Хит продаж
                </div>
        	<?}?>
            <?if ($arResult['ITEM']['PROPERTIES']['Recommended']['VALUE_XML_ID'] == 'yes'){?>
                <div class="bestseller bg-light text-gold text-center font-weight-500 border-gold mb-1 mr-1">
                    Рекомендуем
                </div>
            <?}?>
        </div>
    </div>
<?php else: ?>
    <div class="my-5 title-3">
        Товаров пока нет, продолжите покупки в <a href="/catalog/" class="text-gold">других разделах</a>
    </div>
<?php endif ?>