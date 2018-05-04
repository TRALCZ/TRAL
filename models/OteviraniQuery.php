<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Otevirani]].
 *
 * @see Otevirani
 */
class OteviraniQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Otevirani[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Otevirani|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
