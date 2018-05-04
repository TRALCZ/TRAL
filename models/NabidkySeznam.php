<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "nabidky_seznam".
 *
 * @property integer $id
 * @property integer $nabidky_id
 * @property integer $seznam_id
 */
class NabidkySeznam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nabidky_seznam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nabidky_id', 'seznam_id', 'pocet', 'cena', 'typ_ceny', 'sazba_dph', 'sleva', 'celkem', 'celkem_dph', 'vcetne_dph'], 'required'],
            [['nabidky_id', 'seznam_id'], 'integer'],
			[['uuid'], 'safe'],
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
            'nabidky_id' => 'ID Nabídky',
            'seznam_id' => 'ID Seznam',
			
        ];
    }

    /**
     * @inheritdoc
     * @return NabidkySeznamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NabidkySeznamQuery(get_called_class());
    }
	
	public static function addNabidkaSeznam($nabidky_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph)
	{
		$nabidkaSeznam = new NabidkySeznam;
		
		$nabidkaSeznam->uuid = Moneys::createID();
		$nabidkaSeznam->nabidky_id = $nabidky_id;
		$nabidkaSeznam->seznam_id = $seznam_id;
		$nabidkaSeznam->pocet = $pocet;
		$nabidkaSeznam->cena = $cena;
		$nabidkaSeznam->typ_ceny = $typ_ceny;
		$nabidkaSeznam->sazba_dph = $sazba_dph;
		$nabidkaSeznam->sleva = $sleva;
		$nabidkaSeznam->celkem = $celkem;
		$nabidkaSeznam->celkem_dph = $celkem_dph;
		$nabidkaSeznam->vcetne_dph = $vcetne_dph;

		$nabidkaSeznam->insert();
		
		return Yii::$app->db->getLastInsertID(); 
	}
	
	public static function getNabidkySeznam($nabidka_id)
	{
		$query = new Query;
		$query->select('ns.seznam_id seznam_id, ns.nabidky_id nabidky_id, s.name name, ns.pocet pocet, ns.cena cena, ns.typ_ceny typ_ceny, ns.sazba_dph sazba_dph, ns.sleva sleva, s.kod kod, ns.celkem celkem, ns.celkem_dph celkem_dph, ns.vcetne_dph vcetne_dph')  
			->from('nabidky_seznam ns')
			->leftJoin('nabidky n', 'n.id = nabidky_id')
			->leftJoin('seznam s', 's.id = seznam_id')
			->where('ns.nabidky_id = ' . $nabidka_id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryAll();
	}
	
	public static function getCountNabidkySeznam($nabidka_id)
	{
		$query = new Query;
		$query->select(['COUNT(*)'])  
			->from(self::tableName())
			->where('nabidky_id = ' . $nabidka_id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryScalar();
	}
	
	public static function getTypCeny($id)
	{
		$seznam = self::findOne($id);
		if($seznam->typ_ceny == 'bez_dph')
		{
			$result = 'bez DPH';
		}
		else if($seznam->typ_ceny == 's_dph')
		{
			$result = 's DPH';
		}
		else if($seznam->typ_ceny == 'jen_zaklad')
		{
			$result = 'jen zaklad';
		}
		return $result;
	}
	
	public static function deleteNabidkySeznam($nabidka_id)
	{
		$query = new Query;
		return $data = $query->createCommand()->delete(self::tableName(), 'nabidky_id = ' . $nabidka_id)->execute();
		
	}

}
