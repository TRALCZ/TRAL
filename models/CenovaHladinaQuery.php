<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CenovaHladina]].
 *
 * @see CenovaHladina
 */
class CenovaHladinaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CenovaHladina[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CenovaHladina|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
