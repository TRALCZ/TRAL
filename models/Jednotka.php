<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jednotka".
 *
 * @property int $id ID
 * @property string $uuid UUID
 * @property string $name Název
 * @property string $zkratka Zkratka
 */
class Jednotka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jednotka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uuid'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 50],
            [['zkratka'], 'string', 'max' => 10],
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
            'name' => Yii::t('app', 'Název'),
            'zkratka' => Yii::t('app', 'Zkratka'),
        ];
    }

    /**
     * @inheritdoc
     * @return JednotkaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JednotkaQuery(get_called_class());
    }
}
