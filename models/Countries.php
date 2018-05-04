<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $name
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'uuid'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
			'uuid' => Yii::t('app', 'ID MoneyS'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @inheritdoc
     * @return CountriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountriesQuery(get_called_class());
    }
	
	public function getId($name)
	{
		$country = Countries::find()->where(['name'=>$name])->one();
		return $country->id;
	}
}
