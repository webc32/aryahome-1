<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="row wide mx-auto">
	<div class="w-100">
		<form action="" method="get">
			<? if($arParams["USE_SUGGEST"] === "Y"):
				if(mb_strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
				{
					$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
					$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
					$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
				}
				?>
				<?$APPLICATION->IncludeComponent("bitrix:search.suggest.input", "", array(
						"NAME" => "q",
						"VALUE" => $arResult["REQUEST"]["~QUERY"],
						"INPUT_SIZE" => 40,
						"DROPDOWN_SIZE" => 10,
						"FILTER_MD5" => $arResult["FILTER_MD5"],
					),
					$component, array("HIDE_ICONS" => "Y")
				);?>
				<input class="btn btn-primary" type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
			<?else:?>
				<div class="search border-gray col-md col-12 d-none align-items-center justify-content-between text-black order-2 order-md-0 mt-3 mt-md-0">
					<input type="text" name="q" placeholder="Поиск по сайту..." value="<?=$arResult["REQUEST"]["QUERY"]?>" class="form-control border-none w-100 pl-2">
					<button type="submit" class="border-none bg-none search-title-button" type="submit" name="s">
		                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
		                    <g clip-path="url(#clip0)">
		                    <path d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.8477 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.8477 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.8477 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z" fill="#A5ACAF"/>
		                    <path d="M19.7617 18.6124L15.1005 13.9511C14.7829 13.6335 14.2685 13.6335 13.9509 13.9511C13.6332 14.2684 13.6332 14.7834 13.9509 15.1007L18.6121 19.762C18.7709 19.9208 18.9788 20.0002 19.1869 20.0002C19.3948 20.0002 19.6029 19.9208 19.7617 19.762C20.0794 19.4446 20.0794 18.9297 19.7617 18.6124Z" fill="#A5ACAF"/>
		                    </g>
		                    <defs>
		                    <clipPath id="clip0">
		                    <rect width="20" height="20" fill="white"/>
		                    </clipPath>
		                    </defs>
		                </svg>
		            </button>
				</div>
			<?endif;?>
			<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
			<? if($arParams["SHOW_WHEN"]):?>
			<script>
			var switch_search_params = function()
			{
				var sp = document.getElementById('search_params');
				var flag;

				if(sp.style.display == 'none')
				{
					flag = false;
					sp.style.display = 'block'
				}
				else
				{
					flag = true;
					sp.style.display = 'none';
				}

				var from = document.getElementsByName('from');
				for(var i = 0; i < from.length; i++)
					if(from[i].type.toLowerCase() == 'text')
						from[i].disabled = flag

				var to = document.getElementsByName('to');
				for(var i = 0; i < to.length; i++)
					if(to[i].type.toLowerCase() == 'text')
						to[i].disabled = flag

				return false;
			}
			</script>
			<br /><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a>
			<div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
				<?$APPLICATION->IncludeComponent(
					'bitrix:main.calendar',
					'',
					array(
						'SHOW_INPUT' => 'Y',
						'INPUT_NAME' => 'from',
						'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
						'INPUT_NAME_FINISH' => 'to',
						'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
						'INPUT_ADDITIONAL_ATTR' => 'size="10"',
					),
					null,
					array('HIDE_ICONS' => 'Y')
				);?>
			</div>
			<?endif?>
		</form>
		<br />
		<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
			?>
			<div class="search-language-guess">
				<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
			</div><br /><?
		endif;?>
	</div>
</div>