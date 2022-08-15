<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>

<script id="basket-item-template" type="text/html">
	<tr class="item d-md-flex d-block w-100 mb-4 basket-items-list-item-container{{#SHOW_RESTORE}} basket-items-list-item-container-expend{{/SHOW_RESTORE}} {{#NOT_AVAILABLE}} disabled {{/NOT_AVAILABLE}}"
		id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
		{{#SHOW_RESTORE}}
			<td class="basket-items-list-item-notification" colspan="<?=$restoreColSpan?>">
				<div class="basket-items-list-item-notification-inner basket-items-list-item-notification-removed" id="basket-item-height-aligner-{{ID}}">
					{{#SHOW_LOADING}}
						<div class="basket-items-list-item-overlay"></div>
					{{/SHOW_LOADING}}
					<div class="basket-items-list-item-removed-container">
						<div>
							<?=Loc::getMessage('SBB_GOOD_CAP')?> <strong>{{NAME}}</strong> <?=Loc::getMessage('SBB_BASKET_ITEM_DELETED')?>.
						</div>
						<div class="basket-items-list-item-removed-block">
							<a href="javascript:void(0)" data-entity="basket-item-restore-button">
								<?=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?>
							</a>
							<span class="basket-items-list-item-clear-btn" data-entity="basket-item-close-restore-button"></span>
						</div>
					</div>
				</div>
			</td>
		{{/SHOW_RESTORE}}
		{{^SHOW_RESTORE}}
			<td class="d-md-flex d-block w-100">
				<div class="col-12 col-md-3">
					<div class="row justify-content-center justify-content-md-start">

						{{#DETAIL_PAGE_URL}}
							<a href="{{DETAIL_PAGE_URL}}" class="basket-item-image-link">
						{{/DETAIL_PAGE_URL}}

						<div class="images"><img class="basket-item-image" alt="{{NAME}}"
								src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}"></div>

						{{#DETAIL_PAGE_URL}}
							</a>
						{{/DETAIL_PAGE_URL}}	
					</div>
				</div>
				<div class="col-12 col-md-9 pt-md-2">
					<div class="row">
						<div class="col-8">
							<div class="row">
								<div class="name font-weight-500">
									{{#DETAIL_PAGE_URL}}
										<a href="{{DETAIL_PAGE_URL}}" class="basket-item-info-name-link">
									{{/DETAIL_PAGE_URL}}
			
									<span data-entity="basket-item-name">{{NAME}}</span>

									{{#DETAIL_PAGE_URL}}
										</a>
									{{/DETAIL_PAGE_URL}}
								</div>
								<div class="props w-100 mt-3">
									<?
									if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
									{
										foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
										{
											switch (trim((string)$blockName))
											{
												case 'columns':
													?>
													{{#COLUMN_LIST}}

														{{#IS_TEXT}}
															<div class="d-flex">
																<div class="name text-gray col">
																	<div class="row" data-entity="basket-item-property">{{{NAME}}}:</div>
																</div>
																<div class="value font-weight-500" data-column-property-code="{{CODE}}"
																	data-entity="basket-item-property-column-value">{{{VALUE}}}</div>
															</div>
														{{/IS_TEXT}}

													{{/COLUMN_LIST}}
													<?
													break;
											}
										}
									}
									?>
								</div>
							</div>
						</div>
						<div class="price col-4">
							<div class="d-flex justify-content-end">
								<div class="text-right">
									<?
									if ($useSumColumn)
									{
										?>
										<div class="basket-item-block-price {{#NOT_AVAILABLE}} d-none {{/NOT_AVAILABLE}}">
											<span class="current d-block mb-md-1 {{TSVET_TSENNIKA}}" id="basket-item-sum-price-{{ID}}">{{{SUM_PRICE_FORMATED}}}</span>
											<del>
												<span class="old d-block font-weight-500 text-gray mt-md-3">{{SUM_FUL_PRICE_OLD}} ₽</span>
											</del>
											<span class="discount font-weight-500 text-red">{{DISCOUNT}}%</span>
											{{#SHOW_LOADING}}
												<div class="basket-items-list-item-overlay"></div>
											{{/SHOW_LOADING}}
										</div>
										{{#NOT_AVAILABLE}}
											<div class="text-gray">
												Нет в наличии
											</div>
										{{/NOT_AVAILABLE}}
										<?
									}
									?>
								</div>
							</div>
						</div>
						<div class="w-100">
							<div class="col-12 props d-flex justify-content-between align-items-center w-100 order-1 order-md-2">
								<div class="d-flex flex-wrap tags mt-4"></div>
								<div class="delete">
									<a href="#" class="basket-item-actions-remove text-gray" data-entity="basket-item-delete">
										<span>Удалить</span>
										<span class="ml-1">
											<svg fill="#A5ACAF" width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
												<rect x="1.41406" width="14" height="2" rx="1" transform="rotate(45 1.41406 0)"></rect><rect x="11.3135" y="1.41406" width="14" height="2" rx="1" transform="rotate(135 11.3135 1.41406)"></rect>
											</svg>
										</span>
									</a>
									{{#SHOW_LOADING}}
										<div class="basket-items-list-item-overlay"></div>
									{{/SHOW_LOADING}}
								</div>
							</div>
							<div class="props quantity w-100 d-flex d-md-block justify-content-center order-2 order-md-1 mt-md-3 mt-0 basket-item-block-amount{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}" data-entity="basket-item-quantity-block">
								<div class="d-md-flex d-block flex-wrap align-items-center my-3 my-md-0">
									<div class="name text-gray text-center mr-0 mr-md-5 mb-2 mb-md-0">Количество:</div>
									<div class="value d-flex">
										<span class="basket-item-amount-btn-minus btn border-gold d-flex justify-content-center align-items-center" data-entity="basket-item-quantity-minus">
											<svg fill="#D0A550" width="14" height="2" viewBox="0 0 14 2" xmlns="http://www.w3.org/2000/svg"><rect width="14" height="2" rx="1"></rect></svg>
										</span>
										<div class="basket-item-amount-filed-block d-flex align-items-center">
											<input type="text" class="basket-item-amount-filed font-weight-500 text-center border-none" value="{{QUANTITY}}"
												{{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
												data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
												id="basket-item-quantity-{{ID}}"
												size="3"
												maxlength="18" min="0" max="202" step="1" value="5"
												>
										</div>
										<span class="basket-item-amount-btn-plus btn border-gold d-flex justify-content-center align-items-center" data-entity="basket-item-quantity-plus">
											<svg fill="#D0A550" width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><rect y="6" width="14" height="2" rx="1"></rect><rect x="8" width="14" height="2" rx="1" transform="rotate(90 8 0)"></rect></svg>
										</span>
									</div>
								</div>
								{{#SHOW_LOADING}}
									<div class="basket-items-list-item-overlay"></div>
								{{/SHOW_LOADING}}
							</div>
							
						</div>
					</div>
				</div>
			</td>
		{{/SHOW_RESTORE}}
	</tr>
</script>