<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vypln".
 *
 * @property integer $id
 * @property string $name
 * @property string $zkratka
 */
class Vypln extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vypln';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zkratka'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['zkratka'], 'string', 'max' => 10],
			[['cena'], 'safe'],
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
			'cena' => Yii::t('app', 'Cena (bez DPH)'),
        ];
    }

    /**
     * @inheritdoc
     * @return VyplnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VyplnQuery(get_called_class());
    }
}
