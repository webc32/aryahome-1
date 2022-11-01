<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */

use Bitrix\Main\Loader;

global $arTheme;

$arScripts = [];

if (isset($arParams['SLIDE_ITEMS']) && $arParams['SLIDE_ITEMS'])
	$arScripts[] = 'owl_carousel';

if (CMax::GetFrontParametrValue("HOVER_TYPE_IMG") !== 'none')
	$arScripts[] = 'animation_ext';

if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])) {
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency) { ?>
		<script type="text/javascript">
			BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
		</script>
<? }
} ?>

<? if (count($arScripts)) : ?>
	<? \Aspro\Max\Functions\Extensions::init($arScripts); ?>
<? endif; ?>



<?if(!$_POST['offer_ajax']):?>
<script type="text/javascript">
	$(document).ready(function() {
		var elCatalogBlock = $(".catalog_block > .item_block");
		var mobileElCatalogBlock = $(".mobil_select");

		// if ($(window).width() > 991) {
		// 	elCatalogBlock.on({
		// 		mouseenter: function() {
		// 			$(this).find('.item_info').css("padding-bottom", "10px");
		// 			$(this).find('.item_info>.item_info--bottom_block>.prices').css({"margin-top": "0px", "padding-top": "0px"});
		// 			var offerBlock = $(this).find('.item-offers');
		// 			offerBlock.removeClass('hide');
		// 		},
		// 		mouseleave: function() {
		// 			$(this).find('.item_info').css("padding-bottom", "29px");
		// 			$(this).find('.item_info>.item_info--bottom_block>.prices').css({"margin-top": "12px", "padding-top": "7px"});
		// 			var offerBlock = $(this).find('.item-offers');
		// 			offerBlock.addClass('hide');
		// 		}
		// 	});
		// }


		mobileElCatalogBlock.on("click", function(evt) {

			$(this).toggleClass('noact');
			$(this).toggleClass('act');
			$(this).parent().find('.item-offers').toggleClass("hide");
			evt.stopImmediatePropagation();
			
			
		})
	
			





	})
</script>
<?endif;?>

