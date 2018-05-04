<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SkladySeznam]].
 *
 * @see SkladySeznam
 */
class SkladySeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SkladySeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SkladySeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
