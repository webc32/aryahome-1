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
$templateData = array(
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}

$toshowselected = array();

foreach($arResult["ITEMS"] as $key=>$arItem) {
	foreach($arItem["VALUES"] as $val => $array) { 
		if($array["CHECKED"]) {
			$toshowselected[$arItem[NAME]][] = $array;
		}
	}
}

$this->SetViewTarget('filter.selected');?>
<div class="filter-active col-6 col-md-12 d-flex <?if(count($toshowselected) == 0) {?>d-md-none<?}?> align-items-center px-3 py-md-3">
    <div>
        <svg fill="#262626" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.1667 4.16668H16.9475C16.5867 5.3675 15.4833 6.25 14.1667 6.25C12.85 6.25 11.7475 5.3675 11.3859 4.16668H0.83332C0.37332 4.16668 0 3.79332 0 3.33332C0 2.87332 0.37332 2.5 0.83332 2.5H11.3858C11.7466 1.29918 12.85 0.416679 14.1666 0.416679C15.4833 0.416679 16.5858 1.29918 16.9475 2.5H19.1666C19.6275 2.5 20 2.87332 20 3.33332C20 3.79332 19.6275 4.16668 19.1667 4.16668Z"/>
            <path d="M19.1667 17.5001H16.9475C16.5858 18.7009 15.4833 19.5834 14.1667 19.5834C12.85 19.5834 11.7475 18.7009 11.3858 17.5001H0.83332C0.37332 17.5001 0 17.1267 0 16.6667C0 16.2067 0.37332 15.8334 0.83332 15.8334H11.3858C11.7475 14.6326 12.85 13.7501 14.1667 13.7501C15.4834 13.7501 16.5859 14.6326 16.9475 15.8334H19.1667C19.6275 15.8334 20 16.2067 20 16.6667C20 17.1267 19.6275 17.5001 19.1667 17.5001Z"/>
            <path d="M19.1667 10.8333H8.61418C8.2525 12.0341 7.15 12.9166 5.83336 12.9166C4.51672 12.9166 3.41418 12.0341 3.05254 10.8333H0.83332C0.37332 10.8333 0 10.46 0 9.99998C0 9.53998 0.37332 9.16666 0.83332 9.16666H3.0525C3.41418 7.96584 4.51668 7.08334 5.83332 7.08334C7.14996 7.08334 8.2525 7.96584 8.61414 9.16666H19.1666C19.6275 9.16666 20 9.53998 20 9.99998C20 10.46 19.6275 10.8333 19.1667 10.8333Z"/>
        </svg>
    </div>
    <div class="d-inline d-md-none w-100 text-center"><a href="" data-mobile="filter">Фильтры</a></div>
	<?if(count($toshowselected) > 0) {
		foreach($toshowselected as $name => $options) {?>
    		<div class="d-md-flex d-none align-items-center">   
				<?foreach($options as $option) {
					echo '
					<span class="ml-2">
					<label class="bg-graylight d-flex justify-content-center align-items-center px-3" for="'.$option[CONTROL_ID].'">
					'.$name.': '.$option[VALUE].'
			 			<div class="ellipse ml-2 text-center">
                    		<svg fill="white" width="18" height="17" viewBox="0 0 18 17" xmlns="http://www.w3.org/2000/svg">
                        		<rect x="5.47363" y="12.9348" width="1.66286" height="11.64" rx="0.831428" transform="rotate(-135 5.47363 12.9348)"/>
                        		<rect width="1.66286" height="11.64" rx="0.831428" transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 12.5264 12.9348)"/>
                    		</svg>
                		</div>
					</label>
					</span>
					';
				}?>
    		</div>             

		<?}
	}?>
</div>
<?$this->EndViewTarget();?>
<div class="row align-items-end justify-content-between d-none d-md-flex">
    <div class="title font-weight-800"><?echo GetMessage("CT_BCSF_FILTER_TITLE")?></div>
    <!-- <span class="text-gold ml-3 pr-md-5">по параметрам</span> -->
</div>
<div class="filter-mobile catalog row w-100 <?=$templateData["TEMPLATE_CLASS"]?> <?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL") echo "smart-filter-horizontal"?>">
	<div class="block bg-white mt-md-3 mt-0 pr-md-5 pl-md-0 pt-md-0 px-4 pt-4 w-100">
		<div class="close position-absolute d-block d-md-none">
            <a href="" onclick="return false" class="filter-close">
                <svg fill="#262626" width="26" height="25" viewBox="0 0 18 17" xmlns="http://www.w3.org/2000/svg">
                    <rect x="5.47363" y="12.9348" width="1.66286" height="11.64" rx="0.831428" transform="rotate(-135 5.47363 12.9348)"></rect>
                    <rect width="1.66286" height="11.64" rx="0.831428" transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 12.5264 12.9348)"></rect>
                </svg>
            </a>
        </div>
        <div class="position-relative w-100 d-md-none d-block">
            <div class="title font-weight-800">Подобрать</div>
            <span class="text-gold">по параметрам</span>
        </div>
        <div class="sorting">
        	<?
        	foreach($toshowselected as $name => $options) {
				?>
				<div class="filter-active position-relative d-md-none d-block pt-4">
				    <span class="d-block mb-2">
					<?
					foreach($options as $option) {
						echo '
						<label class="bg-graylight d-inline-block align-items-center px-3" for="'.$option[CONTROL_ID].'">
							'.$option[VALUE].'
						 	<div class="ellipse d-inline-block ml-2 text-center">
		                        <svg fill="white" width="18" height="17" viewBox="0 0 18 17" xmlns="http://www.w3.org/2000/svg">
		                            <rect x="5.47363" y="12.9348" width="1.66286" height="11.64" rx="0.831428" transform="rotate(-135 5.47363 12.9348)"/>
		                            <rect width="1.66286" height="11.64" rx="0.831428" transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 12.5264 12.9348)"/>
		                        </svg>
		                    </div>
						</label>
						';

					}
					?>
			        </span>
		        </div>                  
				<?
			}
        	?>
        </div>
		<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smart-filter-form">

			<?foreach($arResult["HIDDEN"] as $arItem):?>
				<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
			<?endforeach;?>

			<div class="row">
				<?foreach($arResult["ITEMS"] as $key=>$arItem)//prices
				{
					$key = $arItem["ENCODED_ID"];
					if(isset($arItem["PRICE"])):
						if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
							continue;

						$step_num = 4;
						$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
						$prices = array();
						if (Bitrix\Main\Loader::includeModule("currency"))
						{
							for ($i = 0; $i < $step_num; $i++)
							{
								$prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
							}
							$prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
						}
						else
						{
							$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
							for ($i = 0; $i < $step_num; $i++)
							{
								$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
							}
							$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
						}
						?>

						<div class="d-none <?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"):?>col-sm-6 col-md-4<?else:?>col-12<?endif?> mb-4 smart-filter-parameters-box bx-active">
							<span class="smart-filter-container-modef"></span>

							<div class="smart-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
								<span class="smart-filter-parameters-box-title-text"><?=$arItem["NAME"]?></span>
								<span data-role="prop_angle" class="smart-filter-angle smart-filter-angle-up">
									<span  class="smart-filter-angles"></span>
								</span>
							</div>

							<div class="smart-filter-block" data-role="bx_filter_block">
								<div class="smart-filter-parameters-box-container">
									<div class="smart-filter-input-group-number">
										<div class="d-flex justify-content-between">
											<div class="form-group">
												<div class="smart-filter-input-container">
													<input
														class="min-price form-control form-control-sm"
														type="number"
														name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
														id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
														value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
														placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")?>"
														onkeyup="smartFilter.keyup(this)"
													/>
												</div>
											</div>

											<div class="form-group">
												<div class="smart-filter-input-container">
													<input
														class="max-price form-control form-control-sm"
														type="number"
														name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
														id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
														value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
														placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")?>"
														onkeyup="smartFilter.keyup(this)"
													/>
												</div>
											</div>
										</div>

										<div class="smart-filter-slider-track-container">
											<div class="smart-filter-slider-track" id="drag_track_<?=$key?>">
												<?for($i = 0; $i <= $step_num; $i++):?>
												<div class="smart-filter-slider-ruler p<?=$i+1?>"><span><?=$prices[$i]?></span></div>
												<?endfor;?>
												<div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
												<div class="smart-filter-slider-price-bar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
												<div class="smart-filter-slider-price-bar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
												<div class="smart-filter-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0; right: 0;">
													<a class="smart-filter-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
													<a class="smart-filter-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?

						$arJsParams = array(
							"leftSlider" => 'left_slider_'.$key,
							"rightSlider" => 'right_slider_'.$key,
							"tracker" => "drag_tracker_".$key,
							"trackerWrap" => "drag_track_".$key,
							"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
							"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
							"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
							"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
							"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
							"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
							"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
							"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
							"precision" => $precision,
							"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
							"colorAvailableActive" => 'colorAvailableActive_'.$key,
							"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
						);
						?>
						<script type="text/javascript">
							BX.ready(function(){
								window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
							});
						</script>
					<?endif;
				}

				//not prices
				foreach($arResult["ITEMS"] as $key=>$arItem)
				{
					if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
						continue;

					if ($arItem["DISPLAY_TYPE"] == "A" && ( $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
						continue;
					?>

					<div class="<?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"):?>col-sm-6 col-md-4<?else:?>col-lg-12<?endif?> mb-4 smart-filter-parameters-box <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>bx-active<?endif?>">
						<span class="smart-filter-container-modef"></span>

						<div class="smart-filter-parameters-box-title section position-relative">
                            <div class="smart-filter-parameters-box-title-text name arrow-up active active font-weight-bold">
                                <? if($arItem['CODE'] == 'RAZMER_FILTER' && $arParams['SECTION_ID'] == 113): ?>
                                    Размер пододеяльника
                                <? else: ?>
                                    <?=$arItem["NAME"]?>
                                <? endif; ?>
                            </div>
                            <div class="options active mt-1">
                            	<?if ($arItem["FILTER_HINT"] <> ""):?>
									<span class="smart-filter-hint">
										<span class="smart-filter-hint-icon">?</span>
										<span class="smart-filter-hint-popup">
											<span class="smart-filter-hint-popup-angle"></span>
											<span class="smart-filter-hint-popup-content">

											</span>	<?=$arItem["FILTER_HINT"]?></span>
									</span>
								<?endif?>
								<div class="smart-filter-block" data-role="bx_filter_block">
									<div class="smart-filter-parameters-box-container">
									<?
									$arCur = current($arItem["VALUES"]);
									switch ($arItem["DISPLAY_TYPE"])
									{
										//region NUMBERS_WITH_SLIDER +
										case "A":
											?>
											<div class="smart-filter-input-group-number">
												<div class="d-flex justify-content-between">
													<div class="form-group" style="width: calc(50% - 10px);">
														<div class="smart-filter-input-container">
															<input class="min-price form-control form-control-sm"
																type="number"
																name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
																id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
																value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
																size="5"
																placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")?>"
																onkeyup="smartFilter.keyup(this)"
															/>
														</div>
													</div>
													<div class="form-group" style="width: calc(50% - 10px);">
														<div class="smart-filter-input-container">
															<input
																class="max-price form-control form-control-sm"
																type="number"
																name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
																id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
																value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
																size="5"
																placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")?>"
																onkeyup="smartFilter.keyup(this)"
															/>
														</div>
													</div>
												</div>
												<div class="smart-filter-slider-track-container">
													<div class="smart-filter-slider-track" id="drag_track_<?=$key?>">
														<?
															$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
															$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
															$value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
															$value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
															$value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
															$value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
															$value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
														?>
														<div class="smart-filter-slider-ruler p1"><span><?=$value1?></span></div>
														<div class="smart-filter-slider-ruler p2"><span><?=$value2?></span></div>
														<div class="smart-filter-slider-ruler p3"><span><?=$value3?></span></div>
														<div class="smart-filter-slider-ruler p4"><span><?=$value4?></span></div>
														<div class="smart-filter-slider-ruler p5"><span><?=$value5?></span></div>

														<div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
														<div class="smart-filter-slider-price-bar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
														<div class="smart-filter-slider-price-bar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
														<div class="smart-filter-slider-range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;">
															<a class="smart-filter-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
															<a class="smart-filter-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
														</div>
													</div>
												</div>
											</div>
											<?
												$arJsParams = array(
												"leftSlider" => 'left_slider_'.$key,
												"rightSlider" => 'right_slider_'.$key,
												"tracker" => "drag_tracker_".$key,
												"trackerWrap" => "drag_track_".$key,
												"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
												"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
												"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
												"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
												"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
												"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
												"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
												"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
												"precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
												"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
												"colorAvailableActive" => 'colorAvailableActive_'.$key,
												"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
											);
											?>
												<script type="text/javascript">
													BX.ready(function(){
														window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
													});
												</script>
											<?
										break;

										//endregion

										//region NUMBERS +
										case "B":
											?>
											<div class="smart-filter-input-group-number">
												<div class="d-flex justify-content-between">
													<div class="form-group" style="width: calc(50% - 10px);">
														<div class="smart-filter-input-container">
															<input
																class="min-price form-control form-control-sm"
																type="number"
																name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
																id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
																value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
																size="5"
																placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")?>"
																onkeyup="smartFilter.keyup(this)"
																/>
														</div>
													</div>

													<div class="form-group" style="width: calc(50% - 10px);">
													<div class="smart-filter-input-container">
														<input
															class="max-price form-control form-control-sm"
															type="number"
															name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
															id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
															value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
															size="5"
															placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")?>"
															onkeyup="smartFilter.keyup(this)"
															/>
													</div>
												</div>
												</div>
											</div>
											<?
										break;
										//endregion

										//region CHECKBOXES_WITH_PICTURES +
										case "G":
											?>
											<div class="smart-filter-input-group-checkbox-pictures">
												<?foreach ($arItem["VALUES"] as $val => $ar):?>
													<input
														style="display: none"
														type="checkbox"
														name="<?=$ar["CONTROL_NAME"]?>"
														id="<?=$ar["CONTROL_ID"]?>"
														value="<?=$ar["HTML_VALUE"]?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
													/>
													<?
														$class = "";
														if ($ar["CHECKED"])
															$class.= " bx-active";
														if ($ar["DISABLED"])
															$class.= " disabled";
													?>
													<label for="<?=$ar["CONTROL_ID"]?>"
														   data-role="label_<?=$ar["CONTROL_ID"]?>"
														   class="smart-filter-checkbox-label<?=$class?>"
														   onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
														<span class="smart-filter-checkbox-btn bx-color-sl">
															<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																<span class="smart-filter-checkbox-btn-image" style="background-image: url('<?=$ar["FILE"]["SRC"]?>');"></span>
															<?endif?>
														</span>
													</label>
												<?endforeach?>
												<div style="clear: both;"></div>
											</div>
											<?
										break;
										//endregion

										//region CHECKBOXES_WITH_PICTURES_AND_LABELS +
										case "H":
											?>
											<div class="smart-filter-input-group-checkbox-pictures-text">
												<?foreach ($arItem["VALUES"] as $val => $ar):?>
												<input
													style="display: none"
													type="checkbox"
													name="<?=$ar["CONTROL_NAME"]?>"
													id="<?=$ar["CONTROL_ID"]?>"
													value="<?=$ar["HTML_VALUE"]?>"
													<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
												/>
												<?
													$class = "";
													if ($ar["CHECKED"])
														$class.= " bx-active";
													if ($ar["DISABLED"])
														$class.= " disabled";
												?>
												<label for="<?=$ar["CONTROL_ID"]?>"
													   data-role="label_<?=$ar["CONTROL_ID"]?>"
													   class="smart-filter-checkbox-label<?=$class?>"
													   onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
													<span class="smart-filter-checkbox-btn">
														<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
															<span class="smart-filter-checkbox-btn-image" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
														<?endif?>
													</span>
													<span class="smart-filter-checkbox-text" title="<?=$ar["VALUE"];?>">
														<?=$ar["VALUE"];
														if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
															?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
														endif;?>
													</span>
												</label>
											<?endforeach?>
											</div>
											<?
										break;
										//endregion

										//region DROPDOWN +
										case "P":
											?>
											<? $checkedItemExist = false; ?>
											<div class="smart-filter-input-group-dropdown">
												<div class="smart-filter-dropdown-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
													<div class="smart-filter-dropdown-text" data-role="currentOption">
														<?foreach ($arItem["VALUES"] as $val => $ar)
														{
															if ($ar["CHECKED"])
															{
																echo $ar["VALUE"];
																$checkedItemExist = true;
															}
														}
														if (!$checkedItemExist)
														{
															echo GetMessage("CT_BCSF_FILTER_ALL");
														}
														?>
													</div>
													<div class="smart-filter-dropdown-arrow"></div>
													<input
														style="display: none"
														type="radio"
														name="<?=$arCur["CONTROL_NAME_ALT"]?>"
														id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
														value=""
													/>
													<?foreach ($arItem["VALUES"] as $val => $ar):?>
														<input
															style="display: none"
															type="radio"
															name="<?=$ar["CONTROL_NAME_ALT"]?>"
															id="<?=$ar["CONTROL_ID"]?>"
															value="<? echo $ar["HTML_VALUE_ALT"] ?>"
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
														/>
													<?endforeach?>

													<div class="smart-filter-dropdown-popup" data-role="dropdownContent" style="display: none;">
														<ul>
															<li>
																<label for="<?="all_".$arCur["CONTROL_ID"]?>"
																	   class="smart-filter-dropdown-label"
																	   data-role="label_<?="all_".$arCur["CONTROL_ID"]?>"
																	   onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																	<?=GetMessage("CT_BCSF_FILTER_ALL"); ?>
																</label>
															</li>
															<?foreach ($arItem["VALUES"] as $val => $ar):
																$class = "";
																if ($ar["CHECKED"])
																	$class.= " selected";
																if ($ar["DISABLED"])
																	$class.= " disabled";
															?>
																<li>
																	<label for="<?=$ar["CONTROL_ID"]?>"
																		   class="smart-filter-dropdown-label<?=$class?>"
																		   data-role="label_<?=$ar["CONTROL_ID"]?>"
																		   onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
																		<?=$ar["VALUE"]?>
																	</label>
																</li>
															<?endforeach?>
														</ul>
													</div>
												</div>
											</div>
											<?
										break;
										//endregion

										//region DROPDOWN_WITH_PICTURES_AND_LABELS
										case "R":
											?>
												<div class="smart-filter-input-group-dropdown">
													<div class="smart-filter-dropdown-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
														<div class="smart-filter-input-group-dropdown-flex" data-role="currentOption">
															<?
															$checkedItemExist = false;
															foreach ($arItem["VALUES"] as $val => $ar):
																if ($ar["CHECKED"])
																{
																?>
																	<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																		<span class="smart-filter-checkbox-btn-image" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																	<?endif?>
																	<span class="smart-filter-dropdown-text"><?=$ar["VALUE"]?></span>
																<?
																	$checkedItemExist = true;
																}
															endforeach;
															if (!$checkedItemExist)
															{
																?>
																	<span class="smart-filter-checkbox-btn-image all"></span>
																	<span class="smart-filter-dropdown-text"><?=GetMessage("CT_BCSF_FILTER_ALL");?></span>
																<?
															}
															?>
														</div>

														<div class="smart-filter-dropdown-arrow"></div>

														<input
															style="display: none"
															type="radio"
															name="<?=$arCur["CONTROL_NAME_ALT"]?>"
															id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
															value=""
														/>
														<?foreach ($arItem["VALUES"] as $val => $ar):?>
															<input
																style="display: none"
																type="radio"
																name="<?=$ar["CONTROL_NAME_ALT"]?>"
																id="<?=$ar["CONTROL_ID"]?>"
																value="<?=$ar["HTML_VALUE_ALT"]?>"
																<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
															/>
														<?endforeach?>

														<div class="smart-filter-dropdown-popup" data-role="dropdownContent" style="display: none">
															<ul>
																<li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
																	<label for="<?="all_".$arCur["CONTROL_ID"]?>"
																		   class="smart-filter-param-label"
																		   data-role="label_<?="all_".$arCur["CONTROL_ID"]?>"
																		   onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																		<span class="smart-filter-checkbox-btn-image all"></span>
																		<span class="smart-filter-dropdown-text"><?=GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
																	</label>
																</li>
															<?
															foreach ($arItem["VALUES"] as $val => $ar):
																$class = "";
																if ($ar["CHECKED"])
																	$class.= " selected";
																if ($ar["DISABLED"])
																	$class.= " disabled";
															?>
																<li>
																	<label for="<?=$ar["CONTROL_ID"]?>"
																		   data-role="label_<?=$ar["CONTROL_ID"]?>"
																		   class="smart-filter-param-label<?=$class?>"
																		   onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
																		<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																			<span class="smart-filter-checkbox-btn-image" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																		<?endif?>
																		<span class="smart-filter-dropdown-text"><?=$ar["VALUE"]?></span>
																	</label>
																</li>
															<?endforeach?>
															</ul>
														</div>
													</div>
												</div>
											<?
											break;
										//endregion

										//region RADIO_BUTTONS
										case "K":
											?>
											<div class="col">
												<div class="radio">
													<label class="smart-filter-param-label" for="<? echo "all_".$arCur["CONTROL_ID"] ?>">
														<span class="smart-filter-input-checkbox">
															<input
																type="radio"
																value=""
																name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
																id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
																onclick="smartFilter.click(this)"
															/>
															<span class="smart-filter-param-text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
														</span>
													</label>
												</div>
												<?foreach($arItem["VALUES"] as $val => $ar):?>
													<div class="radio">
														<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="smart-filter-param-label" for="<? echo $ar["CONTROL_ID"] ?>">
															<span class="smart-filter-input-checkbox <? echo $ar["DISABLED"] ? 'disabled': '' ?>">
																<input
																	type="radio"
																	value="<? echo $ar["HTML_VALUE_ALT"] ?>"
																	name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
																	id="<? echo $ar["CONTROL_ID"] ?>"
																	<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
																	onclick="smartFilter.click(this)"
																/>
																<span class="smart-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
																if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																	?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
																endif;?></span>
															</span>
														</label>
													</div>
												<?endforeach;?>
											</div>
											<div class="w-100"></div>
											<?
											break;

										//endregion

										//region CALENDAR
										case "U":
											?>
											<div class="col">
												<div class=""><div class="smart-filter-input-container smart-filter-calendar-container">
													<?$APPLICATION->IncludeComponent(
														'bitrix:main.calendar',
														'',
														array(
															'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
															'SHOW_INPUT' => 'Y',
															'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
															'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
															'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
															'SHOW_TIME' => 'N',
															'HIDE_TIMEBAR' => 'Y',
														),
														null,
														array('HIDE_ICONS' => 'Y')
													);?>
												</div></div>
												<div class=""><div class="smart-filter-input-container smart-filter-calendar-container">
													<?$APPLICATION->IncludeComponent(
														'bitrix:main.calendar',
														'',
														array(
															'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
															'SHOW_INPUT' => 'Y',
															'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
															'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
															'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
															'SHOW_TIME' => 'N',
															'HIDE_TIMEBAR' => 'Y',
														),
														null,
														array('HIDE_ICONS' => 'Y')
													);?>
												</div></div>
											</div>
											<div class="w-100"></div>
											<?
											break;
										//endregion

										//region CHECKBOXES +
										default:
											?>
										<div class="smart-filter-input-group-checkbox-list option jsshowblock">
												<?$counts = 0;?>
												<?foreach($arItem["VALUES"] as $val => $ar):?>
												<?$counts++;?>
													<div class="form-group <? echo $ar["DISABLED"] ? 'text-gray': '' ?> form-check mb-1 <? if($counts >5) {echo ' jshide ';}?>">
														<input
															type="checkbox"
															value="<? echo $ar["HTML_VALUE"] ?>"
															name="<? echo $ar["CONTROL_NAME"] ?>"
															id="<? echo $ar["CONTROL_ID"] ?>"
															class="form-check-input"
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
															<? echo $ar["DISABLED"] ? 'disabled': '' ?>
															onclick="smartFilter.click(this)"
														/>
														<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="smart-filter-checkbox-text form-check-label position-relative" for="<? echo $ar["CONTROL_ID"] ?>">
															<?=$ar["VALUE"];
															if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
															endif;?>
														</label>
													</div>
												<?endforeach;?>
											<? if(count($arItem["VALUES"]) >5) {?> <a class="jsshowall text-gold" href="#">Показать еще</a> <? } ?>
										</div>
									<?
										//endregion
									}
									?>
									</div>
								</div>
                            </div>
                        </div>
					</div>
				<?
				}
				?>
			</div><!--//row-->

			<div class="row">
				<div class="col smart-filter-button-box mb-4 mb-md-5">
					<div class="smart-filter-block">
						<div class="smart-filter-parameters-box-container">
							<input
								class="btn bg-active border-gold text-white mr-2"
								type="submit"
								id="set_filter"
								name="set_filter"
								value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
							/>
							<input
								class="btn bg-white border-gray btn-link"
								type="submit"
								id="del_filter"
								name="del_filter"
								value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
							/>
							<div class="smart-filter-popup-result right" id="modef" 
							<?if(!isset($arResult["ELEMENT_COUNT"])){echo 'style="display:none"';}else{echo 'style="display:inline-block"';}?>>
								<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
								<span class="arrow"></span>
								<br/>
								<a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>

	</div>
</div>

<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>