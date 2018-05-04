<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Zakazniky]].
 *
 * @see Zakazniky
 */
class ZakaznikyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Zakazniky[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Zakazniky|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
