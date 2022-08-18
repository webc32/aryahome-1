<?php

namespace Yandex\Market\Trading\State\Internals;

use Yandex\Market;
use Bitrix\Main;

class StatusTable extends Market\Reference\Storage\Table
{
	public static function getTableName()
	{
		return 'yamarket_trading_state_status';
	}

	public static function getMap()
	{
		return [
			new Main\Entity\StringField('SERVICE', [
				'required' => true,
				'primary' => true,
				'validation' => [__CLASS__, 'getValidationForService'],
			]),
			new Main\Entity\StringField('ENTITY_ID', [
				'required' => true,
				'primary' => true,
				'validation' => [__CLASS__, 'getValidationForEntityId'],
			]),
			new Main\Entity\StringField('VALUE', [
				'required' => true,
				'validation' => [__CLASS__, 'getValidationForValue'],
			]),
			new Main\Entity\DatetimeField('TIMESTAMP_X', [
				'required' => true,
			]),
		];
	}

	public static function migrate(Main\DB\Connection $connection)
	{
		$entity = static::getEntity();
		$tableName = static::getTableName();
		$existsFields = $connection->getTableFields($tableName);

		Market\Migration\StorageFacade::addNewFields($connection, $entity);
		Market\Migration\StorageFacade::updateFieldsLength($connection, $entity, [ 'VALUE' ]);

		if (!isset($existsFields['TIMESTAMP_X']))
		{
			$sqlHelper = $connection->getSqlHelper();

			$connection->queryExecute(sprintf(
				'UPDATE %s SET %s=%s',
				$sqlHelper->quote($tableName),
				$sqlHelper->quote('TIMESTAMP_X'),
				$sqlHelper->convertToDb(new Main\Type\DateTime(), $entity->getField('TIMESTAMP_X'))
			));
		}
	}

	public static function getValidationForService()
	{
		return [
			new Main\Entity\Validator\Length(null, 20),
		];
	}

	public static function getValidationForEntityId()
	{
		return [
			new Main\Entity\Validator\Length(null, 12),
		];
	}

	public static function getValidationForValue()
	{
		return [
			new Main\Entity\Validator\Length(null, 60),
		];
	}
}