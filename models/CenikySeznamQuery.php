<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CenikySeznam]].
 *
 * @see CenikySeznam
 */
class CenikySeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CenikySeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CenikySeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
