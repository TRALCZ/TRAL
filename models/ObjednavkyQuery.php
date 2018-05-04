<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Objednavky]].
 *
 * @see Objednavky
 */
class ObjednavkyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Objednavky[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Objednavky|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
