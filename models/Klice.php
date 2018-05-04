<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "klice".
 *
 * @property integer $id
 * @property string $name
 * @property string $zobrazovat
 */
class Klice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'klice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['zobrazovat'], 'string'],
            [['name', 'uuid'], 'string', 'max' => 100],
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
            'zobrazovat' => Yii::t('app', 'Zobrazovat'),
        ];
    }

    /**
     * @inheritdoc
     * @return KliceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KliceQuery(get_called_class());
    }
}
