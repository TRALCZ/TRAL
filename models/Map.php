<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "map".
 *
 * @property integer $id
 * @property integer $zakazka
 * @property string $city
 * @property string $address
 * @property string $postalCode
 * @property string $country
 * @property string $htmlContent
 * @property string $datetime_add
 */
class Map extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zakazka'], 'required'],
            [['zakazka'], 'integer'],
            [['datetime_add', 'sum', 'sumod', 'poznamka'], 'safe'],
            [['city', 'address', 'country', 'htmlContent'], 'string', 'max' => 255],
			[['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xml', 'mimeTypes' => 'text/xml, application/xml'],
            [['postalCode'], 'string', 'max' => 10],
			[['phone'], 'string', 'max' => 50],
			[['num'], 'string', 'max' => 20],
			[['icount'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'zakazka' => Yii::t('app', 'Zakázka'),
			'num' => Yii::t('app', 'Číslo dokladu'),
			'name' => Yii::t('app', 'Název'),
            'city' => Yii::t('app', 'Město'),
            'address' => Yii::t('app', 'Ulice'),
            'postalCode' => Yii::t('app', 'PSČ'),
            'country' => Yii::t('app', 'Stát'),
			'phone' => Yii::t('app', 'Telefon'),
			'email' => Yii::t('app', 'Email'),
			'sum' => Yii::t('app', 'Celkem vč. DPH'),
			'poznamka' => Yii::t('app', 'Poznámka k termínům'),
			'icount' => Yii::t('app', 'Počet položek'),
            'htmlContent' => Yii::t('app', 'Informace'),
			'file' => Yii::t('app', 'File'),
			'sumod' => Yii::t('app', 'Častka od (v Kč)'),
            'datetime_add' => Yii::t('app', 'Přidáno'),
        ];
    }

    /**
     * @inheritdoc
     * @return MapQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapQuery(get_called_class());
    }
	
	public function zakazkaMax()
	{
		return $this::find()->max('zakazka');
	}
	
	public function truncate()
	{
		return Yii::$app->db->createCommand()->truncateTable('map')->execute();
	}
}
