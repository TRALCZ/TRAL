<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "modely".
 *
 * @property integer $id
 * @property string $name
 */
class Modely extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modely';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cena'], 'required'],
            [['name'], 'string', 'max' => 150],
			[['rada_id'], 'integer'],
			[['image'], 'file', 'extensions' => 'png, jpg'],
			[['del_img'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Název'),
			'rada_id' => Yii::t('app', 'Řada'),
			'cena' => Yii::t('app', 'Cena (bez DPH)'),
			'image' => 'Obrázek',
			'file' => 'Obrázek',
			'del_img' => 'Smazat obrázek',
        ];
    }

    /**
     * @inheritdoc
     * @return ModelyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ModelyQuery(get_called_class());
    }
	
	public function getImageUrl()
	{
		//return Url::to('@web' . $this->image, true);
		if ($this->image)
		{
			return "<a rel='fancybox' title = '" . $this->name . "' href='" . Url::to('@web' . $this->image, true) . "'><i class='fa  fa-file-image-o' title='Pro zvětšení obrázku kliknite zde'></i></a>";
		}
		else
		{
			return "";
		}
			
		
	}
	
	public function getRada()
	{
		return $this->hasOne(Rada::className(), ['id' => 'rada_id']);
	}
	
	public function getCenovaHladina($idm)
	{
		$chladina = Modely::find()->where(['id' => $idm])->one();
		$arr = json_decode($chladina['c_hladina']);
			
		if (count($arr) >0)
		{	
			$res = '';
			foreach($arr as $ch)
			{
				$chl = \app\models\CenovaHladina::find()->where(['id' => $ch])->one();
				$res = $res  . "<span class='label label-success' style='font-size: 14px; margin-right: 10px;'>" . $chl['name'] . "</span>";
			}
		}
		else
		{
			$res = "---";
		}

		return $res;
	}
}
