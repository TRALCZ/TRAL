<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Rada]].
 *
 * @see Rada
 */
class RadaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Rada[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Rada|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
