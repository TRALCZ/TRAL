<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stredisko".
 *
 * @property int $id ID
 * @property string $id_ms ID MoneyS
 * @property string $kod Kod
 * @property string $name Název
 */
class Stredisko extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stredisko';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id_ms'], 'string', 'max' => 50],
            [['kod', 'name'], 'string', 'max' => 150],
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
            'kod' => Yii::t('app', 'Kod'),
            'name' => Yii::t('app', 'Název'),
        ];
    }

    /**
     * @inheritdoc
     * @return StrediskoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StrediskoQuery(get_called_class());
    }
}
