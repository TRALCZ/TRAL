<?php

namespace app\models;
use Yii;

use yii\db\Query;

/**
 * This is the model class for table "faktury_seznam".
 *
 * @property integer $id
 * @property integer $faktury_id
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
class FakturyZalohoveSeznam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faktury_zalohove_seznam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['faktury_zalohove_id', 'seznam_id', 'typ_ceny'], 'required'],
            [['faktury_zalohove_id', 'seznam_id', 'pocet', 'sazba_dph'], 'integer'],
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
            'faktury_zalohove_id' => Yii::t('app', 'ID Faktury zálohové'),
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
     * @return FakturySeznamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FakturyZalohoveSeznamQuery(get_called_class());
    }
	
	public static function addFakturyZalohoveSeznam($faktury_zalohove_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph)
	{
		$fakturySeznam = new FakturyZalohoveSeznam;
		
		$fakturySeznam->faktury_zalohove_id = $faktury_zalohove_id;
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
	
	public static function getFakturyZalohoveSeznam($id)
	{
		$query = new Query;
		$query->select('os.seznam_id seznam_id, os.faktury_zalohove_id faktury_zalohove_id, s.popis popis, os.pocet pocet, os.cena cena, os.typ_ceny typ_ceny, os.sazba_dph sazba_dph, os.sleva sleva, s.plu plu, os.celkem celkem, os.celkem_dph celkem_dph, os.vcetne_dph vcetne_dph')  
			->from('faktury_zalohove_seznam os')
			->leftJoin('faktury_zalohove o', 'o.id = faktury_zalohove_id')
			->leftJoin('seznam s', 's.id = seznam_id')
			->where('os.faktury_zalohove_id = ' . $id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryAll();
	}
	
	public static function getCountFakturyZalohoveSeznam($id)
	{
		$query = new Query;
		$query->select(['COUNT(*)'])  
			->from(self::tableName())
			->where('faktury_zalohove_id = ' . $id);
			//->orderBy('ns.id ASC');
			
		$command = $query->createCommand();
		return $data = $command->queryScalar();
	}
	
	public static function deleteFakturyZalohoveSeznam($id)
	{
		$query = new Query;
		return $data = $query->createCommand()->delete(self::tableName(), 'faktury_zalohove_id = ' . $id)->execute();
		
	}
}
