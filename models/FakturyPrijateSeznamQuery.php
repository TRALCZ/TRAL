<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FakturyPrijateSeznam]].
 *
 * @see FakturyPrijateSeznam
 */
class FakturyPrijateSeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FakturyPrijateSeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FakturyPrijateSeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
