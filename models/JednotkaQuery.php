<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Jednotka]].
 *
 * @see Jednotka
 */
class JednotkaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Jednotka[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Jednotka|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
