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

$directory = $this->GetFolder();

if($_SESSION['ga'] == 1){ // метка в сессии, добавляем данные в dataLayer если разрешено
    unset($_SESSION['ga']); // удаляем метку разрешения отсылки транзакции, чтобы не было дублей
    ?>
	<script>
	    window.dataLayer = window.dataLayer || []
	    dataLayer.push({
	    'transactionId': '<?=$arResult["ORDER"]['ID']?>', // номер заказа
	    'transactionTotal': <?=$arResult["ORDER"]['PRICE']?>, // сумма заказа
	    'transactionTax': <?=$arResult["ORDER"]['TAX_VALUE']?>, // сумма налога
	    'transactionShipping': <?=$arResult["ORDER"]['PRICE_DELIVERY']?>, // стоимость доставки
	    'transactionProducts': [
	    <?
	    $arItems=array();
	    $arIds=array();
	    $basItems=CSaleBasket::GetList(array(),array('ORDER_ID'=>$arResult["ORDER"]['ID'])); // достаем информацию о товарах в корзине
	    while($basItem=$basItems->Fetch()){
	    	$arItems[] = $basItem;
	    	$arIds[] = $basItem['PRODUCT_ID'];
		    ?>
		    {
		    'sku': '<?=$basItem['PRODUCT_ID']?>', // артикул товара
		    'name': '<?=str_replace("'",'"',$basItem['NAME'])?>', // название товара
		    'category': '', // тут категория, если есть
		    'price': '<?=$basItem['PRICE']?>', // стоимость товара
		    'quantity': '<?=$basItem['QUANTITY']?>' // количество единиц товара
		    },
	    <?}?>
	    ]
	    });
	    dataLayer.push({'event': 'purchase','value': <?=$arResult["ORDER"]['PRICE']?>,
	    	'items' : [
		    		<?
		    		$total = count($arItems);
					$counter = 0;
				   	foreach ($arItems as $item){
				   		$counter++;
						if ($counter == $total){
					        ?>
								{
									'id': <?=$item['ID']?>,
									'google_business_vertical': 'retail'
								}
							<?
						}else{
						  	?>
								{
									'id': <?=$item['ID']?>,
									'google_business_vertical': 'retail'
								},
							<?
						}
					}?>
				]
		});
	</script>
	<script type="text/javascript">
		ym(28747751,'reachGoal','BX-order-save');
	</script>
	<?
}?>
<script>
 function scriptsfbq() {
  fbq('track', 'Purchase', {
    value: <?=$arResult["ORDER"]['PRICE']?>,
    currency: 'RUB',
    content_ids: [<?echo $arIds;?>],
    contents: [
    <?
    $basItems=CSaleBasket::GetList(array(),array('ORDER_ID'=>$arResult["ORDER"]['ID'])); // достаем информацию о товарах в корзине
    while($basItem=$basItems->Fetch()){
    ?>
        {'id': '<?=$basItem['PRODUCT_ID']?>', 'quantity': <?=$basItem['QUANTITY']?>},
    <?}?>
      ],
    content_type: 'product',
  });
}
	//setTimeout(scriptsfbq, 500);
</script>
<? if (!empty($arResult["ORDER"])): ?>
<!-- Структура -->
<div class="row wide mx-md-auto">
    <div class="catalog w-100 my-md-5" id="<?= $sTemplateId ?>">
        <div class="basket w-100">
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
            <div class="w-100 fix-mobile-padding mt-4">
                <h1 class="title d-none d-md-block font-weight-800">Оформление заказа</h1>
            </div>
            <div class="w-100 mt-md-4 mt-0">
<!-- Структура -->
	<div class="mb-5">
		<div class="col">
			<?=Loc::getMessage("SOA_ORDER_SUC", array(
				"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
				"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
			))?>
			<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
				<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
					"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
				))?>
			<? endif ?>
		</div>
	</div>

	<? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
		<div class="mb-5">
			<div class="col">
				<?=Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']])?>
			</div>
		</div>
	<? endif; ?>

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

							<div class="mb-2 text-center">
								<div class="col">
									<h3 class="pay_name text-gold"><?=Loc::getMessage("SOA_PAY") ?></h3>
								</div>
							</div>
							<div class="mb-2 text-center">
								<div class="col"><?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"max-width:100px\"", "", false) ?></div>
								<div class="col-auto"><strong><?=$arPaySystem["NAME"] ?></strong></div>
							</div>
							<div class="mb-5 text-center">
								<div class="col">
									<? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
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
								</div>
							</div>



							<?
						}
						else
						{
							?>
							<div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
							<?
						}
					}
					else
					{
						?>
						<div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<div class="alert alert-danger" role="alert"><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></div>
		<?
	}
	?>
<!-- Структура -->
			</div>
		</div>
	</div>
</div>
<!-- Структура -->
<? else: ?>


	<div class="mb-2">
		<div class="col">
			<div class="alert alert-danger" role="alert"><strong><?=Loc::getMessage("SOA_ERROR_ORDER")?></strong><br />
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?><br />
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?></div>
		</div>
	</div>

<? endif ?>