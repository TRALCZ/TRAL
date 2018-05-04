<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "norma".
 *
 * @property integer $id
 * @property string $name
 */
class Norma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'norma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zkratka'], 'required'],
            [['name'], 'string', 'max' => 100],
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
     * @return NormaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NormaQuery(get_called_class());
    }
}
