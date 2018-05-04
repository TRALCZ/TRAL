<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zakazniky_ceniky".
 *
 * @property int $id ID
 * @property int $ceniky_id ID ceniky
 * @property string $ceniky_uuid UUID ceniky
 * @property int $zakazniky_id Zákazník
 */
class ZakaznikyCeniky extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zakazniky_ceniky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ceniky_id', 'zakazniky_id'], 'integer'],
            [['zakazniky_id'], 'required'],
            [['ceniky_uuid'], 'string', 'max' => 36],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ceniky_id' => Yii::t('app', 'ID ceniky'),
            'ceniky_uuid' => Yii::t('app', 'UUID ceniky'),
            'zakazniky_id' => Yii::t('app', 'Zákazník'),
        ];
    }

    /**
     * @inheritdoc
     * @return ZakaznikyCenikyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZakaznikyCenikyQuery(get_called_class());
    }
	
	public static function deleteCN($zakazniky_id)
	{
		$models = ZakaznikyCeniky::find()->where('zakazniky_id = ' . $zakazniky_id)->all();
		foreach ($models as $model)
		{
			$model->delete();
		}
	}
}
