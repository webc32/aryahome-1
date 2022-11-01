<?
if (is_array($arResult["GRID"]["ROWS"])) {
    usort($arResult["GRID"]["ROWS"], 'CMax::cmpByID');
    $arImages = array();
    $link_services = array();
    $raznicaByDefaultSkidka = 0;
    $totalRaznica = 0;
    $sumPriceWithoutDicsount = 0;
    $arResult['HAS_CUSTOM_SKIDKA'] = false;


    usort($arResult["GRID"]["ROWS"], function($a, $b){
        if($a['SORT'] === $b['SORT'])
            return 0;

        return $a['SORT'] > $b['SORT'] ? 1 : -1;
    });


    foreach ($arResult["GRID"]["ROWS"] as $key => $arItem) {

        if (!$arItem['DISCOUNT_PRICE']) {

            $db_res = CPrice::GetList(
                array(),
                array(
                    "PRODUCT_ID" => $arItem['PRODUCT_ID'],
                    "CATALOG_GROUP_ID" => '7'
                )
            );

            if ($ar_res = $db_res->Fetch()) {
                $oldPrice = $ar_res["PRICE"];
                $oldPrice = round($oldPrice);
                $oldPrice = floor($oldPrice);


                $oldPriceFull = $arItem['QUANTITY'] * $oldPrice;
                $raznicaByOldBrice = $oldPriceFull - ($arItem['PRICE'] * $arItem['QUANTITY']);

                $totalRaznica += $raznicaByOldBrice;

                $sumPriceWithoutDicsount += $oldPriceFull;

                $raznicaByOldBriceFormated = CurrencyFormat($raznicaByOldBrice, $arItem['CURRENCY']);
                $oldPriceFull = CurrencyFormat($oldPriceFull, $arItem['CURRENCY']);

                $skidkaByOldPrice = (($arItem['PRICE'] - $oldPrice) / $oldPrice) * 100;
                $skidkaByOldPrice = round($skidkaByOldPrice);
                $skidkaByOldPrice = floor($skidkaByOldPrice);

                if (abs($skidkaByOldPrice)>0) {
                    $arResult["GRID"]["ROWS"][$key]['SHOW_DISCOUNT_BY_OLD_PRICE'] = true;
                    $arResult["GRID"]["ROWS"][$key]['OLD_PRICE_FULL'] = $oldPriceFull;
                    $arResult["GRID"]["ROWS"][$key]['OLD_PRICE_STATIC'] = CurrencyFormat($oldPrice, $arItem['CURRENCY']);
                    $arResult["GRID"]["ROWS"][$key]['SKIDKDA_PERCENT_BY_OLD_PRICE'] = $skidkaByOldPrice;
                    $arResult["GRID"]["ROWS"][$key]['RAZNICA_BY_OLD_PRICE_FORMATED'] = $raznicaByOldBriceFormated;

                    $arResult['HAS_CUSTOM_SKIDKA'] = true;
                }
            }
        } else {
            $skidka = (($arItem['PRICE'] - $arItem['FULL_PRICE']) / $arItem['FULL_PRICE']) * 100;
            $skidka = round($skidka);
            $skidka = floor($skidka);

            $arResult["GRID"]["ROWS"][$key]['PERCENT_SKIDKA'] = $skidka;

            $raznicaByDefaultSkidka += $arItem['DISCOUNT_PRICE'] * $arItem['QUANTITY'];

            $arResult["GRID"]["ROWS"][$key]['RAZNICA'] = CurrencyFormat($raznicaByDefaultSkidka, $arItem['CURRENCY']);

            $sumPriceWithoutDicsount += $arItem['SUM_FULL_PRICE'];
        }


        // общая разница

        $totalRaznica += $arItem['DISCOUNT_PRICE'] * $arItem['QUANTITY'];

        // fix bitrix measure bug
        if (!isset($arItem["MEASURE"]) && !isset($arItem["MEASURE_RATIO"]) && strlen($arItem["MEASURE_TEXT"])) {
            $arResult["GRID"]["ROWS"][$key]["MEASURE_RATIO"] = 1;
        }

        //fix image size
        if (isset($arItem["PREVIEW_PICTURE"]) && intval($arItem["PREVIEW_PICTURE"]) > 0) {
            $arImage = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
            if ($arImage) {
                $arFileTmp = CFile::ResizeImageGet($arImage, array("width" => $arParams["PICTURE_WIDTH"], "height" => $arParams["PICTURE_HEIGHT"]), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                $picture = array();
                foreach ($arFileTmp as $name => $value) {
                    $picture[strToUpper($name)] = $value;
                }
                $arResult["GRID"]["ROWS"][$key]["PREVIEW_PICTURE"] = $picture;
            }
        }
        if (isset($arItem["DETAIL_PICTURE"]) && intval($arItem["DETAIL_PICTURE"]) > 0) {
            $arImage = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);
            if ($arImage) {
                $arFileTmp = CFile::ResizeImageGet($arImage, array("width" => $arParams["PICTURE_WIDTH"], "height" => $arParams["PICTURE_HEIGHT"]), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                $picture = array();
                foreach ($arFileTmp as $name => $value) {
                    $picture[strToUpper($name)] = $value;
                }
                $arResult["GRID"]["ROWS"][$key]["DETAIL_PICTURE"] = $picture;
            }
        }
        if (strpos($arItem["PRODUCT_XML_ID"], "#") !== false) {
            $arXmlID = explode("#", $arItem["PRODUCT_XML_ID"]);
            $arItem1 = CMaxCache::CIBLockElement_GetList(array('CACHE' => array("MULTI" => "N", "TAG" => CMaxCache::GetIBlockCacheTag($arItem["IBLOCK_ID"]))), array("IBLOCK_ID" => $arItem["IBLOCK_ID"], "ACTIVE" => "Y", "ACTIVE_DATE" => "Y", "XML_ID" => $arXmlID[0]), false, false, array("ID", "IBLOCK_ID"));
            $arResult["GRID"]["ROWS"][$key]["IBLOCK_ID"] = $arItem1["IBLOCK_ID"];
            $arResult["ITEMS_IBLOCK_ID"] = $arItem1["IBLOCK_ID"];
        }

        /*fill buy services array */
        if ($arItem["PROPS"]) {
            $arPropsByCode = array_column($arItem["PROPS"], NULL, "CODE");
            $isServices = isset($arPropsByCode["ASPRO_BUY_PRODUCT_ID"]) && $arPropsByCode["ASPRO_BUY_PRODUCT_ID"]["VALUE"] > 0;
            $services_info = array();
            if ($isServices) {
                $arResult["GRID"]["BUY_SERVICES"]['SERVICES'][$arItem["ID"]] = $arPropsByCode["ASPRO_BUY_PRODUCT_ID"]["VALUE"];
                $services_info['BASKET_ID'] = $arItem["ID"];
                $services_info['PRODUCT_ID'] = $arItem["PRODUCT_ID"];
                $services_info['QUANTITY'] = $arItem["QUANTITY"];
                $services_info['PRICE_FORMATED'] = $arItem["PRICE_FORMATED"];
                $services_info['FULL_PRICE_FORMATED'] = $arItem["FULL_PRICE_FORMATED"];
                $services_info['SUM_FORMATED'] = $arItem["SUM"];
                $services_info['SUM_FULL_PRICE_FORMATED'] = $arItem["SUM_FULL_PRICE_FORMATED"];
                $services_info['NEED_SHOW_OLD_SUM'] = $arItem["SUM_DISCOUNT_PRICE"] > 0 ? 'Y' : 'N';
                $services_info['CURRENCY'] = $arItem["CURRENCY"];
                $link_services[$arPropsByCode["ASPRO_BUY_PRODUCT_ID"]["VALUE"]][$arItem["PRODUCT_ID"]] = $services_info;
            }
        }
        /**/
    }

    if ($totalRaznica > 0) {

        $arResult['TOTAL_RAZNICA_FORMATED'] = CurrencyFormat($totalRaznica, $arResult['CURRENCY']);

        // $totalSkidka = (($arResult['allSum'] - $sumPriceWithoutDicsount) / $sumPriceWithoutDicsount) * 100;
        $totalSkidka = (($totalRaznica * 100) / $sumPriceWithoutDicsount);
        $totalSkidka = round($totalSkidka);
        $totalSkidka = floor($totalSkidka);

        $arResult['TOTAL_SKIDKA'] = $totalSkidka;
        $arResult['TOTAL_SKIDKA_FORMATED'] = '-' . $totalSkidka . '%';

    }

    foreach ($arResult["GRID"]["ROWS"] as $key => $arItem) {
        if ($arImages[$key]["PREVIEW_PICTURE"]) {
            $arResult["GRID"]["ROWS"][$key]["PREVIEW_PICTURE"] = $arImages[$key]["PREVIEW_PICTURE"];
        }
        if ($arImages[$key]["DETAIL_PICTURE"]) {
            $arResult["GRID"]["ROWS"][$key]["DETAIL_PICTURE"] = $arImages[$key]["DETAIL_PICTURE"];
        }
        $symb = substr($arItem["PRICE_FORMATED"], strrpos($arItem["PRICE_FORMATED"], ' '));
        //if((int)$symb){
        $arResult["GRID"]["ROWS"][$key]["SUMM_FORMATED"] = $arItem["SUM"];
        /*}else{
            $arResult["GRID"]["ROWS"][$key]["SUMM_FORMATED"] = str_replace($symb, "", FormatCurrency($arItem["PRICE"]*$arItem["QUANTITY"], $arItem["CURRENCY"])).$symb;
        }*/

        /*fill link services add to cart*/
        if (is_array($link_services) && count($link_services) > 0) {
            //var_dump($link_services[$arItem["PRODUCT_ID"]]);
            if (isset($link_services[$arItem["PRODUCT_ID"]])) {
                $arResult["GRID"]["ROWS"][$key]["LINK_SERVICES"] = $link_services[$arItem["PRODUCT_ID"]];
            }
        }
        /**/
    }
    unset($arImages);


    $isPrice = false;
    $priceIndex = 0;
    foreach ($arResult["GRID"]["HEADERS"] as $key => $arHeader) {
        if ($arHeader["id"] == "PRICE") {
            $isPrice = true;
            $priceIndex = $key;
        }
    }

    foreach ($arResult["GRID"]["HEADERS"] as $key => $arHeader) {
        if ($arHeader["id"] == "QUANTITY" && $isPrice && $priceIndex) {
            $arResult["GRID"]["HEADERS"] = array_merge(array_slice($arResult["GRID"]["HEADERS"], 0, $priceIndex),
                array(array("id" => "SUMM", "name" => "")),
                array_slice($arResult["GRID"]["HEADERS"], $priceIndex, count($arResult["GRID"]["HEADERS"]))
            );
        }
    }

    foreach ($arResult["GRID"]["HEADERS"] as $key => $arHeader) {
        switch ($arHeader["id"]) {
            case "DELETE":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 100;
            break;
            case "NAME":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 200;
            break;
            case "DISCOUNT":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 300;
            break;
            case "PROPS":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 400;
            break;
            case "WEIGHT":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 500;
            break;
            case "PRICE":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 600;
            break;
            case "QUANTITY":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 700;
            break;
            case "SUMM":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 800;
            break;
            case "DELAY":
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 1000;
            break;
            default :
            $arResult["GRID"]["HEADERS"][$key]["SORT"] = 900;
            break;
        }

        if ($arHeader["id"] == "PREVIEW_PICTURE")
            unset($arResult["GRID"]["HEADERS"][$key]);

    }
    usort($arResult["GRID"]["HEADERS"], 'CMax::cmpBySort');


    $arNormal = array();
    $arDelay = array();
    $arSubscribe = array();
    $arNa = array();
    $arTotals = array();
    $arResult["DELAY_PRICE"]["SUMM"] = $arResult["SUBSCRIBE_PRICE"]["SUMM"] = $arResult["NA_PRICE"]["SUMM"] = 0;

    foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
        if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y") {
            $arNormal[$arItem["ID"]] = $arItem;
        }
        if ($arItem["DELAY"] == "Y" && $arItem["CAN_BUY"] == "Y") {
            $arDelay[$arItem["ID"]] = $arItem;
            $arResult["DELAY_PRICE"]["SUMM"] += $arItem["PRICE"] * $arItem["QUANTITY"];

        }
        if ($arItem["CAN_BUY"] == "N" && $arItem["SUBSCRIBE"] == "Y") {
            $arSubscribe[$arItem["ID"]] = $arItem;
            $arResult["SUBSCRIBE_PRICE"]["SUMM"] += $arItem["PRICE"] * $arItem["QUANTITY"];
        }
        if (isset($arItem["NOT_AVAILABLE"]) && $arItem["NOT_AVAILABLE"] == true) {
            $arNa[$arItem["ID"]] = $arItem;
            $arResult["NA_PRICE"]["SUMM"] += $arItem["PRICE"] * $arItem["QUANTITY"];
        }


    }

    foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader) {
        if ($arHeader["id"] == "WEIGHT") {
            $bWeightColumn = true;
        }
    }

    if ($bWeightColumn) {
        $arTotal["WEIGHT"]["NAME"] = GetMessage("SALE_TOTAL_WEIGHT");
        $arTotal["WEIGHT"]["VALUE"] = $arResult["allWeight_FORMATED"];
    }
    if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") {
        $arTotal["VAT_EXCLUDED"]["NAME"] = GetMessage("SALE_VAT_EXCLUDED");
        $arTotal["VAT_EXCLUDED"]["VALUE"] = $arResult["allSum_wVAT_FORMATED"];
        $arTotal["VAT_INCLUDED"]["NAME"] = GetMessage("SALE_VAT_INCLUDED");
        $arTotal["VAT_INCLUDED"]["VALUE"] = $arResult["allVATSum_FORMATED"];
    }
    if (doubleval($arResult["DISCOUNT_PRICE_ALL"]) > 0) {
        $arTotal["PRICE"]["NAME"] = GetMessage("SALE_TOTAL");
        $arTotal["PRICE"]["VALUES"]["ALL"] = str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"]);

        $arTotal["PRICE"]["VALUES"]["WITHOUT_DISCOUNT"] = $arResult["PRICE_WITHOUT_DISCOUNT"];

    } else {
        $arTotal["PRICE"]["NAME"] = GetMessage("SALE_TOTAL");
        $arTotal["PRICE"]["VALUES"]["ALL"] = $arResult["allSum_FORMATED"];
    }

    if ($sumPriceWithoutDicsount > 0) {
        $arResult['SUM_PRICE_WITHOUT_DISCOUNT'] = $sumPriceWithoutDicsount;
        $arResult['SUM_PRICE_WITHOUT_DISCOUNT_FORMATED'] = CurrencyFormat($sumPriceWithoutDicsount, $arResult['CURRENCY']);
        $arTotal["PRICE"]["VALUES"]["WITHOUT_DISCOUNT"] = $arResult["SUM_PRICE_WITHOUT_DISCOUNT_FORMATED"];
    }


    $arNormal["COUNT"] = count($arNormal);
    $arNormal["TOTAL"] = $arTotal;

    $arDelay["COUNT"] = count($arDelay);
    $arSubscribe["COUNT"] = count($arSubscribe);
    $arNa["COUNT"] = count($arNa);

    if ($arResult["DELAY_PRICE"]["SUMM"])
        $arResult["DELAY_PRICE"]["SUMM_FORMATED"] = CCurrencyLang::CurrencyFormat($arResult["DELAY_PRICE"]["SUMM"], CSaleLang::GetLangCurrency(SITE_ID), true);

    if ($arResult["SUBSCRIBE_PRICE"]["SUMM"])
        $arResult["SUBSCRIBE_PRICE"]["SUMM_FORMATED"] = CCurrencyLang::CurrencyFormat($arResult["SUBSCRIBE_PRICE"]["SUMM"], CSaleLang::GetLangCurrency(SITE_ID), true);

    if ($arResult["NA_PRICE"]["SUMM"])
        $arResult["NA_PRICE"]["SUMM_FORMATED"] = CCurrencyLang::CurrencyFormat($arResult["NA_PRICE"]["SUMM"], CSaleLang::GetLangCurrency(SITE_ID), true);

    $arJson = array();
    if ($arNormal["COUNT"]) {
        $arJson[] = array("AnDelCanBuy" => $arNormal);
    }
    if ($arDelay["COUNT"]) {
        $arJson[] = array("DelDelCanBuy" => $arDelay);
    }
    if ($arSubscribe["COUNT"]) {
        $arJson[] = array("ProdSubscribe" => $arSubscribe);
    }
    if ($arNa["COUNT"]) {
        $arJson[] = array("nAnCanBuy" => $arNa);
    }

    $arResult["JSON"] = $arJson;


    // Массив для искусственной сортировки
    $sizesOrder = array(
    	'XS'    => 100,
    	'S'     => 110,
    	'M'     => 120,
    	'L'     => 130,
    	'XL'    => 140,
    	'XXL'   => 150,
    	'3XL'   => 160,
    	'XXXL'  => 161,
    	'4XL'   => 170,
    	'XXXXL' => 171,
    );
    // Функция сортировки по полю ORDER
    function cmp($a, $b) {
    	return strnatcmp($a["ORDER"], $b["ORDER"]);
    }


    //цвета и размеры
    $arSku = array();
    foreach ($arResult["GRID"]["ROWS"] as $key => $row) {
        $nameForSite = "";
        $arSort= Array("NAME"=>"ASC");
        $arSelect = Array("ID","NAME","IBLOCK_ID","PROPERTY_NAIMENOVANIE_DLYA_SAYTA","PROPERTY_RAZMER","PROPERTY_TSVET","PREVIEW_PICTURE","DETAIL_PAGE_URL","PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA");
        $arFilter = Array(
            "IBLOCK_ID" => CIBlockElement::GetIBlockByID($arResult["GRID"]["ROWS"][$key]['PRODUCT_ID']),
            "ID" => $arResult["GRID"]["ROWS"][$key]['PRODUCT_ID'],
        );
        $res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
        if($ob = $res->GetNextElement()){
            $arFields = $ob->GetFields();
            $nameForSite = $arFields['PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE'];
            if($arFields['PROPERTY_RAZMER_VALUE']){
                $arResult["GRID"]["ROWS"][$key]["PROPERTY_RAZMER_VALUE"] = $arFields['PROPERTY_RAZMER_VALUE'];
            }else{
                $arResult["GRID"]["ROWS"][$key]["PROPERTY_RAZMER_VALUE"] = $arFields['PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE'];
            }
            $arResult["GRID"]["ROWS"][$key]["PROPERTY_TSVET_VALUE"] = $arFields['PROPERTY_TSVET_VALUE'];
        }

        if($nameForSite){
            $arSort= Array("NAME"=>"ASC");
            $arSelect = Array("ID","NAME","IBLOCK_ID","PROPERTY_NAIMENOVANIE_DLYA_SAYTA","PROPERTY_RAZMER","PROPERTY_TSVET","PREVIEW_PICTURE","DETAIL_PAGE_URL","PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA");
            $arFilter = Array(
                "IBLOCK_ID" => CIBlockElement::GetIBlockByID($arResult["GRID"]["ROWS"][$key]['PRODUCT_ID']),
                "PROPERTY_NAIMENOVANIE_DLYA_SAYTA" => $nameForSite,
                "ACTIVE" => "Y",
                ">=CATALOG_QUANTITY" => "1",
                "!SECTION_ID" => 0
        // "PROPERTY_TSVET" => $color
            );
            $res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
            while($ob = $res->GetNextElement()){
                $arFields = $ob->GetFields();
                if(!$arResult["GRID"]["ROWS"][$key]['CUSTOM_SKU'][$arFields["PROPERTY_TSVET_VALUE"]]){
                    $arResult["GRID"]["ROWS"][$key]['CUSTOM_SKU'][$arFields["PROPERTY_TSVET_VALUE"]] = array(
                        "PRODUCT_ID" => $arFields['ID'],
                        "SRC" => CFile::GetPath($arFields["PREVIEW_PICTURE"]),
                        "NAME_COLOR" => $arFields["PROPERTY_TSVET_VALUE"],
                    );
                }

                if(!$arFields["PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE"]){
                    $arFields["PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE"] = $arFields["PROPERTY_RAZMER_VALUE"];
                }
                if(!$arFields["PROPERTY_RAZMER_VALUE"]){
                    $arFields["PROPERTY_RAZMER_VALUE"] = $arFields["PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE"];
                }

                if($arFields["PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE"]){
                    $arResult["GRID"]["ROWS"][$key]['CUSTOM_SKU'][$arFields["PROPERTY_TSVET_VALUE"]]["SIZE"][] = 
                    array(
                        "PRODUCT_ID" => $arFields['ID'],
                        "RAZMER" => $arFields["PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE"],
                        "COLOR" => $arFields["PROPERTY_TSVET_VALUE"],
                        "SELECTED" => ($arResult["GRID"]["ROWS"][$key]["PROPERTY_RAZMER_VALUE"] == $arFields["PROPERTY_RAZMER_VALUE"]),

                        // Присваем индексы для дальнейшей сортировки
                        "ORDER" => array_key_exists($arFields["PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE"], $sizesOrder) ?  $sizesOrder[$arFields["PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA_VALUE"]] : 0,
                    );
                }
            }

            foreach ($arResult["GRID"]["ROWS"][$key]['CUSTOM_SKU'] as &$value) {
                $selected = ($value["NAME_COLOR"] == $arResult["GRID"]["ROWS"][$key]["PROPERTY_TSVET_VALUE"]);
                $value['SELECTED'] = $selected;

                usort($value['SIZE'], "cmp");
            }
            $arResult["GRID"]["ROWS"][$key]['CUSTOM_SKU'] = array_values($arResult["GRID"]["ROWS"][$key]['CUSTOM_SKU']);
        }
    }
//цвета и размеры конец


}
foreach ($arResult["GRID"]["ROWS"] as &$arItem) {
    // максимальное кол-во для текущего склада
    $rsStore = CCatalogStoreProduct::GetList(
        array(),
        array('PRODUCT_ID' => $arItem['PRODUCT_ID'],'STORE_ID' => 3),
        false,
        false,
        array('AMOUNT')
    );
    if ($arStore = $rsStore->Fetch()) {
        $arItem['AVAILABLE_QUANTITY'] = $arStore['AMOUNT'];
    }
    //END максимальное кол-во для текущего склада
}


?>