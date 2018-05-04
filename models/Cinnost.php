<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cinnost".
 *
 * @property int $id ID
 * @property string $id_ms ID MoneyS
 * @property string $kod Kod
 * @property string $name Název
 */
class Cinnost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	
	/*
	public static function getDb() {
        return Yii::$app->dbms;
    }
	*/

    public static function tableName()
    {
        return 'cinnost';
    }

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id_ms', 'kod', 'name'], 'string', 'max' => 50],
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
     * @return CinnostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CinnostQuery(get_called_class());
    }
}
