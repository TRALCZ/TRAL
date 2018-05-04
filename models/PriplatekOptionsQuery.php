<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PriplatekOptions]].
 *
 * @see PriplatekOptions
 */
class PriplatekOptionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PriplatekOptions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PriplatekOptions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
