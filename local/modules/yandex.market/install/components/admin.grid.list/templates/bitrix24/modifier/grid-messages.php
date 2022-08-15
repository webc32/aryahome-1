<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) { die(); }

use Bitrix\Main\Grid;

/** @var Yandex\Market\Components\AdminGridList $component */

$messages = [];

foreach ($component->getErrors() as $message)
{
	$messages[] = [
		'TYPE' => Grid\MessageType::ERROR,
		'TEXT' => $message,
	];
}

foreach ($component->getWarnings() as $warning)
{
	$messages[] = [
		'TYPE' => Grid\MessageType::WARNING,
		'TEXT' => $message,
	];
}

if (empty($messages)) { return; }

$arResult['GRID_PARAMETERS'] += [
	'MESSAGES' => $messages,
];