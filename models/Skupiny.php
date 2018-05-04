<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "skupiny".
 *
 * @property int $id ID
 * @property string $id_ms ID MoneyS
 * @property string $name Název
 * @property int $id_cinnost Činnost
 * @property int $id_stredisko Středisko
 */
class Skupiny extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skupiny';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['cinnost_id', 'stredisko_id'], 'integer'],
            [['id_ms', 'name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_ms' => Yii::t('app', 'ID MoneyS'),
            'name' => Yii::t('app', 'Název'),
            'cinnost_id' => Yii::t('app', 'Činnost'),
            'stredisko_id' => Yii::t('app', 'Středisko'),
        ];
    }

    /**
     * @inheritdoc
     * @return SkupinyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SkupinyQuery(get_called_class());
    }
	
	public function getcinnost()
	{
		return $this->hasOne(Cinnost::className(), ['id' => 'cinnost_id']);
	}
	
	public function getstredisko()
	{
		return $this->hasOne(Stredisko::className(), ['id' => 'stredisko_id']);
	}
}
