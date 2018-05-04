<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FakturyZalohove]].
 *
 * @see FakturyZalohove
 */
class FakturyZalohoveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FakturyZalohove[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FakturyZalohove|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
