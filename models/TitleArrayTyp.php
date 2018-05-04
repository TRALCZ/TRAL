<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "title_array_typ".
 *
 * @property int $id ID
 * @property string $name Název
 */
class TitleArrayTyp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'title_array_typ';
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
     * @return TitleArrayTypQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TitleArrayTypQuery(get_called_class());
    }
}
