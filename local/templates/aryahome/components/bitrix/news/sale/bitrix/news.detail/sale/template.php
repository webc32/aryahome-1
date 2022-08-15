<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$templateFolder = $this->GetFolder();?>
<? $date = date_create($arResult[DATE_ACTIVE_TO]); ?>
<script type="text/javascript">
    var deadline=new Date('<? echo date_format($date,"Y-m-d");?>'); //for Ukraine
    console.log(deadline);
</script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/timer.js"></script>
<div class="d-flex flex-wrap justify-content-between mb-5">
    <div class="sale element d-flex flex-wrap position-relative">
        <div class="col-12 col-md-6">
        	<div class="row justify-content-center">
            	<a href=""><img src="<?=$arResult[DETAIL_PICTURE][SRC]?>" loading="lazy" class="w-100 d-md-block d-none"></a>
            	<a href=""><img src="<?=$arResult[PREVIEW_PICTURE][SRC]?>" loading="lazy" class="w-100 d-md-none d-block"></a>
            </div>
        </div>
        <div class="col-12 col-md-6 pl-md-5">
        	<div class="row">
	            <div class="d-flex justify-content-between w-100">
	                <div class="d-block py-md-2 mb-1">
	                    <div class="name font-weight-800 mt-4 mt-md-0">
	                        <h1 class="text-gold d-block"><?=$arResult[NAME]?></h1>
	                    </div>
	                    <div class="description font-weight-500 mt-3">
	                        <?=$arResult[PREVIEW_TEXT]?>
	                    </div>
	                    <div class="more mt-4">
	                        <?=$arResult[DETAIL_TEXT]?>
	                    </div>
	                </div>
	            </div>
            </div>
        </div>
        <div class="note col-12 col-md-6 order-4 order-md-3">
        	<div class="row">
	            <div class="mt-4 mt-md-5">
	                <!-- <div>Акция действует с <?=$arResult[DISPLAY_ACTIVE_FROM]?></div> -->
	                <?php if (!empty($arResult[PROPERTIES][ADDSECTION][VALUE])): ?>
		                <div>Товары участвующие в акции с раздела: 
		                    <?
		                    foreach ($arResult[PROPERTIES][ADDSECTION][VALUE] as $key => $section) {
		                        CModule::IncludeModule("iblock");
		                        CModule::IncludeModule("catalog");

		                        //Поиск названия категории
		                        $arFilter = Array("IBLOCK_ID"=>3,"ID"=>array($section));
		                        $rsSections = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"), $arFilter, false, array("*"), array(
		                            "nPageSize" => 100000,
		                            "bShowAll" => true 
		                        ));

		                        while ($arSection = $rsSections->Fetch())
		                        {
		                        ?>
		                            <a href="/catalog/<?=$arSection[CODE]?>" class="text-gold mr-2 mb-1"><?=$arSection['NAME']?></a>
		                        <?
		                        }
		                    }
		                    ?>
		                </div>
	                <?php endif ?>
	            </div>
            </div>
        </div>
        <!--<div class="col-12 col-md-6 mt-3 order-3 order-md-4 pl-md-5">
            <div class="row flex-wrap align-items-center justify-content-between justify-content-md-start w-100">
                <?if (!empty($arResult[DATE_ACTIVE_TO])) {?>
                	<span class="left d-block font-weight-500 mr-2">Осталось:</span>
                    <div class="d-flex align-items-center justify-content-center" id="timer">
                        <div class="border-gray px-md-3 px-2 pb-2 pt-4 pt-md-3 mx-1">
                            <div class="number name days font-weight-bold"></div>
                            <div class="time left text-gray">дня</div>
                        </div>
                        <div class="border-gray px-md-3 px-2 pb-2 pt-4 pt-md-3 mx-1">
                            <div class="number name hours font-weight-bold"></div>
                            <div class="time left text-gray">часов</div>
                        </div>
                        <div class="border-gray px-md-3 px-2 pb-2 pt-4 pt-md-3 mx-1">
                            <div class="number name minutes font-weight-bold"></div>
                            <div class="time left text-gray">минут</div>
                        </div>
                        <div class="border-gray px-md-3 px-2 pb-2 pt-4 pt-md-3 mx-1">
                            <div class="number name seconds font-weight-bold"></div>
                            <div class="time left text-gray">Секунд</div>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>-->
    </div>
</div>
<div class="d-flex flex-wrap mb-5">
    <div class="border-bottom w-100">
    </div>
</div>