<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<? if (!empty($arResult["ORDER"])): ?>

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ORDER_SUC", array(
					"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
					"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
				))?>
				<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
					<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
						"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
					))?>
				<? endif ?>
				<? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
					<br /><br />
					<?=Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']])?>
				<? endif; ?>
			</td>
		</tr>
	</table>

	<?
	if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
	{
		if (!empty($arResult["PAYMENT"]))
		{
			foreach ($arResult["PAYMENT"] as $payment)
			{
				if ($payment["PAID"] != 'Y')
				{
					if (!empty($arResult['PAY_SYSTEM_LIST'])
						&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

						if (empty($arPaySystem["ERROR"]))
						{
							?>
							<br /><br />

							<table class="sale_order_full_table">
								<tr>
									<td class="ps_logo">
										<div class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></div>
										<?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
										<div class="paysystem_name"><?=$arPaySystem["NAME"] ?></div>
										<br/>
									</td>
								</tr>
								<tr>
									<td>
										<? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
											<?
											$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
											$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
											?>
											<script>
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
											</script>
										<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
										<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
										<br/>
											<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
										<? endif ?>
										<? else: ?>
											<?=$arPaySystem["BUFFERED_OUTPUT"]?>
										<? endif ?>
									</td>
								</tr>
							</table>

							<?
						}
						else
						{
							?>
							<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
							<?
						}
					}
					else
					{
						?>
						<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<br /><strong><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></strong>
		<?
	}
	?>
<?
if($_GET['test'] == 'y'){
	$orderID = $arResult["ORDER"]["ID"];
	
	$dbItemsInOrder = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $orderID));

	$arItems =array();
	while($arIt = $dbItemsInOrder->fetch()){
		$arItems[]= array("id"=>$arIt["ID"],"name"=>$arIt["NAME"], "price" => preg_replace("/\..*$/","",$arIt["PRICE"]), "quantity" => $arIt["QUANTITY"]);
	}
	
	foreach ($arItems as $product) {
		
		$res = CIBlockElement::GetList(array(), array("ID" => $product['id']), false, false, array("SECTION_ID"));{  
			$res = CIBlockSection::GetList(array(), array("ID" => $arRes["SECTION_ID"]), false, array("CODE"));   
			if($arRes = $res->GetNext())   {      echo $arRes["SECTION_ID"];  $IBLOCK_SECTION_ID = $arRes["SECTION_ID"]; }}
		
		$nav = CIBlockSection::GetNavChain(false, $IBLOCK_SECTION_ID);
		   while($v = $nav->GetNext()) {

		       if($v['ID']) {
			   Bitrix\Main\Diag\Debug::writeToFile('ID => ' . $v['ID']);
			   Bitrix\Main\Diag\Debug::writeToFile('NAME => ' . $v['NAME']);
			   Bitrix\Main\Diag\Debug::writeToFile('DEPTH_LEVEL => ' . $v['DEPTH_LEVEL']);
			   $arItemSection[] = $v['NAME'];
		       }
		   }
		print_r($arItemSection);
	}
	
}
?>
<? else: ?>

	<b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b>
	<br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>
<? endif ?>


<?
if(!$_SESSION["EXISTS_ORDER"][$arResult["ORDER"]["ID"]]):
	$orderID = $arResult["ORDER"]["ID"];

	if( $orderID ){
		$resOrder = CSaleOrderPropsValue::GetList( array("DATE_UPDATE" => "DESC"), array( "ORDER_ID" => $orderID ) );

		while( $item = $resOrder->fetch() ){
			$arOrder[$item["CODE"]] = $item;
		}

		$dbItemsInOrder = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $orderID));

		$arItems =array();
		while($arIt = $dbItemsInOrder->fetch()){
			$arItems[]= array("id"=>$arIt["ID"],"name"=>$arIt["NAME"], "price" => preg_replace("/\..*$/","",$arIt["PRICE"]), "quantity" => $arIt["QUANTITY"]);
		}
		$arOrderSum = CSaleOrder::GetByID($orderID);
		
	}
		
	$couponList = \Bitrix\Sale\Internals\OrderCouponsTable::getList(array(
	    'select' => array('COUPON'),
	    'filter' => array('=ORDER_ID' => $orderID)
	));
	while ($coupon = $couponList->fetch())
	{
	   $purchasecoupon = $coupon['COUPON'];
	
	}

	$_SESSION["EXISTS_ORDER"][$arResult["ORDER"]["ID"]] = "Y";?>

	<script>  
		window.dataLayer = window.dataLayer || [];  
		dataLayer.push({  
			'ecommerce': {  
				'currencyCode': 'RUB',  
				'purchase': {  
					'actionField': {  
						'id': "<?=$arResult['ORDER']['ID']?>",  
						'affiliation': "AryaHome - online store",  
						'revenue': "<?=$arOrderSum['PRICE']?>",  
						'shipping': "<?=$arOrderSum['PRICE_DELIVERY']?>",
						'coupon': "<?=$purchasecoupon?>"
					},  
					'products': [
					<?foreach($arItems as $arItem):?>
					{    
						'name': "<?=$arItem['name']?>",  
						'id': "<?=$arItem['id']?>",  
						'price': "<?=$arItem['price']?>",  
						// 'brand': 'Название бренда',  
						// 'category': 'Категория 1',  
						'quantity': "<?=$arItem['quantity']?>"  
					}
					<?endforeach;?>
					]  
				}  
			},  
			'event': 'gtm-ee-event',  
			'gtm-ee-event-category': 'Enhanced Ecommerce',  
			'gtm-ee-event-action': 'Purchase',  
			'gtm-ee-event-non-interaction': 'False',  
		});  
	</script>

<?endif;?>
