<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FakturyPrijateSeznam;

/**
 * FakturyPrijateSeznamSearch represents the model behind the search form about `app\models\FakturyPrijateSeznam`.
 */
class FakturyPrijateSeznamSearch extends FakturyPrijateSeznam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'faktury_prijate_id', 'seznam_id', 'pocet', 'sazba_dph'], 'integer'],
            [['cena', 'sleva', 'celkem', 'celkem_dph', 'vcetne_dph'], 'number'],
            [['typ_ceny'], 'safe'],
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
        $query = FakturyPrijateSeznam::find();

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
            'faktury_prijate_id' => $this->faktury_prijate_id,
            'seznam_id' => $this->seznam_id,
            'pocet' => $this->pocet,
            'cena' => $this->cena,
            'sazba_dph' => $this->sazba_dph,
            'sleva' => $this->sleva,
            'celkem' => $this->celkem,
            'celkem_dph' => $this->celkem_dph,
            'vcetne_dph' => $this->vcetne_dph,
        ]);

        $query->andFilterWhere(['like', 'typ_ceny', $this->typ_ceny]);

        return $dataProvider;
    }
}
