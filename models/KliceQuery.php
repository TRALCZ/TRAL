<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Klice]].
 *
 * @see Klice
 */
class KliceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Klice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Klice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
