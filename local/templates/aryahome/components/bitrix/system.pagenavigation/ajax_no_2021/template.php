<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin("Загрузка навигации");

$CountItems = $arResult["NavRecordCount"];
$CountItemsCurrent = $arResult["NavPageNomer"] * $arResult[NavPageSize];
if ($CountItems < $CountItemsCurrent) {
    $CountItemsCurrent = $CountItems;}
$fullness = ($CountItemsCurrent / $CountItems) * 100;
?>
<div class="load-product w-100 mt-0 mt-md-5 py-4">
    <div class="w-100 text-center">                                 
        <?if($arResult["NavPageCount"] > 1):?>
            <span class="d-none my-2">Вы просмотрели <?=$CountItemsCurrent?> из <?=$CountItems;?> товаров</span>
            <?if ($arResult["NavPageNomer"]+1 <= $arResult["nEndPage"]):?>

                <?
                    $plus = $arResult["NavPageNomer"]+1;
                    $url = $arResult["sUrlPathParams"] . "PAGEN_".$arResult["NavNum"]."=".$plus;
                ?>

                <div class="d-none line position-relative mx-auto">
                    <svg width="100%" height="5" viewBox="0 0 329 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="329" height="5" rx="2.5" fill="#F5F5F5"/>
                        <rect width="<?=$fullness?>%" height="5" rx="2.5" fill="#D0A550"/>
                    </svg>
                </div>
                <a href="#" data-url="<?=$url?>" onclick="return false" class="text-gold round btn d-inline-block mx-auto align-items-center justify-content-center px-4 px-md-5 py-3 my-4"><span class="d-block">Загрузить еще</span></a>

            <?else:?>

                <div class="d-none line position-relative mx-auto">
                    <svg fill="#F5F5F5" width="100%" height="5" viewBox="0 0 329 5" xmlns="http://www.w3.org/2000/svg">
                        <rect width="329" height="5" rx="2.5"></rect>
                        <rect width="100%" height="5" rx="2.5" fill="#D0A550"/>
                    </svg>
                </div>
                <a href="#" onclick="return false" class="text-gold round btn d-inline-block mx-auto align-items-center justify-content-center px-4 px-md-5 py-3 my-4"><span class="d-block">Загружено все</span></a>

            <?endif?>

        <?endif?>
    </div>
</div>