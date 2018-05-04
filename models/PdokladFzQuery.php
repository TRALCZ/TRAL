<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PdokladFz]].
 *
 * @see PdokladFz
 */
class PdokladFzQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PdokladFz[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PdokladFz|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
