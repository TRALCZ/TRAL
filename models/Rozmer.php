<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rozmer".
 *
 * @property integer $id
 * @property integer $name
 */
class Rozmer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rozmer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'integer'],
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
			'cena' => Yii::t('app', 'Cena (bez DPH)'),
        ];
    }

    /**
     * @inheritdoc
     * @return RozmerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RozmerQuery(get_called_class());
    }
}
