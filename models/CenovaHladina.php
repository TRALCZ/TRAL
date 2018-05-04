<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cenova_hladina".
 *
 * @property integer $id
 * @property string $name
 */
class CenovaHladina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cenova_hladina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'procent'], 'required'],
            [['name', 'uuid'], 'string', 'max' => 150],
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
			'procent' => Yii::t('app', 'Procenty'),
        ];
    }

    /**
     * @inheritdoc
     * @return CenovaHladinaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CenovaHladinaQuery(get_called_class());
    }
}
