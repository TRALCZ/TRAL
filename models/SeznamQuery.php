<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Seznam]].
 *
 * @see Seznam
 */
class SeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Seznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Seznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
