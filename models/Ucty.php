<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ucty".
 *
 * @property integer $id
 * @property string $name
 * @property string $suma
 */
class Ucty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ucty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['suma'], 'number'],
            [['name'], 'string', 'max' => 100],
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
            'suma' => Yii::t('app', 'Částka'),
        ];
    }

    /**
     * @inheritdoc
     * @return UctyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UctyQuery(get_called_class());
    }
}
