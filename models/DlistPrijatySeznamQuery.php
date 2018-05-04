<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DlistPrijatySeznam]].
 *
 * @see DlistPrijatySeznam
 */
class DlistPrijatySeznamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DlistPrijatySeznam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DlistPrijatySeznam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
