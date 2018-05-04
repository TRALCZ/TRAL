<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rada".
 *
 * @property integer $id
 * @property string $name
 */
class Rada extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rada';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
			[['zakazniky_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
			'uuid' => Yii::t('app', 'UUID'),
			'zakazniky_id' => Yii::t('app', 'Dodavatele'),
            'name' => Yii::t('app', 'Název'),
        ];
    }

    /**
     * @inheritdoc
     * @return RadaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RadaQuery(get_called_class());
    }
	
	public function getZakazniky()
	{
		return $this->hasOne(Zakazniky::className(), ['id' => 'zakazniky_id']);
	}
}
