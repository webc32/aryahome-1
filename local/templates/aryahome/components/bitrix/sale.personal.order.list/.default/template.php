<?

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $code => $error)
	{
		if ($code !== $component::E_NOT_AUTHORIZED)
			ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		?>
		<div class="row">
			<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
				<div class="alert alert-danger"><?=$arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]?></div>
			</div>
			<? $authListGetParams = array(); ?>
			<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
				<?$APPLICATION->AuthForm('', false, false, 'N', false);?>
			</div>
		</div>
		<?
	}

}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
	?>
	<div class="w-100 fix-mobile-padding mb-3">
		<?
		$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
		$clearFromLink = array("filter_history","filter_status","show_all", "show_canceled");

		if ($nothing || $_REQUEST["filter_history"] == 'N')
		{
			?>
			<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?></a>
			<?
		}
		if ($_REQUEST["filter_history"] == 'Y')
		{
			?>
			<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_CUR_ORDERS")?></a>
			<?
			if ($_REQUEST["show_canceled"] == 'Y')
			{
				?>
				<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?></a>
				<?
			}
			else
			{
				?>
				<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_CANCELED")?></a>
				<?
			}
		}
		?>
	</div>
	<?
	if (!count($arResult['ORDERS']))
	{
		?>
		<div class="w-100 fix-mobile-padding mb-3">
			<a href="<?=htmlspecialcharsbx($arParams['PATH_TO_CATALOG'])?>" class="mr-4"><?=Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG')?></a>
		</div>
		<?
	}

	$paymentChangeData = array();
	$orderHeaderStatus = null;

	?>
	<div class="w-100 fix-mobile-padding mb-3">
		<h2><?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx('Приняты, в обработке')?>&raquo;</h2>
	</div>
	<?

	foreach ($arResult['ORDERS'] as $key => $order)
	{
		
		?>
		<div class="case history col-12 mb-4">
			<div class="form border-gray d-flex flex-wrap mb-4 mb-md-3">
		        <div class="col-12 col-md-9">
		            <div class="row">
		                <div class="w-100 px-2 py-2 px-md-4 py-md-4">
		                    <div class="d-flex justify-content-between w-100">
		                        <h3 class="number text-gold font-weight-bold"><?=Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER']?></h3>
		                        <div class="date font-weight-500"><span class="text-gray mr-2 d-none d-md-inline">Дата: </span> <?=$order['ORDER']['DATE_INSERT_FORMATED']?></div>
		                    </div>
		                    <?
		                    foreach ($order[BASKET_ITEMS] as $product) {?>
		                    	<?
		                    	$PREVIEW_PICTURE='';
		                    	$arSelect = Array("ID", "PREVIEW_PICTURE","DETAIL_PAGE_URL");
								$arFilter = Array("IBLOCK_ID"=>3,"ID"=>$product[PRODUCT_ID]);
								$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
								while($ob = $res->GetNextElement())
								{
								 $arFields = $ob->GetFields();
								 $PREVIEW_PICTURE = CFile::GetPath($arFields["PREVIEW_PICTURE"]);
								}
		                    	?>
			                    <div class="d-flex justify-content-between w-100 mt-4">
			                        <div class="img">
			                            <img src="<?=$PREVIEW_PICTURE?>" width="98px">
			                        </div>
			                        <div class="name col d-flex align-items-md-center">
			                            <div class="position-relative w-100 pl-md-3">
			                                <div class="font-weight-500"><a href="<?=$arFields['DETAIL_PAGE_URL']?>"><?=$product[NAME]?></a></div>
			                                <div class="quantity"><span class="text-gray mr-3 d-none d-md-inline">Количество:</span><span class="text-gray mr-3 d-inline d-md-none">Кол-во:</span><?=$product[QUANTITY]?> шт.</div>
			                            </div>
			                        </div>
			                        <div class="price d-flex align-items-md-center">
			                            <div class="position-relative w-100">
			                                <span class="font-weight-bold"><?=round($product[PRICE])?> </span> <del>Р</del>
			                            </div>
			                        </div>
			                    </div>
		                    <?}?>
		                    <div class="d-flex flex-wrap justify-content-between w-100">
		                        <div class="col-12 col-md-8"></div>
		                        <div class="total col-12 col-md-4 py-3 mt-4">
		                            <div class="row justify-content-between my-2">
		                                <span class="total-note font-weight-500">Итого</span>
		                                <div class="total-price"><?=$order['ORDER']['FORMATED_PRICE']?></div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <div class="col-12 col-md-3 bg-light d-flex flex-column justify-content-between px-3 py-4">
		            <div>
		                <div class="d-flex w-100 justify-content-between mb-3">
		                    <span class="note">Трек номер: </span>
		                    <span class="value font-weight-500">########</span>
		                </div>
		                <?
						foreach ($order['PAYMENT'] as $payment){
							if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y')
							{
								$paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
									"order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
									"payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
									"allow_inner" => $arParams['ALLOW_INNER'],
									"refresh_prices" => $arParams['REFRESH_PRICES'],
									"path_to_payment" => $arParams['PATH_TO_PAYMENT'],
									"only_inner_full" => $arParams['ONLY_INNER_FULL'],
									"return_url" => $arResult['RETURN_URL'],
								);
							}
						?>
		                <div class="d-flex w-100 justify-content-between mb-1">
		                    <span class="note">Способ оплаты: </span>
		                    <div>
		                        <span class="value font-weight-500"><?=$payment['PAY_SYSTEM_NAME']?></span>
		                    </div>
		                </div>
		                <div class="d-flex justify-content-end mb-4">
		                	<div class="position-relative">
			                    <div class="pay-status border-gold text-gold text-center font-weight-500 px-4 py-1 mb-1">
			                    	<?if ($payment['PAID'] === 'Y')
									{
										?>
										<?=Loc::getMessage('SPOL_TPL_PAID')?>
										<?
									}
									elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
									{
										?>
										<?=Loc::getMessage('SPOL_TPL_RESTRICTED_PAID')?>
										<?
									}
									else
									{
										?>
										<?=Loc::getMessage('SPOL_TPL_NOTPAID')?>
										<?
									}?>
			                	</div>
		                		<?
	                        	if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y' && $payment['ACTION_FILE'] !== 'cash')
								{
									?><div class="pay-status bg-active text-center font-weight-500 px-4 py-1"><?
									if ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
									{
										?>
										<a href="/personal/order/make/?ORDER_ID=<?=$order['ORDER']['ACCOUNT_NUMBER']?>" class="text-white"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
										<?
									}
									else
									{
										?>
										<a href="/personal/order/make/?ORDER_ID=<?=$order['ORDER']['ACCOUNT_NUMBER']?>" class="text-white"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
										<?
									}
									?></div><?
								}
								?>
							</div>
		                </div>
		                <?}?>
		                <?
		                foreach ($order['SHIPMENT'] as $shipment){
		                ?>
		                <div class="d-flex w-100 justify-content-between mb-3">
		                    <span class="note">Доставка: </span>
		                    <span class="value font-weight-500 text-right"><?=$shipment[DELIVERY_NAME]?></span>
		                </div>
		                <?}?>
		            </div>
		            <div class="d-flex justify-content-end mb-3">
		                <div class="order-status border-gold text-gold font-weight-bold d-inline-block text-center w-100 py-3"><?=$arResult['INFO']['STATUS'][$order['ORDER']['STATUS_ID']]['NAME'];?></div>
		            </div>
					<div class="text-center">
						<a class="d-none d-md-block border-gray text-gray w-100 py-3 px-4 px-md-5 mb-3" href="<?=$order["ORDER"]["URL_TO_CANCEL"]?>"><?= GetMessage("SPOL_CANCEL") ?></a>
					</div>
		        </div>
		    </div>
		</div>
		<?
	}

	echo $arResult["NAV_STRING"];

	if ($_REQUEST["filter_history"] !== 'Y')
	{
		$javascriptParams = array(
			"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
			"templateFolder" => CUtil::JSEscape($templateFolder),
			"templateName" => $this->__component->GetTemplateName(),
			"paymentList" => $paymentChangeData,
			"returnUrl" => CUtil::JSEscape($arResult["RETURN_URL"]),
		);
		$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
		?>
		<script>
			BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
		</script>
		<?
	}
}
?>
