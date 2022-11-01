<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arParams["SHOW_LINK_SITE"] == "Y"):?>
	
	<?foreach ($arResult["SITES"] as $key => $arSite):?>
		<?if ($arSite["CURRENT"] != "Y"):?>
			<a href="<?if(is_array($arSite['DOMAINS']) && $arSite['DOMAINS'][0] <> '' || $arSite['DOMAINS'] <> ''):?>http://<?endif?><?=(is_array($arSite["DOMAINS"]) ? $arSite["DOMAINS"][0] : $arSite["DOMAINS"])?><?=$arSite["DIR"]?>" title="<?=$arSite["NAME"]?>" class="version_site_color"><?=GetMessage($arSite['LID'].'_SITE')?></a>
		<?endif?>
	<?endforeach?>
<?endif;?>