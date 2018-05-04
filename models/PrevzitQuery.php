<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Prevzit]].
 *
 * @see Prevzit
 */
class PrevzitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Prevzit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Prevzit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
