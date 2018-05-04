<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "druh".
 *
 * @property integer $id
 * @property string $name
 */
class Druh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'druh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    /**
     * @inheritdoc
     * @return DruhQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DruhQuery(get_called_class());
    }
}
