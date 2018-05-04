<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MergeArrayTypOptions]].
 *
 * @see MergeArrayTypOptions
 */
class MergeArrayTypOptionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MergeArrayTypOptions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MergeArrayTypOptions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
