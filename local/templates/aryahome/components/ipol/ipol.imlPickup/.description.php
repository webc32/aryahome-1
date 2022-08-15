<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IPOLIML_COMP_NAME"),
	"DESCRIPTION" => GetMessage("IPOLIML_COMP_DESCR"),
	"ICON" => "/images/iml_pickup.png",
	"CACHE_PATH" => "Y",
	"SORT" => 40,
	"PATH" => array(
		"ID" => "e-store",
		"CHILD" => array(
			"ID" => "ipol",
			"NAME" => GetMessage("IPOLIML_GROUP"),
			"SORT" => 30,
			"CHILD" => array(
				"ID" => "ipol_imlPickup",
			),
		),
	),
);

?>