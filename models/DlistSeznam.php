<?php

namespace app\models;
use Yii;

use yii\db\Query;

/**
 * This is the model class for table "dlist_seznam".
 *
 * @property integer $id
 * @property integer $dlist_id
 * @property integer $seznam_id
 * @property integer $pocet
 * @property string $cena
 * @property string $typ_ceny
 * @property integer $sazba_dph
 * @property string $sleva
 * @property string $celkem
 * @property string $celkem_dph
 * @property string $vcetne_dph
 */
class DlistSeznam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dlist_seznam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dlist_id', 'seznam_id', 'typ_ceny'], 'required'],
            [['dlist_id', 'seznam_id', 'pocet', 'sazba_dph'], 'integer'],
            [['cena', 'sleva', 'celkem', 'celkem_dph', 'vcetne_dph'], 'number'],
            [['typ_ceny'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'dlist_id' => Yii::t('app', 'ID Dodacího listu vydaného'),
            'seznam_id' => Yii::t('app', 'ID Seznam'),
            'pocet' => Yii::t('app', 'Počet'),
            'cena' => Yii::t('app', 'Cena'),
            'typ_ceny' => Yii::t('app', 'Typ ceny'),
            'sazba_dph' => Yii::t('app', 'Sazba DPH'),
            'sleva' => Yii::t('app', 'Sleva'),
            'celkem' => Yii::t('app', 'Celkem'),
            'celkem_dph' => Yii::t('app', 'Celkem DPH'),
            'vcetne_dph' => Yii::t('app', 'Včetně DPH'),
        ];
    }

    /**
     * @inheritdoc
     * @return DlistSeznamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DlistSeznamQuery(get_called_class());
    }
	
	public static function addDlistSeznam($dlist_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph)
	{
		$dlistSeznam = new DlistSeznam;
		
		$dlistSeznam->dlist_id = $dlist_id;
		$dlistSeznam->seznam_id = $seznam_id;
		$dlistSeznam->pocet = $pocet;
		$dlistSeznam->cena = $cena;
		$dlistSeznam->typ_ceny = $typ_ceny;
		$dlistSeznam->sazba_dph = $sazba_dph;
		$dlistSeznam->sleva = $sleva;
		$dlistSeznam->celkem = $celkem;
		$dlistSeznam->celkem_dph = $celkem_dph;
		$dlistSeznam->vcetne_dph = $vcetne_dph;

		$dlistSeznam->insert();
		
		$lastId = $dlistSeznam->id;
		
		return $lastId; 
	}
	
	public static function getDlistSeznam($id)
	{
		$query = new Query;
		$query->select('os.seznam_id seznam_id, os.dlist_id dlist_id, s.popis popis, os.pocet pocet, os.cena cena, os.typ_ceny typ_ceny, os.sazba_dph sazba_dph, os.sleva sleva, s.plu plu, os.celkem celkem, os.celkem_dph celkem_dph, os.vcetne_dph vcetne_dph')  
			->from('dlist_seznam os')
			->leftJoin('dlist o', 'o.id = dlist_id')
			->leftJoin('seznam s', 's.id = seznam_id')
			->where('os.dlist_id = ' . $id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryAll();
	}
	
	public static function getCountDlistSeznam($id)
	{
		$query = new Query;
		$query->select(['COUNT(*)'])  
			->from(self::tableName())
			->where('dlist_id = ' . $id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryScalar();
	}
	
	public static function deleteDlistSeznam($id)
	{
		$query = new Query;
		return $data = $query->createCommand()->delete(self::tableName(), 'dlist_id = ' . $id)->execute();
		
	}
}
