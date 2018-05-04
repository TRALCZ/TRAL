<?php

namespace app\models;

use Yii;
use \thamtech\uuid\helpers\UuidHelper;

/**
 * This is the model class for table "cinnost".
 *
 * @property int $id ID
 * @property string $id_ms ID MoneyS
 * @property string $kod Kod
 * @property string $name Název
 */
class Moneys extends \yii\db\ActiveRecord
{

	public static function getDb() {
        return Yii::$app->dbms;
    }
	
	public function getAlltables()
	{
		$connection = self::getDb();
		$command = $connection->createCommand("SELECT TOP 1 * FROM Adresar_Aktivita");
		
		return $command->queryOne();
		
	}
	
	public function createID()
	{
		return UuidHelper::uuid();
	}
	
	public function insertXML($xml)
	{
		$connection = self::getDb();
		$newid = UuidHelper::uuid();
		
		$command = $connection->createCommand("
			INSERT INTO System_XmlExchangeImport
			([ID], [Parent_ID], [Root_ID], [Group_ID], [Deleted], [Hidden], [Locked], [Create_ID], [Create_Date], [Modify_ID], [Modify_Date], [UserData], [DatumZpracovani], [KodImportu], [VstupniXml], [Report], [Stav], [Attachments])
			VALUES
			('$newid', NULL, NULL, NULL, 0, 0, 0, '32FF1F31-E780-44EC-AFDB-F62EF5C4CDC7', GETDATE(), NULL, NULL, NULL, NULL, 'ESK01', '$xml', NULL, 0, 0)
		");
		
		return $command->execute();
	}
	
}
