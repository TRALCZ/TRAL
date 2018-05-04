<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FakturyZalohoveSeznam]].
 *
 * @see FakturyZalohoveSeznam
 */
class FakturyZalohoveSeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FakturyZalohoveSeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FakturyZalohoveSeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
