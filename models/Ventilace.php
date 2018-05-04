<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ventilace".
 *
 * @property integer $id
 * @property string $name
 * @property string $zkratka
 */
class Ventilace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ventilace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zkratka'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['zkratka'], 'string', 'max' => 10],
			[['cena'], 'safe'],
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
            'zkratka' => Yii::t('app', 'Zkratka'),
			'cena' => Yii::t('app', 'Cena (bez DPH)'),
        ];
    }

    /**
     * @inheritdoc
     * @return VentilaceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VentilaceQuery(get_called_class());
    }
}
