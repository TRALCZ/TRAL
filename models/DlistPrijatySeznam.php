<?php

namespace app\models;
use Yii;

use yii\db\Query;

/**
 * This is the model class for table "dlist_prijaty_seznam".
 *
 * @property integer $id
 * @property integer $dlist_prijaty_id
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
class DlistPrijatySeznam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dlist_prijaty_seznam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dlist_prijaty_id', 'seznam_id', 'typ_ceny'], 'required'],
            [['dlist_prijaty_id', 'seznam_id', 'pocet', 'sazba_dph'], 'integer'],
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
            'dlist_prijaty_id' => Yii::t('app', 'ID Dodací list přijatý'),
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
     * @return DlistPrijatySeznamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DlistPrijatySeznamQuery(get_called_class());
    }
	
	public static function addDlistPrijatySeznam($dlist_prijaty_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph)
	{
		$fakturySeznam = new DlistPrijatySeznam;
		
		$fakturySeznam->dlist_prijaty_id = $dlist_prijaty_id;
		$fakturySeznam->seznam_id = $seznam_id;
		$fakturySeznam->pocet = $pocet;
		$fakturySeznam->cena = $cena;
		$fakturySeznam->typ_ceny = $typ_ceny;
		$fakturySeznam->sazba_dph = $sazba_dph;
		$fakturySeznam->sleva = $sleva;
		$fakturySeznam->celkem = $celkem;
		$fakturySeznam->celkem_dph = $celkem_dph;
		$fakturySeznam->vcetne_dph = $vcetne_dph;

		$fakturySeznam->insert();
		
		$lastId = $fakturySeznam->id;
		
		return $lastId; 
	}
	
	public static function getDlistPrijatySeznam($id)
	{
		$query = new Query;
		$query->select('os.seznam_id seznam_id, os.dlist_prijaty_id dlist_prijaty_id, s.popis popis, os.pocet pocet, os.cena cena, os.typ_ceny typ_ceny, os.sazba_dph sazba_dph, os.sleva sleva, s.plu plu, os.celkem celkem, os.celkem_dph celkem_dph, os.vcetne_dph vcetne_dph')  
			->from('dlist_prijaty_seznam os')
			->leftJoin('dlist_prijaty o', 'o.id = dlist_prijaty_id')
			->leftJoin('seznam s', 's.id = seznam_id')
			->where('os.dlist_prijaty_id = ' . $id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryAll();
	}
	
	public static function getCountDlistPrijatySeznam($id)
	{
		$query = new Query;
		$query->select(['COUNT(*)'])  
			->from(self::tableName())
			->where('dlist_prijaty_id = ' . $id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryScalar();
	}
	
	public static function deleteDlistPrijatySeznam($id)
	{
		$query = new Query;
		return $data = $query->createCommand()->delete(self::tableName(), 'dlist_prijaty_id = ' . $id)->execute();
		
	}
}
