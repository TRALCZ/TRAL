<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merge_array_typ_options".
 *
 * @property int $id ID
 * @property int $title_array_typ_id ID Title Array Typ
 * @property string $name Název
 * @property string $znac Význam
 */
class MergeArrayTypOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merge_array_typ_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merge_array_typ_id', 'name', 'znac'], 'required'],
            [['merge_array_typ_id'], 'integer'],
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
            'merge_array_typ_id' => Yii::t('app', 'ID Merge Array Typ'),
            'name' => Yii::t('app', 'Název'),
            'znac' => Yii::t('app', 'Význam'),
        ];
    }

    /**
     * @inheritdoc
     * @return MergeArrayTypOptionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MergeArrayTypOptionsQuery(get_called_class());
    }
	
	public function getMerge_array_typ()
	{
		return $this->hasOne(MergeArrayTyp::className(), ['id' => 'merge_array_typ_id']);
	}
}
