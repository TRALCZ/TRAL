<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merge_array_zarubne_typ".
 *
 * @property int $id ID
 * @property string $name Název
 */
class MergeArrayZarubneTyp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merge_array_zarubne_typ';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 150],
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
        ];
    }

    /**
     * @inheritdoc
     * @return MergeArrayZarubneTypQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MergeArrayZarubneTypQuery(get_called_class());
    }
}
