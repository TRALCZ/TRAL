<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sklady_seznam".
 *
 * @property int $id ID
 * @property string $uuid UUID
 * @property int $cenik_id Ceníky
 * @property int $name Název
 * @property string $cena Cena
 * @property int $typceny_id Typ ceny
 */
class SkladySeznam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sklady_seznam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['sklady_id', 'stav_zasoby', 'objednano', 'rezervace', 'predpokladny_stav', 'zasoba_pojistna'], 'integer'],
			[['seznam_id', 'is_delete'], 'safe'],
			[['uuid'], 'string', 'max' => 36],
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
            'sklady_id' => Yii::t('app', 'Sklady'),
			'seznam_id' => Yii::t('app', 'Název'),
			'stav_zasoby' => Yii::t('app', 'Stav zásoby'),
			'objednano' => Yii::t('app', 'Objednáno'),
			'rezervace' => Yii::t('app', 'Rezervace'),
			'predpokladny_stav' => Yii::t('app', 'Předpokládný stav'),
			'zasoba_pojistna' => Yii::t('app', 'Zásoba pojistná'),
			'is_delete' => Yii::t('app', 'Smazano'),
        ];
    }

    /**
     * @inheritdoc
     * @return SkladySeznamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SkladySeznamQuery(get_called_class());
    }
	
	public function insertSkladySeznam($data)
	{
		$cs = new SkladySeznam;
		$moneys = new Moneys();
		
		$cs->uuid = $moneys->createID();
		$cs->sklady_id = $data['sklady_id'];
		$cs->seznam_id = $data['seznam_id'];
		$cs->zasoba_pojistna = $data['zasoba_pojistna'];
		$cs->insert();

		return Yii::$app->db->getLastInsertID();
	}
	
	public function updateSkladySeznam($data)
	{
		$cs = SkladySeznam::findOne($data['sklady_id']);
		$cs->seznam_id = $data['seznam_id'];
		$cs->update();

		return Yii::$app->db->getLastInsertID();
	}
	
	public function getSeznam()
	{
		return $this->hasOne(Seznam::className(), ['id' => 'seznam_id']);
	}
	
	public function getSklady()
	{
		return $this->hasOne(Sklady::className(), ['id' => 'sklady_id']);
	}	

}
