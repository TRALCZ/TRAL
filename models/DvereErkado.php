<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cinnost".
 *
 * @property int $id ID
 * @property string $id_ms ID MoneyS
 * @property string $kod Kod
 * @property string $name Název
 */
class DvereErkado extends \yii\db\ActiveRecord
{

	public static function getDbDE() {
        return Yii::$app->dbde;
    }
	
	public function getAllOrders($limit = 0)
	{
		$connection = self::getDbDE();
		if($limit > 0)
		{
			$command = $connection->createCommand("SELECT * FROM oc_order ORDER BY order_id DESC LIMIT {$limit}");
		}
		else
		{
			$command = $connection->createCommand("SELECT * FROM oc_order ORDER BY order_id DESC");
		}
		return $result = $command->queryAll();
	}
	
	public function getAllMaxOrders($max = 0)
	{
		$connection = self::getDbDE();
		
		$command = $connection->createCommand("SELECT * FROM oc_order WHERE order_id > {$max}");
		return $result = $command->queryAll();
	}
}
