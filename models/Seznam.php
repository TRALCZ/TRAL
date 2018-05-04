<?php

namespace app\models;
use yii\db\Query;
use yii\helpers\Url;
use Yii;

use app\models\Category;

/**
 * This is the model class for table "seznam".
 *
 * @property integer $id
 * @property string $popis
 * @property integer $plu
 * @property integer $stav
 * @property integer $rezerva
 * @property integer $objednano
 * @property integer $predpoklad_stav
 * @property string $cena_bez_dph
 * @property integer $min_limit
 * @property string $cena_s_dph
 */
class Seznam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seznam';
    }

	//public $_selection;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typ_id', 'norma_id', 'rada_id', 'modely_id', 'odstin_id', 'rozmer_id', 'otevirani_id', 'typzamku_id', 'ventilace_id'], 'required'],
            [['typ_id', 'norma_id', 'rada_id', 'modely_id', 'odstin_id', 'rozmer_id', 'otevirani_id', 'typzamku_id', 'vypln_id', 'ventilace_id', 'druh_id', 'jednotka_id', 'zakazniky_id', 'dodaci_lhuta'], 'integer'],
            [['category_id'], 'number'],
			[['priplatek_options_id'], 'safe'],
            [['name', 'kod', 'carovy_kod', 'hmotnost', 'is_delete'], 'string', 'max' => 255],
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
            'name' => 'Název',
			'typ_id' => 'Typ',
			'norma_id' => 'Norma',
			'rada_id' => 'Řada',
			'modely_id' => 'Model',
			'odstin_id' => 'Odstín',
			'rozmer_id' => 'Rozměr',
			'otevirani_id' => 'Typ otevírání dveří',
			'typzamku_id' => 'Typ zámku',
			'vypln_id' => 'Výplň',
			'ventilace_id' => 'Ventilace',
            'kod' => 'Kód',
			'carovy_kod' => 'Čárový kód',
			'hmotnost' => 'Hmotnost (kg)',
			'category_id' => 'Kategorie',
			'druh_id' => 'Druh položky',
			'jednotka_id' => 'Jednotka',
			'zakazniky_id' => 'Dodavatele',
			'dodaci_lhuta' => 'Dodací lhůta',
			'priplatek_options_id' => 'Příplatky pro všechny modely',
			'is_delete' => 'Smazano',
        ];
    }

    /**
     * @inheritdoc
     * @return SeznamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeznamQuery(get_called_class());
    }
	
	public function getSeznam($text)
	{
		$query = new Query;
		$query->select('id, name, kod')  
			->from(self::tableName())
			//->leftJoin('rada r', 'r.id = rada_id')
			//->leftJoin('dvere d', 'd.id = dvere_id')
			->where(['LIKE', 'name', $text])
			->orderBy('name')
			->limit(10);
			
		$command = $query->createCommand();
		return $data = $command->queryAll();
	}
	
	public function getImageUrl($model_id)
	{
		if ($model_id)
		{
			$modely = Modely::find()->where(['id' => $model_id])->one();
			$img_url = $modely['image'];
			if ($img_url)
			{
				return "<a rel='fancybox' title = '" . $modely['name'] . "' href='" . Url::to('@web' . $img_url, true) . "'><i class='fa  fa-file-image-o' title='Pro zvětšení obrázku kliknite zde'></i></a>";
			}
			else
			{
				return '';
			}
		}
		
	}
	public function getModely()
	{
		return $this->hasOne(Modely::className(), ['id' => 'modely_id']);
	}
	
	public function insertSeznam($data)
	{
		$seznam = new Seznam();
		
		$seznam->uuid = Moneys::createID();
		$seznam->name = $data['name'];
		$seznam->typ_id = $data['typ_id'];
		$seznam->norma_id = $data['norma_id'];
		$seznam->modely_id = $data['modely_id'];
		$seznam->odstin_id = $data['odstin_id'];
		$seznam->rozmer_id = $data['rozmer_id'];
		$seznam->otevirani_id = $data['otevirani_id'];
		$seznam->typzamku_id = $data['typzamku_id'];
		$seznam->vypln_id = $data['vypln_id'];
		$seznam->ventilace_id = $data['ventilace_id'];
		$seznam->category_id = $data['category_id'];
		$seznam->jednotka_id = $data['jednotka_id'];
		
		$seznam->carovy_kod = $data['carovy_kod'];
		$seznam->zakazniky_id = $data['zakazniky_id'];
		$seznam->hmotnost = $data['hmotnost'];
		$seznam->dodaci_lhuta = $data['dodaci_lhuta'];
		
		$seznam->insert();
		
		$seznam2 = Seznam::findOne($seznam->id);
		$seznam2->kod = str_pad($seznam->id, 7, '0', STR_PAD_LEFT);
		$seznam2->update();
		
		$data['id'] = $seznam->id;
		$data['kod'] = $seznam2->kod;
		
		return $data;
	}
	
	public function seznamName($id)
	{
		$seznam = Seznam::findOne($id);
		return $seznam->name;
	}
	
	public function getPlu($id)
	{
		$seznam = Seznam::findOne($id);
		return $seznam->kod;
	}
	
	
	public function getCountName($name)
	{
		$seznam = Seznam::find()->where(['name' => $name])->all();
		return count($seznam);
	}
	
	public function selectWithCena($array)
	{
		foreach($array as $m)
		{
			if($m->cena > 0)
			{
				$listData[$m->id] = $m->name . ' (+' . $m->cena . ' Kč)';
			}
			else
			{
				$listData[$m->id] = $m->name;
			}
		}
		
		return $listData;
	}
	
	public function addModelToCategory($longName)
	{
		$popis = explode(" ", $longName);
				$popis = array_map('strtolower', $popis);
				
				if ($popis[3])
				{
					if ($popis[3] != "lux") // 33
					{
						$name = $popis[2]; // aleja
					}
					else
					{
						$name = $popis[2] . ' ' . $popis[3]; // aleja lux
					}
				}
				
				$category = Category::find()->where([strtolower('name')=>$name])->one();
				$parent_id = $category['id']; // 4
				
				// Typ zamku
				if (in_array('bb', $popis))
				{
					$typzamku = 'bb';
				}
				else if (in_array('pz', $popis))
				{
					$typzamku = 'pz';
				}
				else if (in_array('wc', $popis))
				{
					$typzamku = 'wc';
				}
				else if (in_array('uz', $popis))
				{
					$typzamku = 'uz';
				}
				
				$category2 = Category::find()->where([strtolower('name')=>$typzamku, 'parent_id'=>$parent_id])->one();
				$category_id = $category2['id'];
				
				return $category_id;
	}
}
