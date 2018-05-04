<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[NabidkySeznam]].
 *
 * @see NabidkySeznam
 */
class NabidkySeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NabidkySeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NabidkySeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
