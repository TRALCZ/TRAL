<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Faktury]].
 *
 * @see Faktury
 */
class FakturyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Faktury[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Faktury|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
