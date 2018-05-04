<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Druh]].
 *
 * @see Druh
 */
class DruhQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Druh[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Druh|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
