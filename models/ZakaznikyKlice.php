<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zakazniky_klice".
 *
 * @property int $id ID
 * @property int $klice_id ID kliče
 * @property string $klice_uuid UUID kliče
 * @property int $zakazniky_id Zákazník
 */
class ZakaznikyKlice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zakazniky_klice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['klice_id', 'zakazniky_id'], 'integer'],
            [['zakazniky_id'], 'required'],
            [['klice_uuid'], 'string', 'max' => 36],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'klice_id' => Yii::t('app', 'ID kliče'),
            'klice_uuid' => Yii::t('app', 'UUID kliče'),
            'zakazniky_id' => Yii::t('app', 'Zákazník'),
        ];
    }

    /**
     * @inheritdoc
     * @return ZakaznikyKliceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZakaznikyKliceQuery(get_called_class());
    }
	
	public static function deleteKlice($zakazniky_id)
	{
		$models = ZakaznikyKlice::find()->where('zakazniky_id = ' . $zakazniky_id)->all();
		foreach ($models as $model) {
			$model->delete();
		}
	}
}
