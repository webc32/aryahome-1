<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var SaleOrderAjax $component
 * @var string $templateFolder
 */

$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();

if (empty($arParams['TEMPLATE_THEME']))
{
	$arParams['TEMPLATE_THEME'] = Main\ModuleManager::isModuleInstalled('bitrix.eshop') ? 'site' : 'blue';
}

if ($arParams['TEMPLATE_THEME'] === 'site')
{
	$templateId = Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', $component->getSiteId());
	$templateId = preg_match('/^eshop_adapt/', $templateId) ? 'eshop_adapt' : $templateId;
	$arParams['TEMPLATE_THEME'] = Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', $component->getSiteId());
}

if (!empty($arParams['TEMPLATE_THEME']))
{
	if (!is_file(Main\Application::getDocumentRoot().'/bitrix/css/main/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
	{
		$arParams['TEMPLATE_THEME'] = 'blue';
	}
}

$arParams['ALLOW_USER_PROFILES'] = $arParams['ALLOW_USER_PROFILES'] === 'Y' ? 'Y' : 'N';
$arParams['SKIP_USELESS_BLOCK'] = $arParams['SKIP_USELESS_BLOCK'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['SHOW_ORDER_BUTTON']))
{
	$arParams['SHOW_ORDER_BUTTON'] = 'final_step';
}

$arParams['HIDE_ORDER_DESCRIPTION'] = isset($arParams['HIDE_ORDER_DESCRIPTION']) && $arParams['HIDE_ORDER_DESCRIPTION'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_TOTAL_ORDER_BUTTON'] = $arParams['SHOW_TOTAL_ORDER_BUTTON'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] = $arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_PAY_SYSTEM_INFO_NAME'] = $arParams['SHOW_PAY_SYSTEM_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_LIST_NAMES'] = $arParams['SHOW_DELIVERY_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_INFO_NAME'] = $arParams['SHOW_DELIVERY_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_PARENT_NAMES'] = $arParams['SHOW_DELIVERY_PARENT_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_STORES_IMAGES'] = $arParams['SHOW_STORES_IMAGES'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['BASKET_POSITION']) || !in_array($arParams['BASKET_POSITION'], array('before', 'after')))
{
	$arParams['BASKET_POSITION'] = 'after';
}

$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['SHOW_BASKET_HEADERS'] = $arParams['SHOW_BASKET_HEADERS'] === 'Y' ? 'Y' : 'N';
$arParams['HIDE_DETAIL_PAGE_URL'] = isset($arParams['HIDE_DETAIL_PAGE_URL']) && $arParams['HIDE_DETAIL_PAGE_URL'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERY_FADE_EXTRA_SERVICES'] = $arParams['DELIVERY_FADE_EXTRA_SERVICES'] === 'Y' ? 'Y' : 'N';

$arParams['SHOW_COUPONS'] = isset($arParams['SHOW_COUPONS']) && $arParams['SHOW_COUPONS'] === 'N' ? 'N' : 'Y';

if ($arParams['SHOW_COUPONS'] === 'N')
{
	$arParams['SHOW_COUPONS_BASKET'] = 'N';
	$arParams['SHOW_COUPONS_DELIVERY'] = 'N';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = 'N';
}
else
{
	$arParams['SHOW_COUPONS_BASKET'] = isset($arParams['SHOW_COUPONS_BASKET']) && $arParams['SHOW_COUPONS_BASKET'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_DELIVERY'] = isset($arParams['SHOW_COUPONS_DELIVERY']) && $arParams['SHOW_COUPONS_DELIVERY'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = isset($arParams['SHOW_COUPONS_PAY_SYSTEM']) && $arParams['SHOW_COUPONS_PAY_SYSTEM'] === 'N' ? 'N' : 'Y';
}

$arParams['SHOW_NEAREST_PICKUP'] = $arParams['SHOW_NEAREST_PICKUP'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERIES_PER_PAGE'] = isset($arParams['DELIVERIES_PER_PAGE']) ? intval($arParams['DELIVERIES_PER_PAGE']) : 9;
$arParams['PAY_SYSTEMS_PER_PAGE'] = isset($arParams['PAY_SYSTEMS_PER_PAGE']) ? intval($arParams['PAY_SYSTEMS_PER_PAGE']) : 9;
$arParams['PICKUPS_PER_PAGE'] = isset($arParams['PICKUPS_PER_PAGE']) ? intval($arParams['PICKUPS_PER_PAGE']) : 5;
$arParams['SHOW_PICKUP_MAP'] = $arParams['SHOW_PICKUP_MAP'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_MAP_IN_PROPS'] = $arParams['SHOW_MAP_IN_PROPS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_YM_GOALS'] = $arParams['USE_YM_GOALS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

$useDefaultMessages = !isset($arParams['USE_CUSTOM_MAIN_MESSAGES']) || $arParams['USE_CUSTOM_MAIN_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_BLOCK_NAME']))
{
	$arParams['MESS_AUTH_BLOCK_NAME'] = Loc::getMessage('AUTH_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REG_BLOCK_NAME']))
{
	$arParams['MESS_REG_BLOCK_NAME'] = Loc::getMessage('REG_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BASKET_BLOCK_NAME']))
{
	$arParams['MESS_BASKET_BLOCK_NAME'] = Loc::getMessage('BASKET_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGION_BLOCK_NAME']))
{
	$arParams['MESS_REGION_BLOCK_NAME'] = Loc::getMessage('REGION_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PAYMENT_BLOCK_NAME']))
{
	$arParams['MESS_PAYMENT_BLOCK_NAME'] = Loc::getMessage('PAYMENT_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_BLOCK_NAME']))
{
	$arParams['MESS_DELIVERY_BLOCK_NAME'] = Loc::getMessage('DELIVERY_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BUYER_BLOCK_NAME']))
{
	$arParams['MESS_BUYER_BLOCK_NAME'] = Loc::getMessage('BUYER_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BACK']))
{
	$arParams['MESS_BACK'] = Loc::getMessage('BACK_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_FURTHER']))
{
	$arParams['MESS_FURTHER'] = Loc::getMessage('FURTHER_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_EDIT']))
{
	$arParams['MESS_EDIT'] = Loc::getMessage('EDIT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ORDER']))
{
	$arParams['MESS_ORDER'] = $arParams['~MESS_ORDER'] = Loc::getMessage('ORDER_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PRICE']))
{
	$arParams['MESS_PRICE'] = Loc::getMessage('PRICE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PERIOD']))
{
	$arParams['MESS_PERIOD'] = Loc::getMessage('PERIOD_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NAV_BACK']))
{
	$arParams['MESS_NAV_BACK'] = Loc::getMessage('NAV_BACK_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NAV_FORWARD']))
{
	$arParams['MESS_NAV_FORWARD'] = Loc::getMessage('NAV_FORWARD_DEFAULT');
}

$useDefaultMessages = !isset($arParams['USE_CUSTOM_ADDITIONAL_MESSAGES']) || $arParams['USE_CUSTOM_ADDITIONAL_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_PRICE_FREE']))
{
	$arParams['MESS_PRICE_FREE'] = Loc::getMessage('PRICE_FREE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ECONOMY']))
{
	$arParams['MESS_ECONOMY'] = Loc::getMessage('ECONOMY_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGISTRATION_REFERENCE']))
{
	$arParams['MESS_REGISTRATION_REFERENCE'] = Loc::getMessage('REGISTRATION_REFERENCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_1']))
{
	$arParams['MESS_AUTH_REFERENCE_1'] = Loc::getMessage('AUTH_REFERENCE_1_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_2']))
{
	$arParams['MESS_AUTH_REFERENCE_2'] = Loc::getMessage('AUTH_REFERENCE_2_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_3']))
{
	$arParams['MESS_AUTH_REFERENCE_3'] = Loc::getMessage('AUTH_REFERENCE_3_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ADDITIONAL_PROPS']))
{
	$arParams['MESS_ADDITIONAL_PROPS'] = Loc::getMessage('ADDITIONAL_PROPS_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_USE_COUPON']))
{
	$arParams['MESS_USE_COUPON'] = Loc::getMessage('USE_COUPON_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_COUPON']))
{
	$arParams['MESS_COUPON'] = Loc::getMessage('COUPON_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PERSON_TYPE']))
{
	$arParams['MESS_PERSON_TYPE'] = Loc::getMessage('PERSON_TYPE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PROFILE']))
{
	$arParams['MESS_SELECT_PROFILE'] = Loc::getMessage('SELECT_PROFILE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGION_REFERENCE']))
{
	$arParams['MESS_REGION_REFERENCE'] = Loc::getMessage('REGION_REFERENCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PICKUP_LIST']))
{
	$arParams['MESS_PICKUP_LIST'] = Loc::getMessage('PICKUP_LIST_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NEAREST_PICKUP_LIST']))
{
	$arParams['MESS_NEAREST_PICKUP_LIST'] = Loc::getMessage('NEAREST_PICKUP_LIST_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PICKUP']))
{
	$arParams['MESS_SELECT_PICKUP'] = Loc::getMessage('SELECT_PICKUP_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_INNER_PS_BALANCE']))
{
	$arParams['MESS_INNER_PS_BALANCE'] = Loc::getMessage('INNER_PS_BALANCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ORDER_DESC']))
{
	$arParams['MESS_ORDER_DESC'] = Loc::getMessage('ORDER_DESC_DEFAULT');
}

$useDefaultMessages = !isset($arParams['USE_CUSTOM_ERROR_MESSAGES']) || $arParams['USE_CUSTOM_ERROR_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_PRELOAD_ORDER_TITLE']))
{
	$arParams['MESS_PRELOAD_ORDER_TITLE'] = Loc::getMessage('PRELOAD_ORDER_TITLE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SUCCESS_PRELOAD_TEXT']))
{
	$arParams['MESS_SUCCESS_PRELOAD_TEXT'] = Loc::getMessage('SUCCESS_PRELOAD_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_FAIL_PRELOAD_TEXT']))
{
	$arParams['MESS_FAIL_PRELOAD_TEXT'] = Loc::getMessage('FAIL_PRELOAD_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TITLE']))
{
	$arParams['MESS_DELIVERY_CALC_ERROR_TITLE'] = Loc::getMessage('DELIVERY_CALC_ERROR_TITLE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TEXT']))
{
	$arParams['MESS_DELIVERY_CALC_ERROR_TEXT'] = Loc::getMessage('DELIVERY_CALC_ERROR_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']))
{
	$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] = Loc::getMessage('PAY_SYSTEM_PAYABLE_ERROR_DEFAULT');
}

$scheme = $request->isHttps() ? 'https' : 'http';

switch (LANGUAGE_ID)
{
	case 'ru':
	$locale = 'ru-RU'; break;
	case 'ua':
	$locale = 'ru-UA'; break;
	case 'tk':
	$locale = 'tr-TR'; break;
	default:
	$locale = 'en-US'; break;
}

$this->addExternalCss('/bitrix/css/main/bootstrap.css');
$APPLICATION->SetAdditionalCSS('/bitrix/css/main/themes/'.$arParams['TEMPLATE_THEME'].'/style.css', true);
$APPLICATION->SetAdditionalCSS($templateFolder.'/style.css', true);
$this->addExternalJs($templateFolder.'/order_ajax.js');
\Bitrix\Sale\PropertyValueCollection::initJs();
$this->addExternalJs($templateFolder.'/script.js');
?>
<NOSCRIPT>
	<div style="color:red"><?=Loc::getMessage('SOA_NO_JS')?></div>
</NOSCRIPT>
<?


if(CModule::IncludeModule('iblock')) {
  $arSort= Array("NAME"=>"ASC");
  $arSelect = Array("ID","NAME","PREVIEW_TEXT");
  $arFilter = Array(
      "IBLOCK_ID" => array(44), 
      "ID" => "36533");

  $res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
  while($ob = $res->GetNextElement()){
      $arFields = $ob->GetFields();
      if (!empty($arFields['PREVIEW_TEXT'])) {
		$our_text = $arFields['PREVIEW_TEXT'];
      }
  }
}

if ($request->get('ORDER_ID') <> '')
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/confirm.php');
}
elseif ($arParams['DISABLE_BASKET_REDIRECT'] === 'Y' && $arResult['SHOW_EMPTY_BASKET'])
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/empty.php');
}
else
{
	Main\UI\Extension::load('phone_auth');

	$hideDelivery = empty($arResult['DELIVERY']);
	?>
	<div class="wide w-100 mx-md-auto">
		<div class="back w-100 d-md-block d-none">
			<a href="/personal/cart/" class="d-flex align-items-center">
				<span>
					<svg fill="#D0A550" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0)">
							<path d="M20.4911 11.0625H3.20824L6.49717 7.78949C6.86416 7.42425 6.86557 6.83067 6.50032 6.46368C6.13507 6.09665 5.54144 6.09529 5.17446 6.4605L0.27583 11.3355L0.274987 11.3364C-0.0910604 11.7016 -0.0922322 12.2971 0.274893 12.6636L0.275737 12.6645L5.17436 17.5395C5.5413 17.9046 6.13492 17.9034 6.50022 17.5363C6.86547 17.1693 6.86407 16.5757 6.49708 16.2105L3.20824 12.9375H20.4911C21.0089 12.9375 21.4286 12.5178 21.4286 12C21.4286 11.4822 21.0089 11.0625 20.4911 11.0625Z"></path>
						</g>
						<defs>
							<clipPath id="clip0">
								<rect width="24" height="24" fill="white"></rect>
							</clipPath>
						</defs>
					</svg>
				</span>
				<span class="text-gold font-weight-500 text-uppercase ml-2">Корзина</span>
			</a>
		</div>
		<h1 class="title d-md-block d-none font-weight-800">Оформление заказа</h1>
		<form action="<?=POST_FORM_ACTION_URI?>" method="POST" name="ORDER_FORM" id="bx-soa-order-form" enctype="multipart/form-data">
			<?
			echo bitrix_sessid_post();

			if ($arResult['PREPAY_ADIT_FIELDS'] <> '')
			{
				echo $arResult['PREPAY_ADIT_FIELDS'];
			}
			?>
			<input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="saveOrderAjax">
			<input type="hidden" name="location_type" value="code">
			<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult['BUYER_STORE']?>">
			<div id="bx-soa-order" class="row bx-<?=$arParams['TEMPLATE_THEME']?>" style="opacity: 0">
				<!--	MAIN BLOCK	-->

				<div class="col-sm-9 bx-soa">
					<div id="bx-soa-main-notifications">
						<div class="alert alert-danger" style="display:none"></div>
						<div data-type="informer" style="display:none"></div>
					</div>
					<!--	AUTH BLOCK	-->
					<div id="bx-soa-auth" class="bx-soa-section bx-soa-auth" style="display:none">
						<div class="bx-soa-section-title-container">
							<h2 class="bx-soa-section-title col-sm-9">
								<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_AUTH_BLOCK_NAME']?>
							</h2>
						</div>
						<div class="bx-soa-section-content container-fluid"></div>
					</div>

					<!--	DUPLICATE MOBILE ORDER SAVE BLOCK	-->
					<div id="bx-soa-total-mobile" style="margin-bottom: 6px;"></div>

					<? if ($arParams['BASKET_POSITION'] === 'before'): ?>
						<!--	BASKET ITEMS BLOCK	-->
						<div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BASKET_BLOCK_NAME']?>
								</h2>
								<div class="col-xs-12 col-sm-3 text-right"><a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
					<? endif ?>
					<!--	BUYER PROPS BLOCK	-->
					<div id="bx-soa-properties" data-visited="false" class="bx-soa-section fix-mobile-padding bx-active">
						<div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
							<div class="bx-soa-section-title d-flex justify-content-between flex-wrap w-100" data-entity="section-title">
								<h2 class="title-5 font-weight-bold text-uppercase bg-light w-100 px-2">
									1. <?=$arParams['MESS_BUYER_BLOCK_NAME']?>
								</h2>
							</div>
							<div class="col-xs-12 col-sm-3 text-right"></div><?/*<a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a>*/?>
						</div>
						<div class="bx-soa-section-content container-fluid"></div>
					</div>

					<!--	REGION BLOCK	-->
					<div id="bx-soa-region" data-visited="false" class="bx-soa-section region bx-active hidden">
						<div class="bx-soa-section-title-container">
							<h2 class="bx-soa-section-title col-sm-9">
								<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_REGION_BLOCK_NAME']?>
							</h2>
							<div class="col-xs-12 col-sm-3 text-right"></div><?/*<a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a>*/?>
						</div>
						<div class="bx-soa-section-content container-fluid"></div>
					</div>




					<? if ($arParams['DELIVERY_TO_PAYSYSTEM'] != 'p2d'): ?>

						<!--	PAY SYSTEMS BLOCK	-->
						<div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section bx-active">
							<div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
								<div class="bx-soa-section-title" data-entity="section-title">
									<h2 class="title-5 font-weight-bold text-uppercase bg-light w-100 px-2">
										2. <?=$arParams['MESS_PAYMENT_BLOCK_NAME']?>
									</h2>
								</div>
								<div class="col-xs-12 col-sm-6 text-right font-weight-bold">
									<?
									if (!empty($our_text)){
										echo $our_text;
									}
									?>
								</div><?/*<a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a>*/?>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
						<!--	DELIVERY BLOCK	-->
						<div id="bx-soa-delivery" data-visited="false" class="bx-soa-section bx-active" <?=($hideDelivery ? 'style="display:none"' : '')?>>
							<div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
								<div class="bx-soa-section-title" data-entity="section-title">
									<h2 class="title-5 font-weight-bold text-uppercase bg-light w-100 px-2">
										3. <?=$arParams['MESS_DELIVERY_BLOCK_NAME']?>
									</h2>
								</div>
								<div class="col-xs-12 col-sm-3 text-right"></div><?/*<a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a>*/?>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
						<!--	PICKUP BLOCK	-->
						<div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span>
								</h2>
								<div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div><?/**/?>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
					<? else: ?>

						<!--	DELIVERY BLOCK	-->
						<div id="bx-soa-delivery" data-visited="false" class="bx-soa-section bx-active" <?=($hideDelivery ? 'style="display:none"' : '')?>>
							<div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
								<div class="bx-soa-section-title" data-entity="section-title">
									<h2 class="title-5 font-weight-bold text-uppercase bg-light w-100 px-2">
										2. <?=$arParams['MESS_DELIVERY_BLOCK_NAME']?>
									</h2>
								</div>
								<div class="col-xs-12 col-sm-3 text-right"></div><?/*<a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a>*/?>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
						<!--	PICKUP BLOCK	-->
						<div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span>
								</h2>
								<div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div><?/**/?>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
						<!--	PAY SYSTEMS BLOCK	-->
						<div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section fix-mobile-padding bx-active mt-4">
							<div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
								<div class="bx-soa-section-title d-flex justify-content-between flex-wrap w-100" data-entity="section-title">
									<h2 class="title-5 font-weight-bold text-uppercase bg-light w-100 px-2">
										3. <?=$arParams['MESS_PAYMENT_BLOCK_NAME']?>
									</h2>
								</div>
								<div class="col-xs-12 col-sm-3 text-right"></div><?/*<a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a>*/?>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
					<? endif ?>
					<!--	BUYER PROPS BLOCK	-->
					<!--				<div id="bx-soa-properties" data-visited="false" class="bx-soa-section bx-active">-->
						<!--					<div class="bx-soa-section-title-container">-->
							<!--						<h2 class="bx-soa-section-title col-sm-9">-->
								<!--							<span class="bx-soa-section-title-count"></span>--><?//=$arParams['MESS_BUYER_BLOCK_NAME']?>
								<!--						</h2>-->
								<!--						<div class="col-xs-12 col-sm-3 text-right">iv>--><?/*<a href="" class="bx-soa-editstep">--><?//=$arParams['MESS_EDIT']?><!--</a></d*/?>
								<!--					</div>-->
								<!--					<div class="bx-soa-section-content container-fluid"></div>-->
								<!--				</div>-->

								<? if ($arParams['BASKET_POSITION'] === 'after'): ?>
									<!--	BASKET ITEMS BLOCK	-->
									<div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active hidden">
										<div class="bx-soa-section-title-container">
											<h2 class="bx-soa-section-title col-sm-9">
												<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BASKET_BLOCK_NAME']?>
											</h2>
											<div class="col-xs-12 col-sm-3 text-right"><a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
										</div>
										<div class="bx-soa-section-content container-fluid"></div>
									</div>
								<? endif ?>

								<!--	ORDER SAVE BLOCK	-->
								<div id="bx-soa-orderSave">
									<div class="checkbox">
										<?
										if ($arParams['USER_CONSENT'] === 'Y')
										{
											$APPLICATION->IncludeComponent(
												'bitrix:main.userconsent.request',
												'',
												array(
													'ID' => $arParams['USER_CONSENT_ID'],
													'IS_CHECKED' => $arParams['USER_CONSENT_IS_CHECKED'],
													'IS_LOADED' => $arParams['USER_CONSENT_IS_LOADED'],
													'AUTO_SAVE' => 'N',
													'SUBMIT_EVENT_NAME' => 'bx-soa-order-save',
													'REPLACE' => array(
														'button_caption' => isset($arParams['~MESS_ORDER']) ? $arParams['~MESS_ORDER'] : $arParams['MESS_ORDER'],
														'fields' => $arResult['USER_CONSENT_PROPERTY_DATA']
													)
												)
											);
										}
										?>
									</div>
									<a href="javascript:void(0)" style="margin: 10px 0" class="pull-right btn btn-default btn-lg hidden-xs" data-save-button="true">
										<?=$arParams['MESS_ORDER']?>
									</a>
								</div>

								<div style="display: none;">
									<div id='bx-soa-basket-hidden' class="bx-soa-section"></div>
									<div id='bx-soa-region-hidden' class="bx-soa-section"></div>
									<div id='bx-soa-paysystem-hidden' class="bx-soa-section"></div>
									<div id='bx-soa-delivery-hidden' class="bx-soa-section"></div>
									<div id='bx-soa-pickup-hidden' class="bx-soa-section"></div>
									<div id="bx-soa-properties-hidden" class="bx-soa-section"></div>
									<div id="bx-soa-auth-hidden" class="bx-soa-section">
										<div class="bx-soa-section-content container-fluid reg"></div>
									</div>
								</div>
							</div>

							<!--	SIDEBAR BLOCK	-->
							<div id="bx-soa-total" class="col-sm-3 bx-soa-sidebar">
								<div class="bx-soa-cart-total-ghost"></div>
								<div class="bx-soa-cart-total"></div>
							</div>
						</div>
					</form>

					<div id="bx-soa-saved-files" style="display:none"></div>
					<div id="bx-soa-soc-auth-services" style="display:none">
						<?
						$arServices = false;
						$arResult['ALLOW_SOCSERV_AUTHORIZATION'] = Main\Config\Option::get('main', 'allow_socserv_authorization', 'Y') != 'N' ? 'Y' : 'N';
						$arResult['FOR_INTRANET'] = false;

						if (Main\ModuleManager::isModuleInstalled('intranet') || Main\ModuleManager::isModuleInstalled('rest'))
							$arResult['FOR_INTRANET'] = true;

						if (Main\Loader::includeModule('socialservices') && $arResult['ALLOW_SOCSERV_AUTHORIZATION'] === 'Y')
						{
							$oAuthManager = new CSocServAuthManager();
							$arServices = $oAuthManager->GetActiveAuthServices(array(
								'BACKURL' => $this->arParams['~CURRENT_PAGE'],
								'FOR_INTRANET' => $arResult['FOR_INTRANET'],
							));

							if (!empty($arServices))
							{
								$APPLICATION->IncludeComponent(
									'bitrix:socserv.auth.form',
									'flat',
									array(
										'AUTH_SERVICES' => $arServices,
										'AUTH_URL' => $arParams['~CURRENT_PAGE'],
										'POST' => $arResult['POST'],
									),
									$component,
									array('HIDE_ICONS' => 'Y')
								);
							}
						}
						?>
					</div>

					<div style="display: none">
						<?
		// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it
						$APPLICATION->IncludeComponent(
							'bitrix:sale.location.selector.steps',
							'.default',
							array(),
							false
						);
						$APPLICATION->IncludeComponent(
							'bitrix:sale.location.selector.search',
							'.default',
							array(),
							false
						);
						?>
					</div>
					<?
					$signer = new Main\Security\Sign\Signer;
					$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');
					$messages = Loc::loadLanguageFile(__FILE__);
					?>
					<script>
						BX.message(<?=CUtil::PhpToJSObject($messages)?>);
						BX.Sale.OrderAjaxComponent.init({
							result: <?=CUtil::PhpToJSObject($arResult['JS_DATA'])?>,
							locations: <?=CUtil::PhpToJSObject($arResult['LOCATIONS'])?>,
							params: <?=CUtil::PhpToJSObject($arParams)?>,
							signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
							siteID: '<?=CUtil::JSEscape($component->getSiteId())?>',
							ajaxUrl: '<?=CUtil::JSEscape($component->getPath().'/ajax.php')?>',
							templateFolder: '<?=CUtil::JSEscape($templateFolder)?>',
							propertyValidation: true,
							showWarnings: true,
							pickUpMap: {
								defaultMapPosition: {
									lat: 55.76,
									lon: 37.64,
									zoom: 7
								},
								secureGeoLocation: false,
								geoLocationMaxTime: 5000,
								minToShowNearestBlock: 3,
								nearestPickUpsToShow: 3
							},
							propertyMap: {
								defaultMapPosition: {
									lat: 55.76,
									lon: 37.64,
									zoom: 7
								}
							},
							orderBlockId: 'bx-soa-order',
							authBlockId: 'bx-soa-auth',
							basketBlockId: 'bx-soa-basket',
							regionBlockId: 'bx-soa-region',
							paySystemBlockId: 'bx-soa-paysystem',
							deliveryBlockId: 'bx-soa-delivery',
							pickUpBlockId: 'bx-soa-pickup',
							propsBlockId: 'bx-soa-properties',
							totalBlockId: 'bx-soa-total'
						});
					</script>
					<script>
						<?
		// spike: for children of cities we place this prompt
						$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
						?>
						BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
							'source' => $component->getPath().'/get.php',
							'cityTypeId' => intval($city['ID']),
							'messages' => array(
								'otherLocation' => '--- '.Loc::getMessage('SOA_OTHER_LOCATION'),
				'moreInfoLocation' => '--- '.Loc::getMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
				'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.Loc::getMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.Loc::getMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
					'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
					'#ANCHOR_END#' => '</a>'
				)).'</div>'
			)
							))?>);
						</script>
						<?
						if ($arParams['SHOW_PICKUP_MAP'] === 'Y' || $arParams['SHOW_MAP_IN_PROPS'] === 'Y')
						{
							if ($arParams['PICKUP_MAP_TYPE'] === 'yandex')
							{
								$this->addExternalJs($templateFolder.'/scripts/yandex_maps.js');
								$apiKey = htmlspecialcharsbx(Main\Config\Option::get('fileman', 'yandex_map_api_key', ''));
								?>
								<script>
									(function bx_ymaps_waiter(){
										if (typeof ymaps !== 'undefined' && BX.Sale && BX.Sale.OrderAjaxComponent)
											ymaps.ready(BX.proxy(BX.Sale.OrderAjaxComponent.initMaps, BX.Sale.OrderAjaxComponent));
										else
											setTimeout(bx_ymaps_waiter, 100);
									})();
								</script>
								<?
							}

							if ($arParams['PICKUP_MAP_TYPE'] === 'google')
							{
								$this->addExternalJs($templateFolder.'/scripts/google_maps.js');
								$apiKey = htmlspecialcharsbx(Main\Config\Option::get('fileman', 'google_map_api_key', ''));
								?>
								<script async defer
								src="<?=$scheme?>://maps.googleapis.com/maps/api/js?key=<?=$apiKey?>&callback=bx_gmaps_waiter">
							</script>
							<script>
								function bx_gmaps_waiter()
								{
									if (BX.Sale && BX.Sale.OrderAjaxComponent)
										BX.Sale.OrderAjaxComponent.initMaps();
									else
										setTimeout(bx_gmaps_waiter, 100);
								}
							</script>
							<?
						}
					}

					if ($arParams['USE_YM_GOALS'] === 'Y')
					{
						?>
						<script>
							(function bx_counter_waiter(i){
								i = i || 0;
								if (i > 50)
									return;

								if (typeof window['yaCounter<?=$arParams['YM_GOALS_COUNTER']?>'] !== 'undefined')
									BX.Sale.OrderAjaxComponent.reachGoal('initialization');
								else
									setTimeout(function(){bx_counter_waiter(++i)}, 100);
							})();
						</script>
						<?
					}
				}

				?>
			</div>
			<div class="bx-soa-custom-hidden">

			</div>