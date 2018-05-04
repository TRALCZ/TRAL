<?php

namespace app\models;
use yii\db\Query;

use Yii;
use app\models\CenovaHladina;

/**
 * This is the model class for table "zakazniky".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $ico
 * @property string $dic
 * @property string $kontaktni_osoba
 * @property string $f_ulice
 * @property string $f_mesto
 * @property string $f_psc
 * @property string $f_countries_id
 * @property string $d_ulice
 * @property string $d_mesto
 * @property string $d_psc
 * @property string $d_countries_id
 * @property string $datetime
 */
class Zakazniky extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zakazniky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['o_name', 'zakazniky_skupina_id', 'o_ulice', 'o_mesto', 'o_psc', 'o_countries_id'], 'required'],
            [['datetime', 'zakazniky_skupina_id', 'poznamka'], 'safe'],
            [['o_name', 'f_name', 'p_name', 'kontaktni_osoba', 'web'], 'string', 'max' => 255],
			[['uuid_email', 'uuid_web', 'uuid_mobil', 'uuid_phone', 'uuid_kontaktni_osoba', 'uuid_klice'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 100],
            [['email', 'f_ulice', 'f_mesto', 'p_ulice', 'p_mesto', 'o_ulice', 'o_mesto', 'mobil'], 'string', 'max' => 150],
            [['ico', 'dic', 'f_psc', 'p_psc'], 'string', 'max' => 50],
			[['splatnost', 'f_countries_id', 'p_countries_id'], 'integer'],
			[['is_fa', 'is_pa'], 'default', 'value' => '0'],
			[['spolehlivy_platce_dph'], 'string', 'max' => 10],
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
			'zakazniky_skupina_id' => 'Skupina',
            'o_name' => 'Název',
			'f_name' => 'Název fakturační',
			'p_name' => 'Název provozovny',
			'uuid_phone' => 'UUID Telefon',
            'phone' => 'Telefon',
			'uuid_mobil' => 'UUID Mobil',
			'mobil' => 'Mobil',
			'uuid_web' => 'UUID Web',
			'web' => 'Web',
			'uuid_email' => 'UUID Email',
            'email' => 'Email',
            'ico' => 'IČO',
            'dic' => 'DIČ',
			'spolehlivy_platce_dph' => 'Spoleh. plátce DPH',
			'uuid_kontaktni_osoba' => 'UUID Kontaktní osoba',
            'kontaktni_osoba' => 'Kontaktní osoba',
			'o_ulice' => 'Ulice a číslo',
            'o_mesto' => 'Město',
            'o_psc' => 'PSČ',
			'o_countries_id' => 'Země',
			'is_fa' => 'Odlišná fakturační adresa',
            'f_ulice' => 'Ulice a číslo',
            'f_mesto' => 'Město',
            'f_psc' => 'PSČ',
			'f_countries_id' => 'Země',
			'is_pa' => 'Odlišná adresa provozovny',
            'p_ulice' => 'Ulice a číslo',
            'p_mesto' => 'Město',
            'p_psc' => 'PSČ',
			'p_countries_id' => 'Země',
			'uuid_klice' => 'UUID Adresní klíče',
			'klice' => 'Adresní klíče',
			'poznamka' => 'Poznámka',
			'splatnost' => 'Splatnost (dnů)',
			'c_hladina' => 'Ceníky',
			'ceniky' => 'Cenová hladina',
			'order_id' => 'ID Order',
            'datetime' => 'Přidano',
        ];
    }

    /**
     * @inheritdoc
     * @return ZakaznikyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZakaznikyQuery(get_called_class());
    }
	
	public function getZakazniky()
	{
		$query = new Query;
		$query->select('id, o_name, o_ulice, o_mesto, o_psc')  
			->from(self::tableName())
			//->leftJoin('rada r', 'r.id = rada_id')
			//->leftJoin('dvere d', 'd.id = dvere_id')
			//->where('n.objednavka = "0"')
			->orderBy('o_name');
			
		$command = $query->createCommand();
		return $data = $command->queryAll();
	}
	
	public function getCenovaHladina($idm)
	{
		$chladina = Zakazniky::find()->where(['id' => $idm])->one();
		$arr = json_decode($chladina['c_hladina']);
			
		if (count($arr) >0)
		{	
			$res = '';
			foreach($arr as $ch)
			{
				$chl = CenovaHladina::find()->where(['id' => $ch])->one();
				$res = $res  . "<span class='label label-success' style='font-size: 14px; margin-right: 10px;'>" . $chl['name'] . "</span>";
			}
		}
		else
		{
			$res = "---";
		}

		return $res;
	}
	
	public function getName($id)
	{
			$zakazniky = Zakazniky::findOne($id);
			return $zakazniky->o_name;
	}
}
