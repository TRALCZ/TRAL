<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Typzamku]].
 *
 * @see Typzamku
 */
class TypzamkuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Typzamku[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Typzamku|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
