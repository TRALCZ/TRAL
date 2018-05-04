<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Ucty]].
 *
 * @see Ucty
 */
class UctyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Ucty[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Ucty|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
