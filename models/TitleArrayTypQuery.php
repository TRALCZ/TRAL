<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TitleArrayTyp]].
 *
 * @see TitleArrayTyp
 */
class TitleArrayTypQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TitleArrayTyp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TitleArrayTyp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
