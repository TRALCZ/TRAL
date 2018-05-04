<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ZpusobyPlatby]].
 *
 * @see ZpusobyPlatby
 */
class ZpusobyPlatbyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ZpusobyPlatby[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ZpusobyPlatby|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
