<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merge_array_zarubne_typ_options".
 *
 * @property int $id ID
 * @property int $merge_array_zarubne_typ_id ID Merge Array Zarubne Typ
 * @property string $name Název
 * @property string $znac Význam
 */
class MergeArrayZarubneTypOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merge_array_zarubne_typ_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merge_array_zarubne_typ_id', 'name', 'znac'], 'required'],
            [['merge_array_zarubne_typ_id'], 'integer'],
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
            'merge_array_zarubne_typ_id' => Yii::t('app', 'ID Merge Array Zarubne Typ'),
            'name' => Yii::t('app', 'Název'),
            'znac' => Yii::t('app', 'Význam'),
        ];
    }

    /**
     * @inheritdoc
     * @return MergeArrayZarubneTypOptionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MergeArrayZarubneTypOptionsQuery(get_called_class());
    }
	
	public function getMerge_array_zarubne_typ()
	{
		return $this->hasOne(MergeArrayZarubneTyp::className(), ['id' => 'merge_array_zarubne_typ_id']);
	}
}
