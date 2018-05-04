<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objednavky".
 *
 * @property string $id
 * @property string $cislo
 * @property string $popis
 * @property integer $zpusoby_platby_id
 * @property integer $zakazniky_id
 * @property integer $user_id
 * @property string $vystaveno
 * @property string $platnost
 * @property integer $datetime_add
 * @property string $objednavka_vystavena
 * @property string $faktura_vydana
 */
class Objednavky extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objednavky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nabidky_id', 'zpusoby_platby_id', 'user_id', 'vystaveno', 'platnost', 'datetime_add'], 'required'],
            [['nabidky_id', 'zpusoby_platby_id', 'zakazniky_id', 'user_id'], 'integer'],
            [['vystaveno', 'platnost', 'datetime_add'], 'safe'],
            [['cislo'], 'string', 'max' => 150],
            [['popis'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
			'nabidky_id' => Yii::t('app', 'Nabídka vystavená'),
            'cislo' => Yii::t('app', 'Číslo'),
            'popis' => Yii::t('app', 'Popis'),
            'zpusoby_platby_id' => Yii::t('app', 'Způsoby platby'),
            'zakazniky_id' => Yii::t('app', 'Zákazník'),
            'user_id' => Yii::t('app', 'Vystavil'),
            'vystaveno' => Yii::t('app', 'Datum vystavení'),
            'platnost' => Yii::t('app', 'Platnost do'),
            'datetime_add' => Yii::t('app', 'Přidáno')
        ];
    }

    /**
     * @inheritdoc
     * @return ObjednavkyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ObjednavkyQuery(get_called_class());
    }
	
	public static function addObjednavky($nabidky_id, $cislo, $popis, $zpusoby_platby_id, $zakazniky_id, $user_id, $vystaveno, $platnost)
	{
		$objednavky = new Objednavky;
		
		$objednavky->nabidky_id = $nabidky_id;
		$objednavky->cislo = $cislo;
		$objednavky->popis = $popis;
		$objednavky->zpusoby_platby_id = $zpusoby_platby_id;
		$objednavky->zakazniky_id = $zakazniky_id;
		$objednavky->user_id = $user_id;
		$objednavky->vystaveno = $vystaveno;
		$objednavky->platnost = $platnost;
		$objednavky->datetime_add = date('Y-m-d H:i:s');

		$objednavky->insert();
		
		$lastId = $objednavky->id;
		
		$ob = Objednavky::findOne($objednavky->id);
		$ob->cislo = "O-" . $objednavky->id;
		$ob->update();
		
		return $lastId; 
	}
	
	public function getzpusoby_platby()
	{
		return $this->hasOne(ZpusobyPlatby::className(), ['id' => 'zpusoby_platby_id']);
	}
	
	public function getzakazniky()
	{
		return $this->hasOne(Zakazniky::className(), ['id' => 'zakazniky_id']);
	}
	
	public function getuser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	public static function getZakaznik($id)
	{
        $model = Zakazniky::find()->where(["id" => $id])->one();
        if(!empty($model))
		{
            return $model->name;
        }

        return null;
    }
	
	
}
