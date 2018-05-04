<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ZakaznikyCenovaHladina]].
 *
 * @see ZakaznikyCenovaHladina
 */
class ZakaznikyCenovaHladinaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ZakaznikyCenovaHladina[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ZakaznikyCenovaHladina|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
