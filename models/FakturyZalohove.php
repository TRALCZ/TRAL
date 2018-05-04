<?php

namespace app\models;
use Yii;


/**
 * This is the model class for table "faktury".
 *
 * @property integer $id
 * @property integer $nabidky_id
 * @property string $cislo
 * @property string $popis
 * @property integer $zpusoby_platby_id
 * @property integer $zakazniky_id
 * @property integer $user_id
 * @property string $vystaveno
 * @property string $platnost
 * @property string $datetime_add
 */
class FakturyZalohove extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faktury_zalohove';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nabidky_id', 'zpusoby_platby_id', 'zakazniky_id', 'user_id'], 'integer'],
            [['zpusoby_platby_id', 'user_id', 'vystaveno', 'platnost', 'datetime_add'], 'required'],
            [['vystaveno', 'popis', 'celkem', 'celkem_dph', 'platnost', 'datetime_add'], 'safe'],
            [['cislo'], 'string', 'max' => 150],
            [['popis'], 'string', 'max' => 250],
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
            'datetime_add' => Yii::t('app', 'Přidáno'),
			'celkem' => Yii::t('app', 'Celkem bez DPH'),
			'celkem_dph' => Yii::t('app', 'Celkem vč. DPH')
        ];
    }
	
	public static function addFakturyZalohove($nabidky_id, $cislo, $popis, $zpusoby_platby_id, $zakazniky_id, $user_id, $vystaveno, $platnost, $castka)
	{
		$faktury = new FakturyZalohove;
		
		$faktury->nabidky_id = $nabidky_id;
		$faktury->cislo = $cislo;
		$faktury->popis = $popis;
		$faktury->zpusoby_platby_id = $zpusoby_platby_id;
		$faktury->zakazniky_id = $zakazniky_id;
		$faktury->user_id = $user_id;
		$faktury->vystaveno = $vystaveno;
		$faktury->platnost = $platnost;
		$faktury->castka = $castka;
		$faktury->datetime_add = date('Y-m-d H:i:s');

		$faktury->insert();
		
		$lastId = $faktury->id;
		
		$ob = FakturyZalohove::findOne($lastId);
		$ob->cislo = "FZ-" . $lastId;
		$ob->update();
		
		return $lastId; 
	}

    /**
     * @inheritdoc
     * @return FakturyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FakturyZalohoveQuery(get_called_class());
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
		$model = Zakazniky::findOne($id);
        if(!empty($model))
		{
            return $model->name;
        }

        return null;
    }
}
