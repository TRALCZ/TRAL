<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TitleArrayTypOptions]].
 *
 * @see TitleArrayTypOptions
 */
class TitleArrayTypOptionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TitleArrayTypOptions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TitleArrayTypOptions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
