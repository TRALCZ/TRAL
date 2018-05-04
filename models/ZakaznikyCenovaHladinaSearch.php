<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ZakaznikyCenovaHladina;

/**
 * ZakaznikyCenovaHladinaSearch represents the model behind the search form of `app\models\ZakaznikyCenovaHladina`.
 */
class ZakaznikyCenovaHladinaSearch extends ZakaznikyCenovaHladina
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cenova_hladina_id', 'zakazniky_id'], 'integer'],
            [['cenova_hladina_uuid'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ZakaznikyCenovaHladina::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cenova_hladina_id' => $this->cenova_hladina_id,
            'zakazniky_id' => $this->zakazniky_id,
        ]);

        $query->andFilterWhere(['like', 'cenova_hladina_uuid', $this->cenova_hladina_uuid]);

        return $dataProvider;
    }
}
