<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ObjednavkySeznam]].
 *
 * @see ObjednavkySeznam
 */
class ModelyOdstinQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ObjednavkySeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ObjednavkySeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}