<?php

namespace app\models;

use Yii;
use app\models\Priplatek;
/**
 * This is the model class for table "priplatek_options".
 *
 * @property int $id ID
 * @property string $uuid UUID
 * @property int $priplatek_id Příplatek
 * @property string $name Název
 * @property string $zkratka Zkratka
 */
class PriplatekOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'priplatek_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priplatek_id', 'name', 'cena'], 'required'],
            [['priplatek_id'], 'integer'],
            [['uuid'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 150],
            [['zkratka'], 'string', 'max' => 50],
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
            'uuid' => Yii::t('app', 'UUID'),
            'priplatek_id' => Yii::t('app', 'Příplatek'),
            'name' => Yii::t('app', 'Název'),
            'zkratka' => Yii::t('app', 'Zkratka'),
			'cena' => Yii::t('app', 'Cena (bez DPH)'),
        ];
    }

    /**
     * @inheritdoc
     * @return PriplatekOptionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PriplatekOptionsQuery(get_called_class());
    }
	
	public function getPriplatek()
	{
		return $this->hasOne(Priplatek::className(), ['id' => 'priplatek_id']);
	}
}
