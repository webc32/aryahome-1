<?php

namespace Yandex\Market\Export\Xml\Tag;

use Yandex\Market;

class Price extends Base
{
	use Market\Reference\Concerns\HasMessage;

	public function getDefaultParameters()
	{
		return [
			'name' => 'price',
			'value_type' => Market\Type\Manager::TYPE_NUMBER,
			'value_positive' => true
		];
	}

	public function getSourceRecommendation(array $context = [])
	{
		$result = [];

		if ($context['HAS_CATALOG'])
		{
			$result[] = [
				'TYPE' => Market\Export\Entity\Manager::TYPE_CATALOG_PRICE,
				'FIELD' => 'MINIMAL.DISCOUNT_VALUE'
			];

			$result[] = [
				'TYPE' => Market\Export\Entity\Manager::TYPE_CATALOG_PRICE,
				'FIELD' => 'OPTIMAL.DISCOUNT_VALUE'
			];

			$result[] = [
				'TYPE' => Market\Export\Entity\Manager::TYPE_CATALOG_PRICE,
				'FIELD' => 'BASE.DISCOUNT_VALUE'
			];
		}

		return $result;
	}

	public function compareValue($value, array $context = [], Market\Result\XmlValue $nodeValue = null)
	{
		if ($nodeValue !== null)
		{
			$tagCurrencyId = (string)$nodeValue->getTagValue('currencyId');

			if ($tagCurrencyId !== '')
			{
				$currencyId = (string)Market\Data\Currency::getCurrency($tagCurrencyId);
				$baseCurrencyId = (string)Market\Data\Currency::getBaseCurrency();

				$value = Market\Data\Currency::convert($value, $currencyId, $baseCurrencyId);
			}
		}

		return $this->formatValue($value);
	}

	public function getSettingsDescription(array $context = [])
	{
		if (!Market\Config::isExpertMode()) { return []; }

		$defaults = Market\Data\UserGroup::getDefaults();
		$defaultsMap = array_flip($defaults);
		$enum = Market\Data\UserGroup::getEnum();

		uasort($enum, static function($aOption, $bOption) use ($defaultsMap) {
			$aSort = (int)isset($defaultsMap[$aOption['ID']]);
			$bSort = (int)isset($defaultsMap[$bOption['ID']]);

			if ($aSort === $bSort) { return 0; }

			return ($aSort > $bSort ? -1 : 1);
		});

		return [
			'USER_GROUP' => [
				'TITLE' => self::getMessage('SETTINGS_USER_GROUP'),
				'TYPE' => 'enumeration',
				'VALUES' => $enum,
			],
		];
	}
}