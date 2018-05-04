<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "title_array_typ_options".
 *
 * @property int $id ID
 * @property int $title_array_typ_id ID Title Array Typ
 * @property string $name Název
 * @property string $znac Význam
 */
class TitleArrayTypOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'title_array_typ_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_array_typ_id', 'name', 'znac'], 'required'],
            [['title_array_typ_id'], 'integer'],
            [['name', 'znac'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title_array_typ_id' => Yii::t('app', 'ID Title Array Typ'),
            'name' => Yii::t('app', 'Název'),
            'znac' => Yii::t('app', 'Význam'),
        ];
    }

    /**
     * @inheritdoc
     * @return TitleArrayTypOptionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TitleArrayTypOptionsQuery(get_called_class());
    }
	
	public function getTitle_array_typ()
	{
		return $this->hasOne(TitleArrayTyp::className(), ['id' => 'title_array_typ_id']);
	}
}
