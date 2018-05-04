<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zakazniky_cenova_hladina".
 *
 * @property int $id ID
 * @property int $cenova_hladina_id ID cenová hladina
 * @property string $cenova_hladina_uuid UUID cenová hladina
 * @property int $zakazniky_id Zákazník
 */
class ZakaznikyCenovaHladina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zakazniky_cenova_hladina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cenova_hladina_id', 'zakazniky_id'], 'integer'],
            [['zakazniky_id'], 'required'],
            [['cenova_hladina_uuid'], 'string', 'max' => 36],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cenova_hladina_id' => Yii::t('app', 'ID cenová hladina'),
            'cenova_hladina_uuid' => Yii::t('app', 'UUID cenová hladina'),
            'zakazniky_id' => Yii::t('app', 'Zákazník'),
        ];
    }

    /**
     * @inheritdoc
     * @return ZakaznikyCenovaHladinaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZakaznikyCenovaHladinaQuery(get_called_class());
    }
	
	public static function deleteCH($zakazniky_id)
	{
		$models = ZakaznikyCenovaHladina::find()->where('zakazniky_id = ' . $zakazniky_id)->all();
		foreach ($models as $model)
		{
			$model->delete();
		}
	}
}
