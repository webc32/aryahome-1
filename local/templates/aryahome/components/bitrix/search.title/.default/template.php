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

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if($INPUT_ID == '')
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if($CONTAINER_ID == '')
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';

if($arParams["SHOW_INPUT"] !== "N"):?>
<div class="w-100">
	<div class="search border-gray round d-flex col-12 align-items-center text-black">
		<form action="<?echo $arResult["FORM_ACTION"]?>" class="w-100">
			<div id="<?echo $CONTAINER_ID?>" class="d-flex justify-content-between">	
				<input type="text" name="q" placeholder="Поиск по сайту..." value="<?=htmlspecialcharsbx($_REQUEST["q"])?>" autocomplete="off" id="<?echo $INPUT_ID?>" class="form-control border-none w-100 pl-2">
	            <button class="border-none bg-none search-title-button" type="submit" name="s">
	                <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
	                    <g>
	                    <path d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.8477 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.8477 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.8477 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z" fill="#A5ACAF"/>
	                    <path d="M19.7617 18.6124L15.1005 13.9511C14.7829 13.6335 14.2685 13.6335 13.9509 13.9511C13.6332 14.2684 13.6332 14.7834 13.9509 15.1007L18.6121 19.762C18.7709 19.9208 18.9788 20.0002 19.1869 20.0002C19.3948 20.0002 19.6029 19.9208 19.7617 19.762C20.0794 19.4446 20.0794 18.9297 19.7617 18.6124Z" fill="#A5ACAF"/>
	                    </g>
	                </svg>
	            </button>
			</div>
		</form>
	</div>
</div>
<?endif?>
<script>
	BX.ready(function(){
		new JCTitleSearch({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'MIN_QUERY_LEN': 2
		});
	});
</script>

