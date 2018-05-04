<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ceniky_seznam".
 *
 * @property int $id ID
 * @property string $uuid UUID
 * @property int $cenik_id Ceníky
 * @property int $name Název
 * @property string $cena Cena
 * @property int $typceny_id Typ ceny
 */
class CenikySeznam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ceniky_seznam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['ceniky_id', 'typceny_id', 'seznam_id'], 'integer'],
            [['cena'], 'number'],
			[['uuid', 'is_delete'], 'string', 'max' => 36],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uuid' => Yii::t('app', 'UUID'),
            'ceniky_id' => Yii::t('app', 'Ceníky'),
            'cena' => Yii::t('app', 'Cena'),
            'typceny_id' => Yii::t('app', 'Typ ceny'),
			'seznam_id' => Yii::t('app', 'Název'),
			'is_delete' => Yii::t('app', 'Smazano'),
        ];
    }

    /**
     * @inheritdoc
     * @return CenikySeznamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CenikySeznamQuery(get_called_class());
    }
	
	public function insertCenikySeznam($data)
	{
		$cs = new CenikySeznam;
		$moneys = new Moneys();
		
		$cs->uuid = $moneys->createID();
		$cs->ceniky_id = $data['ceniky_id'];
		$cs->cena = $data['cena'];
		$cs->typceny_id = $data['typceny_id'];
		$cs->seznam_id = $data['seznam_id'];
		$cs->insert();

		return Yii::$app->db->getLastInsertID();
	}
	
	public function updateCenikySeznam($data)
	{
		$cs = CenikySeznam::findOne($data['ceniky_id']);
		$cs->cena = $data['cena'];
		$cs->typceny_id = $data['typceny_id'];
		$cs->seznam_id = $data['seznam_id'];
		$cs->update();

		return Yii::$app->db->getLastInsertID();
	}
	
	public function getCeniky()
	{
		return $this->hasOne(Ceniky::className(), ['id' => 'ceniky_id']);
	}
	
	public function getSeznam()
	{
		return $this->hasOne(Seznam::className(), ['id' => 'seznam_id']);
	}
	
	public function getTypceny()
	{
		return $this->hasOne(Typceny::className(), ['id' => 'typceny_id']);
	}
}
