<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Modely]].
 *
 * @see Modely
 */
class ModelyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Modely[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Modely|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
