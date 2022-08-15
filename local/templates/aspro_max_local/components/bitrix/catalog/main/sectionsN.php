<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?global $arTheme, $APPLICATION, $arSectionFilter;?>
<?$APPLICATION->AddViewContent('right_block_class', 'catalog_page ');?>

<?$arSectionFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
CMax::makeSectionFilterInRegion($arSectionFilter);?>

<?// region filter for to count elements
if(
	$GLOBALS['arRegion'] &&
	$GLOBALS['arTheme']['USE_REGIONALITY']['VALUE'] === 'Y' &&
	$GLOBALS['arTheme']['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_FILTER_ITEM']['VALUE'] === 'Y'
){
	// unrem this for hide empty sections without region`s products
	//$arSectionFilter['PROPERTY'] = array('LINK_REGION' => $GLOBALS['arRegion']['ID']);

	$arSectionFilter['PROPERTY_LINK_REGION'] = $GLOBALS['arRegion']['ID'];
}?>

<?$sViewElementTemplate = ($arParams["SECTIONS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["CATALOG_PAGE_SECTIONS"]["VALUE"] : $arParams["SECTIONS_TYPE_VIEW"]);?>
<?$bShowLeftBlock = ($arTheme["LEFT_BLOCK_CATALOG_ROOT"]["VALUE"] == "Y" && !defined("ERROR_404") && !($arTheme['HEADER_TYPE']['VALUE'] == 28 || $arTheme['HEADER_TYPE']['VALUE'] == 29));?>
<?$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", ( $bShowLeftBlock ? 'N' : 'Y' ) );?>
<div class="main-catalog-wrapper">
	<div class="section-content-wrapper <?=($bShowLeftBlock ? 'with-leftblock' : '');?>">
		<?
		global $SMART_FILTER_FILTER;
		$idForFilter = array();
		if(CModule::IncludeModule('iblock')) {
			$arSort= Array("NAME"=>"ASC");
			$arSelect = Array("ID","NAME","IBLOCK_ID","PROPERTY_NAIMENOVANIE_DLYA_SAYTA","PROPERTY_COLOR_FILTER");
			$arFilter2 = Array(
				"IBLOCK_ID" => array($arParams['IBLOCK_ID']),
				"ACTIVE" => 'Y',
				'INCLUDE_SUBSECTIONS' => 'Y',
				'>CATALOG_STORE_AMOUNT_3' => 0,
			);

			if(!$SMART_FILTER_FILTER['SECTION_ID']){
				$arFilter2["!SECTION_ID"] = 0;
			}else{
				$arFilter2["SECTION_ID"] = $SMART_FILTER_FILTER['SECTION_ID'];
			}



			$res = CIBlockElement::GetList($arSort, $arFilter2, false, false, $arSelect);
			while($ob = $res->fetch()){
				if(!in_array($ob["PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE"], $arNames)){
					$idForFilter[] = $ob['ID'];
					$arNames[$ob['ID']] = $ob["PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE"];
				}
				$idForSmartFilter[] = $ob['ID'];
			}

			$pageNotFixCustomOffers = $arResult['VARIABLES']['SECTION_CODE'] == 'podarochnye_karty';

			if($idForFilter && !$pageNotFixCustomOffers){
				$GLOBALS['MAX_SMART_FILTER']["=ID"] = $idForFilter;
			}
		}


		if($_POST['offer_ajax'] && ($_POST['product_color'] || $_POST['product_size'])){
			$id = $_POST['product_size'] ? $_POST['product_size'] : $_POST['product_color'];
			$GLOBALS['MAX_SMART_FILTER'] = array("=ID" => $id);
		}
		?>
		
		<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>
		<br/><br/>
		
		<?//дополнительные элементы?>
			<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					"catalog_block",
					Array(
						"USE_REGION" => ($arRegion ? "Y" : "N"),
						"STORES" => $arParams['STORES'],
						"SHOW_BIG_BLOCK" => 'N',
						"IS_CATALOG_PAGE" => 'Y',
						"SHOW_UNABLE_SKU_PROPS"=>$arParams["SHOW_UNABLE_SKU_PROPS"],
						"ALT_TITLE_GET" => $arParams["ALT_TITLE_GET"],
						"SEF_URL_TEMPLATES" => $arParams["SEF_URL_TEMPLATES"],
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SHOW_COUNTER_LIST" => $arParams["SHOW_COUNTER_LIST"],
						"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
						"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
						"AJAX_REQUEST" => $isAjax,
						"ELEMENT_SORT_FIELD" => "show",
						"ELEMENT_SORT_ORDER" => "asc",
						"SHOW_DISCOUNT_TIME_EACH_SKU" => $arParams["SHOW_DISCOUNT_TIME_EACH_SKU"],
						"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
						"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
						"FILTER_NAME" => 'NEW_FILTER',
						"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
						"PAGE_ELEMENT_COUNT" => $show,
						"LINE_ELEMENT_COUNT" => $linerow,
						"SET_LINE_ELEMENT_COUNT" => $bSetElementsLineRow,
						"DISPLAY_TYPE" => $display,
						"TYPE_SKU" => ($typeSKU ? $typeSKU : $arTheme["TYPE_SKU"]["VALUE"]),
						"SET_SKU_TITLE" => ((($typeSKU == "TYPE_1" || $arTheme["TYPE_SKU"]["VALUE"] == "TYPE_1") && $arTheme["CHANGE_TITLE_ITEM_LIST"]["VALUE"] == "Y") ? "Y" : ""),
						"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
						"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
						"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
						"MAX_SCU_COUNT_VIEW" => $arTheme['MAX_SCU_COUNT_VIEW']['VALUE'],
						"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
						'OFFER_SHOW_PREVIEW_PICTURE_PROPS' => $arParams['OFFER_SHOW_PREVIEW_PICTURE_PROPS'],
						"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => "quantity",
						"PRODUCT_PROPS_VARIABLE" => "prop",
						"MAX_GALLERY_ITEMS" => $arParams["MAX_GALLERY_ITEMS"],
						"SHOW_GALLERY" => $arParams["SHOW_GALLERY"],
						"SHOW_PROPS" => "N",
						'SHOW_POPUP_PRICE' => (CMax::GetFrontParametrValue('SHOW_POPUP_PRICE') == 'Y' ? "Y" : "N"),
						'TYPE_VIEW_BASKET_BTN' => CMax::GetFrontParametrValue('TYPE_VIEW_BASKET_BTN'),
						'TYPE_VIEW_CATALOG_LIST' => CMax::GetFrontParametrValue('TYPE_VIEW_CATALOG_LIST'),
						'SHOW_STORES_POPUP' => (CMax::GetFrontParametrValue('STORES_SOURCE') == 'STORES' && $arParams['STORES']),
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
						"AJAX_MODE" => $arParams["AJAX_MODE"],
						"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
						"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
						"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"CACHE_FILTER" => $arParams["CACHE_FILTER"],
						"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
						"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
						"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
						"ADD_SECTIONS_CHAIN" => ($iSectionsCount && $arParams['INCLUDE_SUBSECTIONS'] == "N") ? 'N' : $arParams["ADD_SECTIONS_CHAIN"],
						"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
						'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
						"DISPLAY_COMPARE" => CMax::GetFrontParametrValue('CATALOG_COMPARE'),
						"USE_FAST_VIEW" => CMax::GetFrontParametrValue('USE_FAST_VIEW_PAGE_DETAIL'),
						"MANY_BUY_CATALOG_SECTIONS" => CMax::GetFrontParametrValue('MANY_BUY_CATALOG_SECTIONS'),
						"SET_TITLE" => $arParams["SET_TITLE"],
						"SET_STATUS_404" => $arParams["SET_STATUS_404"],
						"SHOW_404" => $arParams["SHOW_404"],
						"MESSAGE_404" => $arParams["MESSAGE_404"],
						"FILE_404" => $arParams["FILE_404"],
						"PRICE_CODE" => $arParams['PRICE_CODE'],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
						"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
						"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
						"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
						"PAGER_TITLE" => $arParams["PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
						"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
						"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
						"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
						"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
						"AJAX_OPTION_ADDITIONAL" => "",
						"ADD_CHAIN_ITEM" => "N",
						"SHOW_QUANTITY" => $arParams["SHOW_QUANTITY"],
						"ADD_DETAIL_TO_SLIDER" => $arParams["DETAIL_ADD_DETAIL_TO_SLIDER"],
						"OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
						"SHOW_QUANTITY_COUNT" => $arParams["SHOW_QUANTITY_COUNT"],
						"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
						"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
						"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
						"SHOW_ONE_CLICK_BUY" => $arParams["SHOW_ONE_CLICK_BUY"],
						"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
						"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
						"CURRENCY_ID" => $arParams["CURRENCY_ID"],
						"USE_STORE" => $arParams["USE_STORE"],
						"MAX_AMOUNT" => $arParams["MAX_AMOUNT"],
						"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
						"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
						"USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
						"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
						"LIST_DISPLAY_POPUP_IMAGE" => $arParams["LIST_DISPLAY_POPUP_IMAGE"],
						"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
						"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
						"SHOW_HINTS" => $arParams["SHOW_HINTS"],
						"USE_CUSTOM_RESIZE_LIST" => $arTheme['USE_CUSTOM_RESIZE_LIST']['VALUE'],
						"OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],
						"SHOW_SECTIONS_LIST_PREVIEW" => $arParams["SHOW_SECTIONS_LIST_PREVIEW"],
						"SECTIONS_LIST_PREVIEW_PROPERTY" => $arParams["SECTIONS_LIST_PREVIEW_PROPERTY"],
						"SHOW_SECTION_LIST_PICTURES" => $arParams["SHOW_SECTION_LIST_PICTURES"],
						"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"SALE_STIKER" => $arParams["SALE_STIKER"],
						"STIKERS_PROP" => $arParams["STIKERS_PROP"],
						"SHOW_RATING" => $arParams["SHOW_RATING"],
						"REVIEWS_VIEW" => (isset($arTheme['REVIEWS_VIEW']['VALUE']) && $arTheme['REVIEWS_VIEW']['VALUE'] == 'EXTENDED') || (!isset($arTheme['REVIEWS_VIEW']['VALUE']) && isset($arTheme['REVIEWS_VIEW']) && $arTheme['REVIEWS_VIEW'] ==  'EXTENDED'),
						"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
						"IBINHERIT_TEMPLATES" => $arSeoItem ? $arIBInheritTemplates : array(),
						"FIELDS" => $arParams['FIELDS'],
						"USER_FIELDS" => $arParams['USER_FIELDS'],
						"SECTION_COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
						"SHOW_PROPS_TABLE" => $typeTableProps ?? strtolower(CMax::GetFrontParametrValue('SHOW_TABLE_PROPS')),
						"SHOW_OFFER_TREE_IN_TABLE" => CMax::GetFrontParametrValue('SHOW_OFFER_TREE_IN_TABLE'),
                        "SHOW_FAST_VIEW_BTN_SEPARATELY" => $arParams['SHOW_FAST_VIEW_BTN_SEPARATELY'],
					), $component, array("HIDE_ICONS" => $isAjax)
				);?>


<?global $USER;
if($USER->isAdmin()):?>		

<?





global $arTheme, $NextSectionID, $arRegion;
$arPageParams = $arSection = $section = array();
$_SESSION['SMART_FILTER_VAR'] = $arParams['FILTER_NAME'];

$bUseModuleProps = \Bitrix\Main\Config\Option::get("iblock", "property_features_enabled", "N") === "Y";

$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", (($arTheme["LEFT_BLOCK_CATALOG_SECTIONS"]["VALUE"] == "Y" && !($arTheme['HEADER_TYPE']['VALUE'] == 28 || $arTheme['HEADER_TYPE']['VALUE'] == 29)  ? "N" : "Y")));
?>
<?$APPLICATION->AddViewContent('right_block_class', 'catalog_page ');?>
<?if(CMax::checkAjaxRequest2()):?>
	<div>
<?endif;?>



		


<?
	if(!$_POST['offer_ajax']):
?>
<div class="top-content-block"><?/*$APPLICATION->ShowViewContent('top_content');?><?$APPLICATION->ShowViewContent('top_content2');*/?></div>
<?endif;?>
<?if(CMax::checkAjaxRequest2()):?>
	</div>
<?endif;?>


<?// get current section ID
//$arSectionFilter = array('GLOBAL_ACTIVE' => 'Y', "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
if($arResult["VARIABLES"]["SECTION_ID"] > 0){
	$arSectionFilter = array('GLOBAL_ACTIVE' => 'Y', "ID" => $arResult["VARIABLES"]["SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
	
}
elseif(strlen(trim($arResult["VARIABLES"]["SECTION_CODE"])) > 0){
	$arSectionFilter = array('GLOBAL_ACTIVE' => 'Y', "=CODE" => $arResult["VARIABLES"]["SECTION_CODE"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
}
if(!$arSectionFilter){
	$arSectionFilter = array("SECTION_ID" => 0, "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
}


			
$section = CMaxCache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), CMax::makeSectionFilterInRegion($arSectionFilter), false, array("ID", "IBLOCK_ID", "NAME", "DESCRIPTION", "PICTURE", "DETAIL_PICTURE", "UF_SECTION_DESCR", "UF_OFFERS_TYPE", 'UF_FILTER_VIEW', 'UF_LINE_ELEMENT_CNT', 'UF_TABLE_PROPS', 'UF_SECTION_BG_DARK', 'UF_LINKED_BLOG', 'UF_BLOG_BOTTOM', 'UF_BLOG_WIDE', 'UF_BLOG_MOBILE', 'UF_LINKED_BANNERS', 'UF_BANNERS_BOTTOM', 'UF_BANNERS_WIDE', 'UF_BANNERS_MOBILE', $arParams["SECTION_DISPLAY_PROPERTY"], $arParams["SECTION_BG"], "IBLOCK_SECTION_ID", "DEPTH_LEVEL", "LEFT_MARGIN", "RIGHT_MARGIN"));
CMax::AddMeta([
	'og:image' => ($section['PICTURE'] || $section['DETAIL_PICTURE'] ? CFile::GetPath($section['PICTURE'] ?: $section['DETAIL_PICTURE']) : false),
]);



$typeSKU = '';
$bSetElementsLineRow = false;


if($section['ID'] == '396'){
	$section['ID'] = '0';
}


if ($section) {
	$arSection["ID"] = $section["ID"];
	$arSection["NAME"] = $section["NAME"];
	$arSection["IBLOCK_SECTION_ID"] = $section["IBLOCK_SECTION_ID"];
	$arSection["DEPTH_LEVEL"] = $section["DEPTH_LEVEL"];
	if ($section[$arParams["SECTION_DISPLAY_PROPERTY"]]) {
		$arDisplayRes = CUserFieldEnum::GetList(array(), array("ID" => $section[$arParams["SECTION_DISPLAY_PROPERTY"]]));
		if ($arDisplay = $arDisplayRes->GetNext()) {
			$arSection["DISPLAY"] = $arDisplay["XML_ID"];
		}
	}
	if ($section["UF_LINE_ELEMENT_CNT"]) {
		$arCntRes = CUserFieldEnum::GetList(array(), array("ID" => $section["UF_LINE_ELEMENT_CNT"]));
		if ($arLineCnt = $arCntRes->GetNext()) {
			$arParams["LINE_ELEMENT_COUNT"] = $arLineCnt["XML_ID"];
			$bSetElementsLineRow = true;
		}
	}
	$viewTableProps = 0;
    if ($section['UF_TABLE_PROPS']) {
        $viewTableProps = $section['UF_TABLE_PROPS'];
    }

	$posSectionDescr = COption::GetOptionString("aspro.max", "SHOW_SECTION_DESCRIPTION", "BOTTOM", SITE_ID);
	if(strlen($section["DESCRIPTION"])){
		$arSection["DESCRIPTION"] = $section["DESCRIPTION"];
	}
	if(strlen($section["UF_SECTION_DESCR"])){
		$arSection["UF_SECTION_DESCR"] = $section["UF_SECTION_DESCR"];
	}

	global $arSubSectionFilter;





	$arSubSectionFilter = array(
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",

	);
	$iSectionsCount = CMaxCache::CIBlockSection_GetCount(array('CACHE' => array("TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), CMax::makeSectionFilterInRegion($arSubSectionFilter));



	$catalog_available = $arParams['HIDE_NOT_AVAILABLE'];
	if (!isset($arParams['HIDE_NOT_AVAILABLE'])) {
		$catalog_available = 'N';
	}
	if ($arParams['HIDE_NOT_AVAILABLE'] != 'Y' && $arParams['HIDE_NOT_AVAILABLE'] != 'L') {
		$catalog_available = 'N';
	}
	if ($arParams['HIDE_NOT_AVAILABLE'] == 'Y') {
		$catalog_available = 'Y';
	}
	$arElementFilter = array("ACTIVE" => "Y", "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
	if ($arParams["INCLUDE_SUBSECTIONS"] == "A") {
		$arElementFilter["INCLUDE_SUBSECTIONS"] = "Y";
		$arElementFilter["SECTION_GLOBAL_ACTIVE"] = "Y";
		$arElementFilter["SECTION_ACTIVE "] = "Y";
	}
	if ($arParams['HIDE_NOT_AVAILABLE'] == 'Y') {
		$arElementFilter["CATALOG_AVAILABLE"] = $catalog_available;
	}

	$itemsCnt = CMaxCache::CIBlockElement_GetList(array("CACHE" => array("TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), CMax::makeElementFilterInRegion($arElementFilter), array());

	


	// set offer type & smartfilter view
	$typeTmpSKU = $viewTmpFilter = 0;
	if ($section['UF_OFFERS_TYPE']) {
		$typeTmpSKU = $section['UF_OFFERS_TYPE'];
	}
	if ($section['UF_FILTER_VIEW']) {
		$viewTmpFilter = $section['UF_FILTER_VIEW'];
	}
	if ($section['UF_LINKED_BLOG']) {
		$linkedArticles = $section['UF_LINKED_BLOG'];
	}
	if ($section['UF_BLOG_BOTTOM']) {
		$linkedArticlesPos = 'bottom';
	}
	if ($section['UF_BLOG_WIDE']) {
		$linkedArticlesRows = $section['UF_BLOG_WIDE'];
	}
	if ($section['UF_BLOG_MOBILE']) {
		$linkedArticlesRowsMobile = $section['UF_BLOG_MOBILE'];
	}
	if ($section['UF_LINKED_BANNERS']) {
		$linkedBanners = $section['UF_LINKED_BANNERS'];
	}
	if ($section['UF_BANNERS_BOTTOM']) {
		$linkedBannersPos = 'bottom';
	}
	if ($section['UF_BANNERS_WIDE']) {
		$linkedBannersRows = $section['UF_BANNERS_WIDE'];
	}
	if ($section['UF_BANNERS_MOBILE']) {
		$linkedBannersRowsMobile = $section['UF_BANNERS_MOBILE'];
	}

	if (!$typeTmpSKU || !$viewTmpFilter || !$arSection["DISPLAY"] || !$bSetElementsLineRow 
		|| !$linkedArticles	|| !$linkedArticlesPos || $linkedArticlesRows || $linkedArticlesRowsMobile
		|| !$linkedBanners	|| !$linkedBannersPos || $linkedBannersRows || $linkedBannersRowsMobile || !$viewTableProps
		) {
		if ($section['DEPTH_LEVEL'] > 1) {
			$sectionParent = CMaxCache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "ID" => $section["IBLOCK_SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", "UF_OFFERS_TYPE", 'UF_FILTER_VIEW', $arParams["SECTION_DISPLAY_PROPERTY"], "UF_LINE_ELEMENT_CNT", "UF_TABLE_PROPS", "UF_LINKED_BLOG", 'UF_BLOG_BOTTOM', 'UF_BLOG_WIDE', 'UF_BLOG_MOBILE', 'UF_LINKED_BANNERS', 'UF_BANNERS_BOTTOM', 'UF_BANNERS_WIDE', 'UF_BANNERS_MOBILE',));
			if ($sectionParent['UF_OFFERS_TYPE'] && !$typeTmpSKU) {
				$typeTmpSKU = $sectionParent['UF_OFFERS_TYPE'];
			}
			if ($sectionParent['UF_FILTER_VIEW'] && !$viewTmpFilter) {
				$viewTmpFilter = $sectionParent['UF_FILTER_VIEW'];
			}
			if ($sectionParent['UF_LINKED_BLOG'] && !$linkedArticles) {
				$linkedArticles = $sectionParent['UF_LINKED_BLOG'];
			}
			if ($sectionParent['UF_BLOG_BOTTOM'] && !$linkedArticlesPos) {
				$linkedArticlesPos = 'bottom';
			}
			if ($sectionParent['UF_BLOG_WIDE'] && !$linkedArticlesRows) {
				$linkedArticlesRows = $sectionParent['UF_BLOG_WIDE'];
			}
			if ($sectionParent['UF_BLOG_MOBILE'] && !$linkedArticlesRowsMobile) {
				$linkedArticlesRowsMobile = $sectionParent['UF_BLOG_MOBILE'];
			}
			if ($sectionParent['UF_LINKED_BANNERS'] && !$linkedBanners) {
				$linkedBanners = $sectionParent['UF_LINKED_BANNERS'];
			}
			if ($sectionParent['UF_BANNERS_BOTTOM'] && !$linkedBannersPos) {
				$linkedBannersPos = 'bottom';
			}
			if ($sectionParent['UF_BANNERS_WIDE'] && !$linkedBannersRows) {
				$linkedBannersRows = $sectionParent['UF_BANNERS_WIDE'];
			}
			if ($sectionParent['UF_BANNERS_MOBILE'] && !$linkedBannersRowsMobile) {
				$linkedBannersRowsMobile = $sectionParent['UF_BANNERS_MOBILE'];
			}
			if ($sectionParent[$arParams["SECTION_DISPLAY_PROPERTY"]] && !$arSection["DISPLAY"]) {
				$arDisplayRes = CUserFieldEnum::GetList(array(), array("ID" => $sectionParent[$arParams["SECTION_DISPLAY_PROPERTY"]]));
				if ($arDisplay = $arDisplayRes->GetNext()) {
					$arSection["DISPLAY"] = $arDisplay["XML_ID"];
				}
			}
			if ($sectionParent["UF_LINE_ELEMENT_CNT"] && !$bSetElementsLineRow) {
				$arCntRes = CUserFieldEnum::GetList(array(), array("ID" => $sectionParent["UF_LINE_ELEMENT_CNT"]));
				if ($arLineCnt = $arCntRes->GetNext()) {
					$arParams["LINE_ELEMENT_COUNT"] = $arLineCnt["XML_ID"];
					$bSetElementsLineRow = true;
				}
			}
			if ($sectionParent['UF_TABLE_PROPS'] && !$viewTableProps) {
                $viewTableProps = $sectionParent['UF_TABLE_PROPS'];
            }
			

			if ($section['DEPTH_LEVEL'] > 2) {
				if (!$typeTmpSKU || !$viewTmpFilter || !$arSection["DISPLAY"] || !$bSetElementsLineRow  || !$viewTableProps) {
					$sectionRoot = CMaxCache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "<=LEFT_BORDER" => $section["LEFT_MARGIN"], ">=RIGHT_BORDER" => $section["RIGHT_MARGIN"], "DEPTH_LEVEL" => 1, "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", "UF_OFFERS_TYPE", 'UF_FILTER_VIEW', $arParams["SECTION_DISPLAY_PROPERTY"], "UF_LINE_ELEMENT_CNT", "UF_TABLE_PROPS", "UF_LINKED_BLOG", 'UF_BLOG_BOTTOM', 'UF_BLOG_WIDE', 'UF_BLOG_MOBILE', 'UF_LINKED_BANNERS', 'UF_BANNERS_BOTTOM', 'UF_BANNERS_WIDE', 'UF_BANNERS_MOBILE',));
					if ($sectionRoot['UF_OFFERS_TYPE'] && !$typeTmpSKU) {
						$typeTmpSKU = $sectionRoot['UF_OFFERS_TYPE'];
					}
					if ($sectionRoot['UF_FILTER_VIEW'] && !$viewTmpFilter) {
						$viewTmpFilter = $sectionRoot['UF_FILTER_VIEW'];
					}
					if ($sectionRoot['UF_LINKED_BLOG'] && !$linkedArticles) {
						$linkedArticles = $sectionRoot['UF_LINKED_BLOG'];
					}
					if ($sectionRoot['UF_BLOG_BOTTOM'] && !$linkedArticlesPos) {
						$linkedArticlesPos = 'bottom';
					}
					if ($sectionRoot['UF_BLOG_WIDE'] && !$linkedArticlesRows) {
						$linkedArticlesRows = $sectionRoot['UF_BLOG_WIDE'];
					}
					if ($sectionRoot['UF_BLOG_MOBILE'] && !$linkedArticlesRowsMobile) {
						$linkedArticlesRowsMobile = $sectionRoot['UF_BLOG_MOBILE'];
					}
					if ($sectionRoot['UF_LINKED_BANNERS'] && !$linkedBanners) {
						$linkedBanners = $sectionRoot['UF_LINKED_BANNERS'];
					}
					if ($sectionRoot['UF_BANNERS_BOTTOM'] && !$linkedBannersPos) {
						$linkedBannersPos = 'bottom';
					}
					if ($sectionRoot['UF_BANNERS_WIDE'] && !$linkedBannersRows) {
						$linkedBannersRows = $sectionRoot['UF_BANNERS_WIDE'];
					}
					if ($sectionRoot['UF_BANNERS_MOBILE'] && !$linkedBannersRowsMobile) {
						$linkedBannersRowsMobile = $sectionRoot['UF_BANNERS_MOBILE'];
					}
					if ($sectionRoot[$arParams["SECTION_DISPLAY_PROPERTY"]] && !$arSection["DISPLAY"]) {
						$arDisplayRes = CUserFieldEnum::GetList(array(), array("ID" => $sectionRoot[$arParams["SECTION_DISPLAY_PROPERTY"]]));
						if ($arDisplay = $arDisplayRes->GetNext()) {
							$arSection["DISPLAY"] = $arDisplay["XML_ID"];
						}
					}
					if ($sectionRoot["UF_LINE_ELEMENT_CNT"] && !$bSetElementsLineRow) {
						$arCntRes = CUserFieldEnum::GetList(array(), array("ID" => $sectionRoot["UF_LINE_ELEMENT_CNT"]));
						if ($arLineCnt = $arCntRes->GetNext()) {
							$arParams["LINE_ELEMENT_COUNT"] = $arLineCnt["XML_ID"];
							$bSetElementsLineRow = true;
						}
					}
					if ($sectionRoot['UF_TABLE_PROPS'] && !$viewTableProps) {
                        $viewTableProps = $sectionRoot['UF_TABLE_PROPS'];
                    }
				}
			}
		}
	}
	if($typeTmpSKU){
		$rsTypes = CUserFieldEnum::GetList(array(), array("ID" => $typeTmpSKU));
		if($arType = $rsTypes->Fetch()){
			$typeSKU = $arType['XML_ID'];
			$arTheme['TYPE_SKU']['VALUE'] = $typeSKU;
		}
	}
	if($viewTmpFilter){
		$rsViews = CUserFieldEnum::GetList(array(), array('ID' => $viewTmpFilter));
		if($arView = $rsViews->Fetch()){
			$viewFilter = $arView['XML_ID'];
			$arTheme['FILTER_VIEW']['VALUE'] = strtoupper($viewFilter);
		}
	}
	if ($viewTableProps) {
        $rsViews = CUserFieldEnum::GetList(array(), array('ID' => $viewTableProps));
        if ($arView = $rsViews->Fetch()) {
            $typeTableProps = strtolower($arView['XML_ID']);
        }
    }
}



$linerow = $arParams["LINE_ELEMENT_COUNT"];

if (!isset($linkedArticlesPos) || !$linkedArticlesPos) {
	$linkedArticlesPos = 'content';
}
if (!isset($linkedArticlesRows) || !$linkedArticlesRows) {
	$linkedArticlesRows = 1;
}
if (!isset($linkedArticlesRowsMobile) || !$linkedArticlesRowsMobile) {
	$linkedArticlesRowsMobile = 1;
}

if (!isset($linkedBannersPos) || !$linkedBannersPos) {
	$linkedBannersPos = 'content';
}
if (!isset($linkedBannersRows) || !$linkedBannersRows) {
	$linkedBannersRows = 1;
}
if (!isset($linkedBannersRowsMobile) || !$linkedBannersRowsMobile) {
	$linkedBannersRowsMobile = 1;
}

$bSimpleSectionTemplate = (isset($arSection["DISPLAY"]) && $arSection["DISPLAY"] == "simple");



if ($bSimpleSectionTemplate) {
	$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
	$APPLICATION->AddViewContent('right_block_class', 'simple_page ');
	unset($arParams['LANDING_POSITION']);

	$template = 'catalog_'.$arSection["DISPLAY"];

	$arParams["USE_PRICE_COUNT"] = "N";
	$bSetElementsLineRow = true;

	$arTheme['MOBILE_CATALOG_LIST_ELEMENTS_COMPACT']['VALUE'] = 'Y';
	$arTheme['TYPE_SKU']['VALUE'] = 'TYPE_2';
}?>

<?$bHideSideSectionBlock = ($arParams["SHOW_SIDE_BLOCK_LAST_LEVEL"] == "Y" && $iSectionsCount && $arParams["INCLUDE_SUBSECTIONS"] == "N");
if ($bHideSideSectionBlock) {
	$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
}?>

<?$bShowLeftBlock = (!$bSimpleSectionTemplate && ($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") != "Y" && !($arTheme['HEADER_TYPE']['VALUE'] == 28 || $arTheme['HEADER_TYPE']['VALUE'] == 29)));?>

<div class="main-catalog-wrapper clearfix">
	<div class="section-content-wrapper <?=($bShowLeftBlock ? 'with-leftblock' : '');?>">
		<?
		if($section)
		{
			?>

			<?$this->SetViewTarget("section_bnr_h1_content");?>
				<?if($section[$arParams['SECTION_BG']]):?>
					<div class="section-banner-top">
						<div class="section-banner-top__picture" style="background: url(<?=CFile::GetPath($section[$arParams['SECTION_BG']])?>) center/cover no-repeat;"></div>
					</div>
				<?endif;?>
			<?$this->EndViewTarget();?>

			<?if($section[$arParams['SECTION_BG']]):?>
				<?global $dopClass;
					$dopClass .= ' has-secion-banner';
					if(!$section['UF_SECTION_BG_DARK'])
						$dopClass .= ' light-menu-color';?>
				<div class="js-banner" data-class="<?=$dopClass?>"></div>
			<?endif;?>
		<?}
		else{
			/*\Bitrix\Iblock\Component\Tools::process404(
				""
				,($arParams["SET_STATUS_404"] === "Y")
				,($arParams["SET_STATUS_404"] === "Y")
				,($arParams["SHOW_404"] === "Y")
				,$arParams["FILE_404"]
			);*/
		}

		if($arRegion)
		{
			if($arRegion['LIST_PRICES'])
			{
				if(reset($arRegion['LIST_PRICES']) != 'component')
					$arParams['PRICE_CODE'] = array_keys($arRegion['LIST_PRICES']);
			}
			if($arRegion['LIST_STORES'])
			{
				if(reset($arRegion['LIST_STORES']) != 'component')
					$arParams['STORES'] = $arRegion['LIST_STORES'];
			}
		}

		if($arParams['LIST_PRICES'])
		{
			foreach($arParams['LIST_PRICES'] as $key => $price)
			{
				if(!$price)
					unset($arParams['LIST_PRICES'][$key]);
			}
		}

		if($arParams['STORES'])
		{
			foreach($arParams['STORES'] as $key => $store)
			{
				if(!$store)
					unset($arParams['STORES'][$key]);
			}
		}

		$NextSectionID = $arSection["ID"];?>

		<?
		//seo
		$catalogInfoIblockId = CMaxCache::$arIBlocks[SITE_ID]["aspro_max_catalog"]["aspro_max_catalog_info"][0];
		if($catalogInfoIblockId && !$bSimpleSectionTemplate){
			/*fix*/
			$current_url =  $APPLICATION->GetCurDir();
			$real_url = $current_url;
			$current_url =  str_replace(array('%25', '&quot;', '&#039;'), array('%', '"', "'"), $current_url); // for utf-8 fix some problem
			$encode_current_url = urlencode($current_url);
			$gaps_encode_current_url = str_replace(' ', '%20', $current_url);
			$encode_current_url_slash = str_replace(array('%2F', '+'), array('/', '%20'), $encode_current_url);
			$urldecodedCP = iconv("windows-1251", "utf-8//IGNORE", $current_url);
			$urldecodedCP_slash = str_replace(array('%2F'), array('/'), rawurlencode($urldecodedCP));
			$replacements = array('"' ,'%27', '%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%3F', '%23', '%5B', '%5D');// for fix some problem  with spec chars in prop
			$entities = array("&quot;", '&#039;', ' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "?", "#", "[", "]");
			$replacedSpecChar = str_replace($entities, $replacements, $current_url);
			/**/

			$arSeoItems = CMaxCache::CIBLockElement_GetList(array('SORT' => 'ASC', 'CACHE' => array("MULTI" => "Y", "TAG" => CMaxCache::GetIBlockCacheTag($catalogInfoIblockId))), array("IBLOCK_ID" => $catalogInfoIblockId, "ACTIVE" => "Y", "PROPERTY_FILTER_URL" => array($real_url, $current_url, $gaps_encode_current_url, $urldecodedCP_slash, $encode_current_url_slash, $replacedSpecChar)), false, false, array("ID", "IBLOCK_ID", "PROPERTY_FILTER_URL", "PROPERTY_LINK_REGION"));
			
			$arSeoItem = $arTmpRegionsLanding = array();
			if($arSeoItems)
			{
				$iLandingItemID = 0;
				//$current_url =  $APPLICATION->GetCurDir();
				//$url = urldecode(str_replace(' ', '+', $current_url));
				foreach($arSeoItems as $arItem)
				{
					if(!is_array($arItem['PROPERTY_LINK_REGION_VALUE']))
						$arItem['PROPERTY_LINK_REGION_VALUE'] = (array)$arItem['PROPERTY_LINK_REGION_VALUE'];

					if(!$arSeoItem)
					{
						//$urldecoded = urldecode($arItem["PROPERTY_FILTER_URL_VALUE"]);
						//$urldecodedCP = iconv("utf-8", "windows-1251//IGNORE", $urldecoded);
						//if($urldecoded == $url || $urldecoded == $current_url || $urldecodedCP == $current_url)
						//{
							if($arItem['PROPERTY_LINK_REGION_VALUE'])
							{
								if($arRegion && in_array($arRegion['ID'], $arItem['PROPERTY_LINK_REGION_VALUE']))
									$arSeoItem = $arItem;
							}
							else
							{
								$arSeoItem = $arItem;
							}

							if($arSeoItem)
							{
								$iLandingItemID = $arSeoItem['ID'];
								$arSeoItem = CMaxCache::CIBLockElement_GetList(array('SORT' => 'ASC', 'CACHE' => array("MULTI" => "N", "TAG" => CMaxCache::GetIBlockCacheTag($catalogInfoIblockId))), array("IBLOCK_ID" => $catalogInfoIblockId, "ID" => $iLandingItemID), false, false, array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_PICTURE", "PROPERTY_FILTER_URL", "PROPERTY_LINK_REGION", "PROPERTY_FORM_QUESTION", "PROPERTY_SECTION_SERVICES", "PROPERTY_TIZERS", "PROPERTY_SECTION", "DETAIL_TEXT", "PROPERTY_I_ELEMENT_PAGE_TITLE", "PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_ALT", "PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_TITLE", "PROPERTY_I_SKU_PAGE_TITLE", "PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_ALT", "PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_TITLE", "ElementValues"));

								$arIBInheritTemplates = array(
									"ELEMENT_PAGE_TITLE" => $arSeoItem["PROPERTY_I_ELEMENT_PAGE_TITLE_VALUE"],
									"ELEMENT_PREVIEW_PICTURE_FILE_ALT" => $arSeoItem["PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_ALT_VALUE"],
									"ELEMENT_PREVIEW_PICTURE_FILE_TITLE" => $arSeoItem["PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_TITLE_VALUE"],
									"SKU_PAGE_TITLE" => $arSeoItem["PROPERTY_I_SKU_PAGE_TITLE_VALUE"],
									"SKU_PREVIEW_PICTURE_FILE_ALT" => $arSeoItem["PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_ALT_VALUE"],
									"SKU_PREVIEW_PICTURE_FILE_TITLE" => $arSeoItem["PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_TITLE_VALUE"],
								);

								\Aspro\Max\Smartseo\General\Smartseo::disallowNoindexRule(true);
							}
						//}
					}

					if($arItem['PROPERTY_LINK_REGION_VALUE'])
					{
						if(!$arRegion || !in_array($arRegion['ID'], $arItem['PROPERTY_LINK_REGION_VALUE']))
							$arTmpRegionsLanding[] = $arItem['ID'];
					}
				}
			}

			if ($arSeoItems && $bHideSideSectionBlock) {
				$arSeoItems = [];
			}
		}

		if($arRegion)
		{
			if($arRegion["LIST_STORES"] && $arParams["HIDE_NOT_AVAILABLE"] == "Y")
			{
				if($arParams['STORES']){					
					if(CMax::checkVersionModule('18.6.200', 'iblock')){
						$arStoresFilter = array(
							'STORE_NUMBER' => $arParams['STORES'],
							'>STORE_AMOUNT' => 0,
						);						
					}
					else{
						if(count($arParams['STORES']) > 1){
							$arStoresFilter = array('LOGIC' => 'OR');
							foreach($arParams['STORES'] as $storeID)
							{
								$arStoresFilter[] = array(">CATALOG_STORE_AMOUNT_".$storeID => 0);
							}
						}
						else{
							foreach($arParams['STORES'] as $storeID)
							{
								$arStoresFilter = array(">CATALOG_STORE_AMOUNT_".$storeID => 0);
							}
						}
					}

					$arTmpFilter = array('!TYPE' => array('2', '3'));
					if($arStoresFilter){
						if(!CMax::checkVersionModule('18.6.200', 'iblock') && count($arStoresFilter) > 1){
							$arTmpFilter[] = $arStoresFilter;
						}
						else{
							$arTmpFilter = array_merge($arTmpFilter, $arStoresFilter);
						}

						$GLOBALS[$arParams["FILTER_NAME"]][] = array(
							'LOGIC' => 'OR',
							array('TYPE' => array('2','3')),
							$arTmpFilter,
						);
						
					}
				}
			}
			$arParams["USE_REGION"] = "Y";

			$GLOBALS[$arParams['FILTER_NAME']]['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
			if(CMax::GetFrontParametrValue('REGIONALITY_FILTER_ITEM') == 'Y' && CMax::GetFrontParametrValue('REGIONALITY_FILTER_CATALOG') == 'Y'){
				$GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_LINK_REGION'] = $arRegion['ID'];
			}
			CMax::makeElementFilterInRegion($GLOBALS[$arParams['FILTER_NAME']]);
		}

		/* hide compare link from module options */
		if(CMax::GetFrontParametrValue('CATALOG_COMPARE') == 'N')
			$arParams["USE_COMPARE"] = 'N';
		/**/

		$arParams['DISPLAY_WISH_BUTTONS'] = CMax::GetFrontParametrValue('CATALOG_DELAY');
		?>
		<?
			if(!in_array("DETAIL_PAGE_URL", (array)$arParams["LIST_OFFERS_FIELD_CODE"]))
				$arParams["LIST_OFFERS_FIELD_CODE"][] = "DETAIL_PAGE_URL";

			if ($bUseModuleProps){
				$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
				$arParams['OFFERS_CART_PROPERTIES'] = \Bitrix\Catalog\Product\PropertyCatalogFeature::getBasketPropertyCodes($arSKU['IBLOCK_ID'], ['CODE' => 'Y']);
			}
		?>

		<?$arTransferParams = array(
			"SHOW_ABSENT" => $arParams["SHOW_ABSENT"],
			"HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
			"OFFER_SHOW_PREVIEW_PICTURE_PROPS" => $arParams["OFFER_SHOW_PREVIEW_PICTURE_PROPS"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
			"CURRENCY_ID" => $arParams["CURRENCY_ID"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"LIST_OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"LIST_OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
			"SHOW_COUNTER_LIST" => $arParams["SHOW_COUNTER_LIST"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
			"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
			"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
			"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
			"USE_REGION" => $arParams["USE_REGION"],
			"STORES" => $arParams["STORES"],
			"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"SHOW_GALLERY" => $arParams["SHOW_GALLERY"],
			"MAX_GALLERY_ITEMS" => $arParams["MAX_GALLERY_ITEMS"],
			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
			"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
			"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
			"SHOW_ONE_CLICK_BUY" => $arParams["SHOW_ONE_CLICK_BUY"],
			"SHOW_DISCOUNT_TIME_EACH_SKU" => $arParams["SHOW_DISCOUNT_TIME_EACH_SKU"],
			"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
			"SHOW_POPUP_PRICE" => CMax::GetFrontParametrValue('SHOW_POPUP_PRICE'),
			"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
			"ADD_DETAIL_TO_SLIDER" => $arParams["DETAIL_ADD_DETAIL_TO_SLIDER"],
			"OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"IBINHERIT_TEMPLATES" => $arSeoItem ? $arIBInheritTemplates : array(),
			"DISPLAY_COMPARE" => CMax::GetFrontParametrValue('CATALOG_COMPARE'),
			"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
		);?>



		<?$bContolAjax = (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && isset($_GET["control_ajax"]) && $_GET["control_ajax"] == "Y" );?>
		<?// section elements?>
		<div class="js_wrapper_items<?=($arTheme["LAZYLOAD_BLOCK_CATALOG"]["VALUE"] == "Y" ? ' with-load-block' : '')?>" data-params='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arTransferParams, false))?>'>
			<div class="js-load-wrapper">
				<?if($bContolAjax):?>
					<?$APPLICATION->RestartBuffer();?>
				<?endif;?>

				
				<?@include_once('page_blocks/list_elements_2.php');?>
					
				<?if($bContolAjax):?>
					<?die();?>
				<?endif;?>
			</div>
		</div>
		<?CMax::get_banners_position('CONTENT_BOTTOM');
		global $bannerContentBottom;
		$bannerContentBottom = true;
		?>
		<?CMax::checkBreadcrumbsChain($arParams, $arSection);?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.history.js');?>
	</div>
	<?if($bShowLeftBlock):?>
		<?CMax::ShowPageType('left_block');?>
	<?endif;?>
</div>
<?$tablePropsView = $typeTableProps ?? strtolower(CMax::GetFrontParametrValue('SHOW_TABLE_PROPS'));?>
<?if ( $tablePropsView === "cols" ):?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/tableScroller.js');?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/blocks/scroller.css');?>
<?endif;?>
<?
$bTopHeaderOpacity = false;

if( isset($arTheme['HEADER_TYPE']['LIST'][ $arTheme['HEADER_TYPE']['VALUE'] ]['ADDITIONAL_OPTIONS'])  && isset($arTheme['HEADER_TYPE']['LIST'][ $arTheme['HEADER_TYPE']['VALUE'] ]['ADDITIONAL_OPTIONS']['TOP_HEADER_OPACITY']) ) {
	$bTopHeaderOpacity = $arTheme['HEADER_TYPE']['LIST'][ $arTheme['HEADER_TYPE']['VALUE'] ]['ADDITIONAL_OPTIONS']['TOP_HEADER_OPACITY']['VALUE'] == 'Y';
}

if ($bTopHeaderOpacity && $section[$arParams['SECTION_BG']]) {
	global $dopBodyClass;
	$dopBodyClass .= ' top_header_opacity';
}

CMax::setCatalogSectionDescription(
	array(
		'FILTER_NAME' => $arParams['FILTER_NAME'],
		'CACHE_TYPE' => $arParams['CACHE_TYPE'],
		'CACHE_TIME' => $arParams['CACHE_TIME'],
		'SECTION_ID' => $arSection['ID'],
		'SHOW_SECTION_DESC' => $arParams['SHOW_SECTION_DESC'],
		'SEO_ITEM' => $arSeoItem,
	)
);?>



<?endif;?>


		
		<?CMax::get_banners_position('CONTENT_BOTTOM');
		global $bannerContentBottom;
		$bannerContentBottom = true;
		?>
	</div>
	<?if($bShowLeftBlock):?>
		<?CMax::ShowPageType('left_block');?>
	<?endif;?>
</div>
