<?$this->__component->arResultCacheKeys = array_merge($this->__component->arResultCacheKeys, array('ID', 'IBLOCK_SECTION_ID', 'DISPLAY_PROPERTIES'));?>
<?
//    if ($_GET['test'] == 'y'){
//        $needUpperCaseProps = array('Email', 'Timework', 'Metro', 'Phone');
//        foreach ($needUpperCaseProps as $neededProp){
//            if (isset($arResult['DISPLAY_PROPERTIES'][$neededProp])){
//                $upperCaseProp = strtoupper($neededProp);
//                if ($neededProp == 'Phone'){
//                    $arResult['DISPLAY_PROPERTIES'][$upperCaseProp] = $arResult['DISPLAY_PROPERTIES'][$neededProp];
//                    $arResult['DISPLAY_PROPERTIES'][$upperCaseProp]['VALUE'] = array($arResult['DISPLAY_PROPERTIES'][$neededProp]['VALUE']);
//                }else if($neededProp == 'Timework'){
//
//                    $arResult['DISPLAY_PROPERTIES']['SCHEDULE'] = $arResult['DISPLAY_PROPERTIES'][$neededProp];
//                   // $val = iconv(  'UTF-8','windows-1251', $arResult['DISPLAY_PROPERTIES']['SCHEDULE']['~VALUE']['TEXT']);
//                    $arResult['DISPLAY_PROPERTIES']['SCHEDULE']['~VALUE']['TEXT'] = $arResult['DISPLAY_PROPERTIES']['SCHEDULE']['VALUE'];
//                }
//                else{
//                    $arResult['DISPLAY_PROPERTIES'][$upperCaseProp] = $arResult['DISPLAY_PROPERTIES'][$neededProp];
//                }
//            }
//
//
//        }
//
//
//    }
?>
