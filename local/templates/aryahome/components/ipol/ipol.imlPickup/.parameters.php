<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!\Bitrix\Main\Loader::includeModule("sale"))
	return;

if(!cmodule::includeModule('iml.v1'))
	return false;

$arCities = array();
$arList = CDeliveryIML::getListFile();
$arCities=$arList['Region'];
$arDefCities = array();
foreach($arCities as $name)
	$arDefCities[$name] = $name;

$arPayers = array();
$db_ptype = CSalePersonType::GetList(Array("SORT" => "ASC"));
while($arPayer = $db_ptype->Fetch()){
	$arPayers [$arPayer['ID']]= $arPayer['NAME'];
}

$arPaySyss=CSalePaySystem::GetList(array(),array('ACTIVE'=>'Y'));
$arPaySystems = array();
while($arPaySus=$arPaySyss->Fetch()){
	$arPaySystems [$arPaySus['ID']]= $arPaySus['NAME']; 
}

$arComponentParameters = array(
	"PARAMETERS" => array(
		"CNT_DELIV" => array(
			"PARENT"   => "BASE",
			"NAME"     => GetMessage('IPOLIML_COMPOPT_CNT_DELIV'),
			"TYPE"     => "CHECKBOX",
		),
		"NOMAPS" => array(
			"PARENT"   => "BASE",
			"NAME"     => GetMessage('IPOLIML_COMPOPT_NOMAPS'),
			"TYPE"     => "CHECKBOX",
		),
		"LOAD_ACTUAL_PVZ" => array(
			"PARENT"   => "BASE",
			"NAME"     => GetMessage('IPOLIML_LOAD_ACTUAL_PVZ'),
			"TYPE"     => "CHECKBOX",
		),
		"NO_POSTOMAT" => array(
			"PARENT"   => "BASE",
			"NAME"     => GetMessage('IPOLIML_NO_POSTOMAT'),
			"TYPE"     => "CHECKBOX",
		),
		"PAYER" => array(
			"PARENT"   => "BASE",
			"NAME"     => GetMessage('IPOLIML_COMPOPT_PAYERS'),
			"TYPE"     => "LIST",
			"VALUES"   => $arPayers,
			"SIZE"     => 3,
			"MULTIPLE" => "N",
		),
		"PAYSYSTEM" => array(
			"PARENT"   => "BASE",
			"NAME"     => GetMessage('IPOLIML_COMPOPT_PAYSYSTEM'),
			"TYPE"     => "LIST",
			"VALUES"   => $arPaySystems,
			"SIZE"     => 5,
			"MULTIPLE" => "N",
		),
		"DEFAULT_CITY" => array(
			"PARENT"   => "BASE",
			"NAME"     => GetMessage('IPOLIML_COMPOPT_DEFAULT_CITY'),
			"TYPE"     => "LIST",
			"VALUES"   => $arDefCities,
			"SIZE"     => 5,
			"DEFAULT"  => GetMessage('IPOLIML_MOSCOW'),
		),
		"CITIES" => array(
			"PARENT"   => "BASE",
			"NAME"     => GetMessage('IPOLIML_COMPOPT_CITIES'),
			"TYPE"     => "LIST",
			"VALUES"   => $arCities,
			"SIZE"     => count($arCities),
			"MULTIPLE" => "Y",
		),
	),
);
?>