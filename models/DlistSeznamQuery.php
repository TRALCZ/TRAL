<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DlistSeznam]].
 *
 * @see DlistSeznam
 */
class DlistSeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DlistSeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DlistSeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
