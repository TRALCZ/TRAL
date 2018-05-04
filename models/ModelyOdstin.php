<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modely_odstin".
 *
 * @property integer $id
 * @property integer $modely_id
 * @property integer $odstin_id
 */
class ModelyOdstin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modely_odstin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modely_id', 'odstin_id', 'cena_odstin'], 'required'],
            [['modely_id', 'odstin_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'modely_id' => Yii::t('app', 'Modely'),
            'odstin_id' => Yii::t('app', 'Odstín'),
			'cena_odstin' => Yii::t('app', 'Cena odstínu (bez DPH)'),
        ];
    }

    /**
     * @inheritdoc
     * @return ModelyOdstinQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ModelyOdstinQuery(get_called_class());
    }
	
	public function getModely()
	{
		return $this->hasOne(Modely::className(), ['id' => 'modely_id']);
	}
	
	public function getOdstin()
	{
		return $this->hasOne(Odstin::className(), ['id' => 'odstin_id']);
	}
}
