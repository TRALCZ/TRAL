<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "objednavky_seznam".
 *
 * @property string $id
 * @property integer $objednavky_id
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
class ObjednavkySeznam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objednavky_seznam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['objednavky_id', 'seznam_id', 'typ_ceny'], 'required'],
            [['objednavky_id', 'seznam_id', 'pocet', 'prijato', 'sazba_dph'], 'integer'],
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
            'objednavky_id' => Yii::t('app', 'ID Objednávky'),
            'seznam_id' => Yii::t('app', 'ID Seznam'),
            'pocet' => Yii::t('app', 'Počet'),
			'pocet' => Yii::t('app', 'Příjato'),
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
     * @return ObjednavkySeznamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ObjednavkySeznamQuery(get_called_class());
    }
	
	public static function addObjednavkaSeznam($objednavky_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph, $prijato = 0)
	{
		$objednavkaSeznam = new ObjednavkySeznam;
		
		$objednavkaSeznam->objednavky_id = $objednavky_id;
		$objednavkaSeznam->seznam_id = $seznam_id;
		$objednavkaSeznam->pocet = $pocet;
		$objednavkaSeznam->prijato = $prijato;
		$objednavkaSeznam->cena = $cena;
		$objednavkaSeznam->typ_ceny = $typ_ceny;
		$objednavkaSeznam->sazba_dph = $sazba_dph;
		$objednavkaSeznam->sleva = $sleva;
		$objednavkaSeznam->celkem = $celkem;
		$objednavkaSeznam->celkem_dph = $celkem_dph;
		$objednavkaSeznam->vcetne_dph = $vcetne_dph;

		$objednavkaSeznam->insert();
		
		$lastId = $objednavkaSeznam->id;
		
		return $lastId; 
	}
	
	
	public static function getObjednavkySeznam($objednavka_id)
	{
		$query = new Query;
		$query->select('os.seznam_id seznam_id, os.objednavky_id objednavky_id, s.popis popis, os.pocet pocet, os.prijato prijato, os.cena cena, os.typ_ceny typ_ceny, os.sazba_dph sazba_dph, os.sleva sleva, s.plu plu, os.celkem celkem, os.celkem_dph celkem_dph, os.vcetne_dph vcetne_dph')  
			->from('objednavky_seznam os')
			->leftJoin('objednavky o', 'o.id = objednavky_id')
			->leftJoin('seznam s', 's.id = seznam_id')
			->where('os.objednavky_id = ' . $objednavka_id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryAll();
	}
	public static function getCountObjednavkySeznam($objednavka_id)
	{
		$query = new Query;
		$query->select(['COUNT(*)'])  
			->from(self::tableName())
			->where('objednavky_id = ' . $objednavka_id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryScalar();
	}
	
	public static function deleteObjednavkySeznam($objednavka_id)
	{
		$query = new Query;
		return $data = $query->createCommand()->delete(self::tableName(), 'objednavky_id = ' . $objednavka_id)->execute();
		
	}
}
