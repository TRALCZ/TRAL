<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Priplatek]].
 *
 * @see Priplatek
 */
class PriplatekQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Priplatek[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Priplatek|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
