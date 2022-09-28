<?
$arResult = array();
$iblockIDCustomBanner = 34; 
$iblockSectionIDCustomBanner = 408; 
$res = CIBlockElement::GetList(
    array("ID"=>"DESC"),
    array("IBLOCK_ID" => $iblockIDCustomBanner, "SECTION_ID" => $iblockSectionIDCustomBanner, "ACTIVE" => "Y"),
    false,
    false,
    array("ID", "IBLOCK_ID", "NAME", "PROPERTY_BG_BANNER_1", "PROPERTY_BG_BANNER_2", "PROPERTY_BG_BANNER_3", "PROPERTY_ACTIVE_BANNER_1", "PROPERTY_ACTIVE_BANNER_2", "PROPERTY_ACTIVE_BANNER_3",
    "PROPERTY_TITLE_BANNER_1", "PROPERTY_TITLE_BANNER_3", "PROPERTY_TEXT_BTN_BANNER_1", "PROPERTY_TEXT_BTN_BANNER_2", "PROPERTY_TEXT_BTN_BANNER_3", "PROPERTY_LINK_BANNER_1", "PROPERTY_LINK_BANNER_2", "PROPERTY_LINK_BANNER_3",
    "PROPERTY_DOP_TEXT_BANNER_3", "PROPERTY_COLOR_BG",  "PROPERTY_COLOR_BG_2", "PROPERTY_COLOR_BG_3")
);
$newResult = array();
while($ar_fields = $res->GetNext())
{
    $newResult[] = $ar_fields;
}
$arResult["ITEMS"] = $newResult;
?>

