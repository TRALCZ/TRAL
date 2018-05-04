<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pdoklad_fz".
 *
 * @property integer $id
 * @property integer $faktury_zalohove_id
 * @property string $cislo
 * @property integer $castka
 * @property integer $user_id
 * @property string $datetime_add
 */
class PdokladFz extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pdoklad_fz';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['faktury_zalohove_id', 'user_id'], 'integer'],
            [['user_id', 'datetime_add'], 'required'],
            [['castka', 'vystaveno', 'datetime_add'], 'safe'],
            [['cislo'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'faktury_zalohove_id' => Yii::t('app', 'ID Faktury zálohové'),
            'cislo' => Yii::t('app', 'Číslo'),
            'castka' => Yii::t('app', 'Částka vč. DPH'),
            'user_id' => Yii::t('app', 'Vystavil'),
			'vystaveno' => Yii::t('app', 'Datum vystavení'),
            'datetime_add' => Yii::t('app', 'Přidáno'),
			
        ];
    }

    /**
     * @inheritdoc
     * @return PdokladFzQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PdokladFzQuery(get_called_class());
    }
	
	public function getuser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	public function getfaktury_zalohove()
	{
		return $this->hasOne(FakturyZalohove::className(), ['id' => 'faktury_zalohove_id']);
	}
}
