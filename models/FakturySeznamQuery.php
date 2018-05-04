<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FakturySeznam]].
 *
 * @see FakturySeznam
 */
class FakturySeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FakturySeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FakturySeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
