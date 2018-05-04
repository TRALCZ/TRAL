<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "typzamku".
 *
 * @property integer $id
 * @property string $name
 * @property string $zkratka
 */
class Typzamku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'typzamku';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zkratka'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['zkratka'], 'string', 'max' => 50],
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
     * @return TypzamkuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypzamkuQuery(get_called_class());
    }
}
