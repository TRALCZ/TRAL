<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Skupiny]].
 *
 * @see Skupiny
 */
class SkupinyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Skupiny[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Skupiny|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
