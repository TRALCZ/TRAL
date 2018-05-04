<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PriplatekModel]].
 *
 * @see PriplatekModel
 */
class PriplatekModelQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PriplatekModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PriplatekModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
