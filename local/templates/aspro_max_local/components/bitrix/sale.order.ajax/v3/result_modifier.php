<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

//$arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE_FORMATED'] = '2';


$totalRaznica = 0;
$sumPriceWithoutDicsount = 0;
foreach ($arResult['JS_DATA']['GRID']['ROWS'] as $basketItemID => $basketItem){

    if ($basketItem['data']['DISCOUNT_PRICE'] == 0){

        $db_res = CPrice::GetList(
            array(),
            array(
                "PRODUCT_ID" => $basketItem['data']['PRODUCT_ID'],
                "CATALOG_GROUP_ID" => '7'
            )
        );
        if ($ar_res = $db_res->Fetch()) {
            $oldPrice = $ar_res["PRICE"];
            $oldPrice = round($oldPrice);
            $oldPrice = floor($oldPrice);

            $oldPriceFull = $basketItem['data']['QUANTITY'] * $oldPrice;

            $sumPriceWithoutDicsount += $oldPriceFull;

            $raznicaByOldBrice = $oldPriceFull - $basketItem['data']['SUM_NUM'];

            $raznicaByOldBriceFormated = CurrencyFormat($raznicaByOldBrice, $basketItem['data']['CURRENCY']);
            $oldPriceFull = CurrencyFormat($oldPriceFull, $basketItem['data']['CURRENCY']);

            $totalRaznica += $raznicaByOldBrice;


        }

    }else{

        $sumPriceWithoutDicsount += $basketItem['data']['SUM_BASE'];
    }

}


$arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE'] = $arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE'] + $totalRaznica;

if ($arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE'] > 0) {

    $totalSkidka = (($arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE'] * 100) / $sumPriceWithoutDicsount);
    $totalSkidka = round($totalSkidka);
    $totalSkidka = floor($totalSkidka);
    if (abs($totalSkidka) > 0){
        $arResult['JS_DATA']['TOTAL']['TOTAL_SKIDKA'] = $totalSkidka;
        $arResult['JS_DATA']['TOTAL']['TOTAL_SKIDKA_FORMATED'] = '-' . $totalSkidka . '%';
    }

}


$arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE_FORMATED'] =  CurrencyFormat($arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE'],'RUB');


//this.CUSTOM_ECONOMY_VAL = this.result.TOTAL.DISCOUNT_PRICE, this.CUSTOM_ECONOMY_VAL_FORMATED = this.result.TOTAL.DISCOUNT_PRICE_FORMATED,
