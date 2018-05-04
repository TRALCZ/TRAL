<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ZakaznikySkupina]].
 *
 * @see ZakaznikySkupina
 */
class ZakaznikySkupinaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ZakaznikySkupina[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ZakaznikySkupina|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
