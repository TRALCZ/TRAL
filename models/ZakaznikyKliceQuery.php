<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ZakaznikyKlice]].
 *
 * @see ZakaznikyKlice
 */
class ZakaznikyKliceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ZakaznikyKlice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ZakaznikyKlice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
