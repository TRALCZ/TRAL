<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "otevirani".
 *
 * @property integer $id
 * @property string $name
 * @property string $zkratka
 */
class Otevirani extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'otevirani';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zkratka'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['zkratka'], 'string', 'max' => 20],
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
        ];
    }

    /**
     * @inheritdoc
     * @return OteviraniQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OteviraniQuery(get_called_class());
    }
}
