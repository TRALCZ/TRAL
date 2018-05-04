<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "priplatek".
 *
 * @property int $id ID
 * @property string $uuid UUID
 * @property string $name Název
 * @property string $smazat Smazat
 */
class Priplatek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'priplatek';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['smazat'], 'string'],
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
            'smazat' => Yii::t('app', 'Smazat'),
        ];
    }

    /**
     * @inheritdoc
     * @return PriplatekQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PriplatekQuery(get_called_class());
    }
}
