<?if('Y' == $arParams['USE_FILTER']):?>
	
<?
if($arTheme["FILTER_VIEW"]["VALUE"] == 'COMPACT'){
	if($arParams["AJAX_FILTER_CATALOG"]=="Y"){
		$template_filter = 'main_compact_ajax';
	}
	else{
		$template_filter = 'main_compact';
	}
}
elseif($arParams["AJAX_FILTER_CATALOG"]=="Y"){
	$template_filter = 'main_ajax';
}
else{
	$template_filter = 'main';
}
?>
<?



global $SMART_FILTER_FILTER;


if($_SESSION['SMART_FILTER_VAR']) {
	$SMART_FILTER_FILTER = $GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ];
}

// if($arResult["VARIABLES"]['SECTION_ID']) {
// 	$SMART_FILTER_FILTER['SECTION_ID'] = $arResult["VARIABLES"]['SECTION_ID'];
// } else if($arResult["VARIABLES"]['SECTION_CODE']) {
// 	$SMART_FILTER_FILTER['SECTION_CODE'] = $arResult["VARIABLES"]['SECTION_CODE'];
// }



// $SMART_FILTER_FILTER['>CATALOG_STORE_AMOUNT_3'] = 0;
// $SMART_FILTER_FILTER['INCLUDE_SUBSECTIONS'] = 'Y';
// $SMART_FILTER_FILTER['ACTIVE'] = 'Y';

$arNames = array();
$idForFilter = array();
if(CModule::IncludeModule('iblock')) {
	$arSort= Array("NAME"=>"ASC");
	$arSelect = Array("ID","NAME","IBLOCK_ID","PROPERTY_NAIMENOVANIE_DLYA_SAYTA","PROPERTY_COLOR_FILTER");
	$arFilter = Array(
		"IBLOCK_ID" => array($arParams['IBLOCK_ID']),
		"ACTIVE" => 'Y',
		'INCLUDE_SUBSECTIONS' => 'Y',
		'>CATALOG_STORE_AMOUNT_3' => 0,
	);

	if(!$SMART_FILTER_FILTER['SECTION_ID']){
		$arFilter["!SECTION_ID"] = 0;
	}else{
		$arFilter["SECTION_ID"] = $SMART_FILTER_FILTER['SECTION_ID'];
	}



	$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
	while($ob = $res->fetch()){
		if(!in_array($ob["PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE"], $arNames)){
			$idForFilter[] = $ob['ID'];
			$arNames[$ob['ID']] = $ob["PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE"];
		}
		$idForSmartFilter[] = $ob['ID'];
	}

	$pageNotFixCustomOffers = $arResult['VARIABLES']['SECTION_CODE'] == 'podarochnye_karty';

	if($idForSmartFilter && !$pageNotFixCustomOffers){
		$SMART_FILTER_FILTER["=ID"] = $idForSmartFilter;
	}
}

// исключаем дубликаты END

if($_POST['offer_ajax'] && ($_POST['product_color'] || $_POST['product_size'])){
	$id = $_POST['product_size'] ? $_POST['product_size'] : $_POST['product_color'];
	$SMART_FILTER_FILTER = array("=ID" => $id);
}



				

$TOP_VERTICAL_FILTER_PANEL = $arTheme["LEFT_BLOCK_CATALOG_SECTIONS"]['VALUE'] == 'Y' ? $arTheme["FILTER_VIEW"]['DEPENDENT_PARAMS']['TOP_VERTICAL_FILTER_PANEL']['VALUE'] : 'N';
$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter",
	$template_filter,
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"AJAX_FILTER_FLAG" => ( isset($isAjaxFilter) ? $isAjaxFilter : '' ),
		"SECTION_ID" => (isset($arSection["ID"]) ? $arSection["ID"] : ''),
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"PREFILTER_NAME" => 'SMART_FILTER_FILTER',
		"PRICE_CODE" => ($arParams["USE_FILTER_PRICE"] == 'Y' ? $arParams["FILTER_PRICE_CODE"] : $arParams["PRICE_CODE"]),
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_NOTES" => "",
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SAVE_IN_SESSION" => "N",
		"XML_EXPORT" => "Y",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		"SHOW_HINTS" => $arParams["SHOW_HINTS"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'DISPLAY_ELEMENT_COUNT' => $arParams['DISPLAY_ELEMENT_COUNT'],
		"INSTANT_RELOAD" => "Y",
		"VIEW_MODE" => strtolower($arTheme["FILTER_VIEW"]["VALUE"]),
		"SEF_MODE" => (strlen($arResult["URL_TEMPLATES"]["smart_filter"]) ? "Y" : "N"),
		"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
		"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
		"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
		"SEF_RULE_FILTER" => $arResult["URL_TEMPLATES"]["smart_filter"],
		"SORT_BUTTONS" => $arParams["SORT_BUTTONS"],
		"SORT_PRICES" => $arParams["SORT_PRICES"],
		"AVAILABLE_SORT" => $arAvailableSort,
		"SORT" => $sort,
		"SORT_ORDER" => $sort_order,
		"TOP_VERTICAL_FILTER_PANEL" => $TOP_VERTICAL_FILTER_PANEL,
		"SHOW_SORT" => ($arParams['SHOW_SORT_IN_FILTER'] != 'N'),
	),
	$component);
	?>
	<?endif;?>


	<?
// нужно переписать фильтрацию немного
	global $NEW_FILTER;
	//$GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ] = array();
	$preFilter = array();
	if($GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_85"]){
		$preFilter = array(
			"PROPERTY_COLOR_FILTER" => $GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_85"]
		);
	}
	// if($GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_75"]){
	// 	$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "CODE"=>"ALLRAZMER_FILTER",'ID' => $GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_75"]));
	// 	while($enum_fields = $property_enums->GetNext())
	// 	{
	// 		$propValue[] = $enum_fields["VALUE"];
	// 	}
	// 	if($propValue){
	// 		$preFilter = array(
	// 			array(
	// 				'LOGIC' => 'OR',
	// 				"PROPERTY_RAZMER" => $propValue,
	// 				"PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA" => $propValue,
	// 			)
	// 		);
	// 	}
	// 	unset($GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_75"]);
	// }
	if($GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_45"]){
		$preFilter = array(
			array(
				'LOGIC' => 'OR',
				"PROPERTY_RAZMER" => $GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_45"],
				"PROPERTY_OBSHCHIY_RAZMER_DLYA_SAYTA" => $GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_45"],
			)
		);
		unset($GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=PROPERTY_45"]);
	}




	$arNames = array();
	$idForFilter = array();
	if(CModule::IncludeModule('iblock')) {
		$arSort= Array("NAME"=>"ASC");
		$arSelect = Array("ID","NAME","IBLOCK_ID","PROPERTY_NAIMENOVANIE_DLYA_SAYTA","PROPERTY_COLOR_FILTER");
		$arFilter = Array(
			"IBLOCK_ID" => array($arParams['IBLOCK_ID']),
			"ACTIVE" => 'Y',
			'INCLUDE_SUBSECTIONS' => 'Y',
			'>CATALOG_STORE_AMOUNT_3' => 0,
		);

		if(!$GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]['SECTION_ID']){
			$arFilter["!SECTION_ID"] = 0;
		}else{
			$arFilter["SECTION_ID"] = $GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]['SECTION_ID'];
		}


		$idForSmartFilter = array();
		$res = CIBlockElement::GetList($arSort, array_merge($arFilter,$preFilter), false, false, $arSelect);
		while($ob = $res->fetch()){
			if(!in_array($ob["PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE"], $arNames) && !isset($arNames[$ob["PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE"]][$ob["PROPERTY_COLOR_FILTER_VALUE"]])){
				$idForFilter[] = $ob['ID'];
				//$arNames[$ob['ID']] = $ob["PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE"];
				$arNames[$ob["PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE"]][$ob["PROPERTY_COLOR_FILTER_VALUE"]] = $ob["PROPERTY_COLOR_FILTER_VALUE"];
			}
			$idForSmartFilter[] = $ob['ID'];
		}

		$pageNotFixCustomOffers = $arResult['VARIABLES']['SECTION_CODE'] == 'podarochnye_karty';

		if($idForFilter && !$pageNotFixCustomOffers){
			$GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ]["=ID"] = $idForFilter;
		}
	}

// исключаем дубликаты END

	if($_POST['offer_ajax'] && ($_POST['product_color'] || $_POST['product_size'])){
		$id = $_POST['product_size'] ? $_POST['product_size'] : $_POST['product_color'];
		$GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ] = array("ID" => $id);
	}
	$NEW_FILTER = $GLOBALS[ $_SESSION['SMART_FILTER_VAR'] ];


	?>