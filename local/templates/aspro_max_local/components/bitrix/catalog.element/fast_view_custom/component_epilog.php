<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])){
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Bitrix\Main\Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency){?>
		<script type="text/javascript">
			BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
		</script>
	<?}
}?>
<?if(\Bitrix\Main\Loader::includeModule("aspro.max"))
{
	global $arRegion;
	$arRegion = CMaxRegionality::getCurrentRegion();
}?>
<script type="text/javascript">
	var viewedCounter = {
		path: '/bitrix/components/bitrix/catalog.element/ajax.php',
		params: {
			AJAX: 'Y',
			SITE_ID: "<?= SITE_ID ?>",
			PRODUCT_ID: "<?= $arResult['ID'] ?>",
			PARENT_ID: "<?= $arResult['ID'] ?>"
		}
	};
	BX.ready(
		BX.defer(function(){
			BX.ajax.post(
				viewedCounter.path,
				viewedCounter.params,
				function (){
				
				}
			);
		})		
	);
	/*check mobile device*/
	/*if(jQuery.browser.mobile){
		$('.hint span').remove();

		$('*[data-event="jqm"]').on('click', function(e){
			e.preventDefault();
			e.stopPropagation();
			var _this = $(this);
			var name = _this.data('name');
			if(window.matchMedia('(min-width:992px)').matches)
			{
				if(!$(this).hasClass('clicked'))
				{
					$(this).addClass('clicked');
					$(this).jqmEx();
					$(this).trigger('click');
				}
				return false;
			}
			else if(name.length){
				var script = arMaxOptions['SITE_DIR'] + 'form/';
				var paramsStr = ''; var arTriggerAttrs = {};
				$.each(_this.get(0).attributes, function(index, attr){
					var attrName = attr.nodeName;
					var attrValue = _this.attr(attrName);
					arTriggerAttrs[attrName] = attrValue;
					if(/^data\-param\-(.+)$/.test(attrName)){
						var key = attrName.match(/^data\-param\-(.+)$/)[1];
						paramsStr += key + '=' + attrValue + '&';
					}
				});

				var triggerAttrs = JSON.stringify(arTriggerAttrs);
				var encTriggerAttrs = encodeURIComponent(triggerAttrs);
				script += '?name=' + name + '&' + paramsStr + 'data-trigger=' + encTriggerAttrs;
				location.href = script;
			}
		});
	}*/

	viewItemCounter('<?=$arResult["ID"];?>','<?=current($arParams["PRICE_CODE"]);?>');
		
	/*костыль чтобы измени ть размеры слайдера т к размеры слайдов не стандартные*/
	setTimeout(function(){
		
		
	}, 200)
	
	
	/*Переход ко 2 слайду если есть видосик*/
	
	$('.product-detail-gallery__slider_custom_fast_view').on("refreshed.owl.carousel", function (event) {
		var first_elem = $(this).find('#photo-0');
	
		if(first_elem.find('.frame_custom_fast_view').length) {
			$(this).trigger('to.owl.carousel', [1, 0]);
		
		}
		
	})
	$('.video-block_popup_custom').on('click', 'a', function(e){
		e.preventDefault();
		var owl_car = $(this).closest('.product-detail-gallery__wrapper').find('.product-detail-gallery__slider_custom_fast_view');
		
		owl_car.trigger('to.owl.carousel', [0, 250])
	
	})
	
	/*Запуск видео каждый раз при загрузке окна */
	
	$('.preview_video').on('click', 'svg', function(){
		var iframe = $(this).closest('#photo-0').find('#iframe');
		var src_iframe = iframe.attr('src')+'&autoplay=1';
		//iframe.attr('src', src_iframe);
		iframe[0].contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');

		 $('.preview_video').hide()
		
	})
		
</script>

<?
	$arScripts = ['swiper', 'swiper_main_styles'];
	\Aspro\Max\Functions\Extensions::init($arScripts);
?>