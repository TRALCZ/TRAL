<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Vypln]].
 *
 * @see Vypln
 */
class VyplnQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Vypln[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Vypln|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
