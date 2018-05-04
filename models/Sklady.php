<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sklady".
 *
 * @property int $id ID
 * @property string $uuid UUID
 * @property string $name Název
 * @property string $kod Kod
 */
class Sklady extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sklady';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['uuid'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 150],
            [['kod'], 'string', 'max' => 50],
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
            'kod' => Yii::t('app', 'Kod'),
        ];
    }

    /**
     * @inheritdoc
     * @return SkladyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SkladyQuery(get_called_class());
    }
}
