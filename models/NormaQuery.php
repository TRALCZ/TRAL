<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Norma]].
 *
 * @see Norma
 */
class NormaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Norma[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Norma|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
