<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prevzit".
 *
 * @property string $id
 * @property string $name
 */
class Prevzit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prevzit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @inheritdoc
     * @return PrevzitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PrevzitQuery(get_called_class());
    }
}
