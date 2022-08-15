<?php if (!empty($arResult)):

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
                if (in_array($arResult['ITEM']['PROPERTIES']['CML2_BAR_CODE']['VALUE'], $Vigodnaya)){
                    if ($arResult['ITEM']['PROPERTIES']['New']['VALUE_XML_ID'] == 'yes') {
                        ?>
                        <div class="label new position-absolute big-ellipse bg-red text-white Montserrat font-weight-bold d-flex align-items-center justify-content-center text-uppercase">
                            New
                        </div>
                        <? 
                    } 
                }
            ?>
            <div class="addtofavorite d-md-none d-block" onclick="formtofavorite(this);">
                <svg fill="#E1E1E1" width="23" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.7151 1.959C19.5503 0.695744 17.9522 0 16.2146 0C14.9158 0 13.7264 0.410614 12.6793 1.22034C12.1509 1.62907 11.6721 2.12912 11.25 2.71276C10.8281 2.12929 10.3491 1.62907 9.82058 1.22034C8.77361 0.410614 7.58417 0 6.28538 0C4.54782 0 2.94949 0.695744 1.78476 1.959C0.633945 3.20749 0 4.91312 0 6.76191C0 8.66478 0.709133 10.4066 2.2316 12.2437C3.59356 13.8871 5.55101 15.5553 7.8178 17.487C8.59182 18.1467 9.46918 18.8944 10.3802 19.6909C10.6209 19.9017 10.9297 20.0178 11.25 20.0178C11.5701 20.0178 11.8791 19.9017 12.1195 19.6913C13.0305 18.8946 13.9083 18.1465 14.6827 17.4865C16.9492 15.5551 18.9066 13.8871 20.2686 12.2436C21.791 10.4066 22.5 8.66478 22.5 6.76174C22.5 4.91312 21.8661 3.20749 20.7151 1.959Z"/>
                </svg>
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
        <div class="text-center mt-3">
            <a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>" class="d-block"><?=$name?></a>
        </div>
        <div class="d-flex w-100 mt-3 justify-content-between">
            <div class="d-flex flex-wrap justify-content-center w-100">
                <a href="#" onclick="formtobasket(this);return false" class="addtobasket btn text-uppercase round d-flex align-items-center bg-active text-white font-weight-500 py-2 px-3" id="bx_117848907_14783_buy_link">
                    <svg fill="white" width="25" height="21" viewBox="0 0 25 21" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 7.10838C0 6.61526 0.399746 6.21552 0.892857 6.21552H24.1071C24.6003 6.21552 25 6.61526 25 7.10838V7.24574C25 7.73885 24.6003 8.1386 24.1071 8.1386H0.892857C0.399745 8.1386 0 7.73885 0 7.24574V7.10838Z"></path>
                        <path d="M8.65278 0.446578C8.89934 0.0195306 9.4454 -0.126786 9.87245 0.119769L10.1846 0.300014C10.6117 0.546569 10.758 1.09263 10.5114 1.51968L7.1119 7.40787C6.86535 7.83492 6.31928 7.98123 5.89224 7.73468L5.58004 7.55443C5.153 7.30788 5.00668 6.76182 5.25323 6.33477L8.65278 0.446578Z"></path>
                        <path d="M16.7283 0.446578C16.4818 0.0195306 15.9357 -0.126786 15.5087 0.119769L15.1965 0.300014C14.7694 0.546569 14.6231 1.09263 14.8697 1.51968L18.2692 7.40787C18.5158 7.83492 19.0618 7.98123 19.4889 7.73468L19.8011 7.55443C20.2281 7.30788 20.3745 6.76182 20.1279 6.33477L16.7283 0.446578Z"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.06703 9.10011C2.48616 9.10011 2.05995 9.646 2.20083 10.2095L4.63902 19.9623C4.73839 20.3597 5.09551 20.6386 5.50522 20.6386H19.4956C19.9053 20.6386 20.2624 20.3597 20.3618 19.9623L22.8 10.2095C22.9409 9.646 22.5146 9.10011 21.9338 9.10011H3.06703ZM8.58503 11.0232C8.09192 11.0232 7.69217 11.4229 7.69217 11.916V16.8611C7.69217 17.3542 8.09192 17.7539 8.58503 17.7539H8.72239C9.2155 17.7539 9.61525 17.3542 9.61525 16.8611V11.916C9.61525 11.4229 9.2155 11.0232 8.72239 11.0232H8.58503ZM11.5383 11.916C11.5383 11.4229 11.938 11.0232 12.4311 11.0232H12.5685C13.0616 11.0232 13.4613 11.4229 13.4613 11.916V16.8611C13.4613 17.3542 13.0616 17.7539 12.5685 17.7539H12.4311C11.938 17.7539 11.5383 17.3542 11.5383 16.8611V11.916ZM16.2772 11.0232C15.7841 11.0232 15.3843 11.4229 15.3843 11.916V16.8611C15.3843 17.3542 15.7841 17.7539 16.2772 17.7539H16.4146C16.9077 17.7539 17.3074 17.3542 17.3074 16.8611V11.916C17.3074 11.4229 16.9077 11.0232 16.4146 11.0232H16.2772Z"></path>
                    </svg>
                    <span class="d-block ml-2">Подарок</span>
                </a>
            </div>
        </div>
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
<?php endif ?>