<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Rozmer]].
 *
 * @see Rozmer
 */
class RozmerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Rozmer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Rozmer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
