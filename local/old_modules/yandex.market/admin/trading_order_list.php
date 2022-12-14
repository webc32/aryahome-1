<?php

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Yandex\Market;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin.php';

Loc::loadMessages(__FILE__);

$APPLICATION->SetTitle(Loc::getMessage('YANDEX_MARKET_TRADING_ORDER_LIST_TITLE'));

$controller = null;
$state = null;

try
{
	if (!Main\Loader::includeModule('yandex.market'))
	{
		$message = Loc::getMessage('YANDEX_MARKET_TRADING_ORDER_LIST_REQUIRE_MODULE');
		throw new Main\SystemException($message);
	}

	$controller = new Market\Ui\Trading\OrderList();

	$controller->checkReadAccess();
	$controller->loadModules();

	$controller->show();
}
catch (Main\SystemException $exception)
{
	if ($controller !== null)
	{
		$controller->handleException($exception);
	}
	else
	{
		\CAdminMessage::ShowMessage([
			'TYPE' => 'ERROR',
			'MESSAGE' => $exception->getMessage(),
		]);
	}
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php';
