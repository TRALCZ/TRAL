<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "typceny".
 *
 * @property int $id ID
 * @property string $uuid UUID
 * @property string $name Název
 */
class Typceny extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'typceny';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uuid'], 'string', 'max' => 36],
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
            'uuid' => Yii::t('app', 'UUID'),
            'name' => Yii::t('app', 'Název'),
        ];
    }

    /**
     * @inheritdoc
     * @return TypcenyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypcenyQuery(get_called_class());
    }
}
