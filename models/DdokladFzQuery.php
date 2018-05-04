<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DdokladFz]].
 *
 * @see DdokladFz
 */
class DdokladFzQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DdokladFz[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DdokladFz|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
