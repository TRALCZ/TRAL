<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MergeArrayZarubneTyp]].
 *
 * @see MergeArrayZarubneTyp
 */
class MergeArrayZarubneTypQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MergeArrayZarubneTyp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MergeArrayZarubneTyp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
