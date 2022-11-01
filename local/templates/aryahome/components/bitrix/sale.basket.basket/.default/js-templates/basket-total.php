<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="bg-light d-md-block justify-content-between w-100 py-md-4 py-3 px-md-4 col-12 basket-checkout-container" data-entity="basket-checkout-aligner">
		<?
		if ($arParams['HIDE_COUPON'] !== 'Y')
		{
			?>
			<div class="coupon text-center mb-3 basket-coupon-section">
				<div class="basket-coupon-block-field">
					<div class="basket-coupon-block-field-description">
						<span><?=Loc::getMessage('SBB_COUPON_ENTER')?>:</span>
					</div>
					<div class="form">
						<div class="form-group" style="position: relative;">
							<input type="text" class="border-gray px-2 form-control" id="" placeholder="" data-entity="basket-coupon-input">
							<span class=" basket-coupon-block-coupon-btn"></span>
						</div>
					</div>

				</div>
			</div>
			<?
		}
		?>
		<?
		if ($arParams['HIDE_COUPON'] !== 'Y')
		{
		?>
			<div class="coupon basket-coupon-alert-section mb-4">
				<div class="basket-coupon-alert-inner">
					{{#COUPON_LIST}}
					<div class="basket-coupon-alert text-{{CLASS}}">
						<div class="basket-coupon-text">
							<strong>{{COUPON}}</strong> <br> 
							<span>- {{#DISCOUNT_NAME}}({{DISCOUNT_NAME}}){{/DISCOUNT_NAME}}</span>
							<a href="#" class="close-link ml-1 text-gold" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}">
								<?=Loc::getMessage('SBB_DELETE')?>
							</a>
						</div>
						<div style="display: none;">
							{{DISCOUNT_COUNT_FIX}}
						</div>
					</div>
					{{/COUPON_LIST}}
				</div>
			</div>
			<?
		}
		?>
		<div class="d-block w-100 text-center">
			<div class="economy d-none justify-content-between align-items-center">
				<span class="font-weight-500">Вы экономите</span>
				{{#DISCOUNT_PRICE_FORMATED}}
					<div class="text-red font-weight-bold">{{{DISCOUNT_PRICE_FORMATED}}}</div>
				{{/DISCOUNT_PRICE_FORMATED}}
			</div>
			<div class="total d-md-flex d-block justify-content-between align-items-center my-md-4">
				<span class="font-weight-500">Итого:</span>
				<div class="font-weight-bold" data-entity="basket-total-price">
					{{{PRICE_FORMATED}}}
				</div>
			</div>
			<div class="d-md-flex d-block justify-content-between align-items-center my-md-4">
				<span >Общий вес:</span>
				<div data-entity="basket-total-weight">
					{{#WEIGHT_FORMATED}}
						<span id="weight">{{{WEIGHT_FORMATED}}}</span>
						{{#SHOW_VAT}}<br>{{/SHOW_VAT}}
					{{/WEIGHT_FORMATED}}
				</div>
			</div>

			<!-- <div class="text-md-right text-center font-weight-500 text-center mb-4">
				Дополнительная скидка -2%<br> при оплате онлайн
			</div> -->

			<div class="basket-checkout-section-inner<?=(($arParams['HIDE_COUPON'] == 'Y') ? ' justify-content-between' : '')?>">
				<div class="basket-checkout-block basket-checkout-block-btn d-none">
					<button class="btn btn-lg btn-primary basket-btn-checkout{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
						data-entity="basket-checkout-button">
						<?=Loc::getMessage('SBB_ORDER')?>
					</button>
				</div>
				<a class="btn d-none d-md-block border-gray round text-gray w-100 py-3 px-4 px-md-5 mb-3" href="/catalog/">Продолжить покупки</a>
				<a class="btn d-block bg-active round text-white text-uppercase w-100 py-3 px-4 px-md-5" href="/personal/order/make/" id="finish">оформить заказ</a>
			</div>
		</div>
	</div>
</script>