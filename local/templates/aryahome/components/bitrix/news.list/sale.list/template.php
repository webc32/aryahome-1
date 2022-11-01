<?
$this->setFrameMode(true);
$templateFolder = $this->GetFolder();
?>
<div class="d-flex flex-wrap justify-content-between">
<? foreach($arResult["ITEMS"] as $item){?>
    <div class="sale list position-relative col-md-6 col-12 mb-5 pr-md-5">
        <div class="row">
            <a href="<?=$item[DETAIL_PAGE_URL]?>"><img src="<?=$item[DETAIL_PICTURE][SRC]?>" loading="lazy" class="w-100 d-md-block d-none"></a>
            <a href="<?=$item[DETAIL_PAGE_URL]?>"><img src="<?=$item[PREVIEW_PICTURE][SRC]?>" loading="lazy" class="w-100 d-md-none d-block"></a>
            <div class="d-flex justify-content-between w-100">
                <div class="d-block flex-grow-1 py-md-2 mt-4 mb-1">
                    <div class="name title-3 font-weight-800">
                        <a href="<?=$item[DETAIL_PAGE_URL]?>" class="text-gold"><?=$item[NAME]?></a>
                    </div>
                    <div class="note font-weight-500">
                        <a href="<?=$item[DETAIL_PAGE_URL]?>"><?=$item[PREVIEW_TEXT]?></a>
                    </div>
                </div>
                <div class="d-block text-center mt-4 mb-1">
                	<?php if (!empty($item[DATE_ACTIVE_TO])): ?>
	                    <div class="border-gray px-md-4 px-2 py-2">
	                        <div class="date title-3 font-weight-bold mb-2 mb-md-0">
	                            <?
	                            $now = time(); // текущее время (метка времени)
	                            $DATE_ACTIVE_TO = strtotime($item[DATE_ACTIVE_TO]); // дата в строке
	                            $datediff = $now - $DATE_ACTIVE_TO; // получим разность дат (в секундах)

	                            echo floor($datediff / (60 * 60 * 24 *(-1))); // вычислим количество дней из разности дат
	                            ?>
	                        </div>
	                        <div class="date-note text-gray font-weight-500">
	                            До конца акции
	                        </div>
	                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
<?}?>
</div>
