<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[XmlImport]].
 *
 * @see XmlImport
 */
class XmlImportQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return XmlImport[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return XmlImport|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
