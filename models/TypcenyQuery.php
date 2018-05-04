<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Typceny]].
 *
 * @see Typceny
 */
class TypcenyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Typceny[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Typceny|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
