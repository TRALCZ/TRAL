<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "typ".
 *
 * @property integer $id
 * @property string $name
 */
class Typ extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'typ';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 250],
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
     * @return TypQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypQuery(get_called_class());
    }
}
