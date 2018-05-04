<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zpusoby_platby".
 *
 * @property integer $id
 * @property string $name
 */
class ZpusobyPlatby extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zpusoby_platby';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Způsob platby',
        ];
    }

    /**
     * @inheritdoc
     * @return ZpusobyPlatbyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZpusobyPlatbyQuery(get_called_class());
    }
}
