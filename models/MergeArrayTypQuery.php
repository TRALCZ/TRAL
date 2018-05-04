<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MergeArrayTyp]].
 *
 * @see MergeArrayTyp
 */
class MergeArrayTypQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MergeArrayTyp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MergeArrayTyp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
