<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Ventilace]].
 *
 * @see Ventilace
 */
class VentilaceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Ventilace[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Ventilace|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
