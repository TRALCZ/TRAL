<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "odstin".
 *
 * @property integer $id
 * @property string $name
 */
class Odstin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'odstin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150],
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
        ];
    }

    /**
     * @inheritdoc
     * @return OdstinQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OdstinQuery(get_called_class());
    }
}
