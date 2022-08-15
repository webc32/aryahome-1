<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

?>
<?if(!empty($arResult)):?>
<ul class="list-style-none">
	<?
	$previousLevel = 0;
	foreach($arResult as $arItem){
		$ImgSrc = '';
        if(intval($arItem["PARAMS"]["PICTURE"])>0){
            $img = CFile::ResizeImageGet($arItem["PARAMS"]["PICTURE"], array('width'=>50, 'height'=>50),
            BX_RESIZE_IMAGE_PROPORTIONAL, false);  
            $ImgSrc = '<img alt="" src="'.$img['src'].'" />';}

		if($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel){
			echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
		}

		if($arItem["IS_PARENT"]){?>
			<li>
				<a href="<?=$arItem["LINK"]?>" class=" <?if($arItem["DEPTH_LEVEL"] < 2){?>parent<?}?> bg-graylight font-weight-bold d-flex justify-content-between align-items-center w-100 px-3 py-3 mb-2">
					<span><?=$arItem["TEXT"]?></span><?=$ImgSrc?>
				</a>
				<ul class="list-style-none w-100 bg-white position-absolute">
					<li>
						<a href="<?=$arItem["LINK"]?>" class="bg-graylight font-weight-bold d-flex justify-content-between align-items-center w-100 px-3 py-3 mb-2">
							<span>Перейти в "<?=$arItem["TEXT"]?>"</span><?=$ImgSrc?>
						</a>
					</li>
		<?}else{?>
			<li>
				<a href="<?=$arItem["LINK"]?>" class="bg-graylight font-weight-bold d-flex justify-content-between align-items-center w-100 px-3 py-3 mb-2">
					<span><?=$arItem["TEXT"]?></span><?=$ImgSrc?>
				</a>
			</li>
		<?}
		$previousLevel = $arItem["DEPTH_LEVEL"];
	}

	if($previousLevel > 1){
		echo str_repeat("</ul></li>", ($previousLevel-1) );
	}?>
	<li>
		<a href="/finalnaja-cena/" class="bg-graylight font-weight-bold d-flex justify-content-between align-items-center w-100 px-3 py-3 mb-2">
			<span class="text-red">Финальная цена</span><img src="/finalnaja-cena/116х116.jpg" width="50px">
		</a>
	</li>
</ul>
<?endif?>