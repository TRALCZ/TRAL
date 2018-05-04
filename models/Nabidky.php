<?php

namespace app\models;
use yii\db\Query;
use Yii;
//use app\models\ZpusobyPlatby;

/**
 * This is the model class for table "nabidky".
 *
 * @property integer $id
 * @property integer $cislo
 * @property string $popis
 * @property integer $zpusoby_platby_id
 * @property integer $zakazniky_id
 * @property string $datetime
 */
class Nabidky extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nabidky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zpusoby_platby_id', 'user_id', 'vystaveno', 'platnost'], 'required'],
            [['zpusoby_platby_id', 'zakazniky_id', 'user_id', 'status_id', 'skupiny_id'], 'integer'],
            [['celkem', 'celkem_dph', 'cislo', 'datetime_add', 'uuid'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'uuid' => 'UUID',
			'user_id' => 'Vystavil',
            'cislo' => 'Doklad',
            'name' => 'Název',
            'zpusoby_platby_id' => 'Způsob platby',
			//'zpusoby_platby' => 'Způsob platby',
            'zakazniky_id' => 'Odběratel',
			'skupiny_id' => 'Skupiny',
            'vystaveno' => 'Dat.vystavení',
			'platnost' => 'Dat.platností',
			'status_id' => 'Stav',
			'celkem' => 'Celkem bez DPH',
			'celkem_dph' => 'Celkem vč. DPH'
        ];
    }

    /**
     * @inheritdoc
     * @return NabidkyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NabidkyQuery(get_called_class());
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
	
	public function getskupiny()
	{
		return $this->hasOne(Skupiny::className(), ['id' => 'skupiny_id']);
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
	
	public function getstatus()
	{
		return $this->hasOne(Status::className(), ['id' => 'status_id']);
	}
	
	public static function change($id)
	{

		$model = Zakazniky::find()->where(["id" => $id])->one();
        if(!empty($model))
		{
            return $model->name;
        }

        return null;
		
    }
	
	

}
