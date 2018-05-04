<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Zakazniky;

/**
 * ZakaznikySearch represents the model behind the search form about `app\models\Zakazniky`.
 */
class ZakaznikySearch extends Zakazniky
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'zakazniky_skupina_id'], 'integer'],
            [['o_name', 'f_name', 'p_name', 'phone', 'email', 'ico', 'dic', 'kontaktni_osoba', 'f_ulice', 'f_mesto', 'f_psc', 'f_countries_id', 'p_ulice', 'p_mesto', 'p_psc', 'p_countries_id', 'datetime'], 'safe'],
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
        $query = Zakazniky::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'zakazniky_skupina_id', $this->zakazniky_skupina_id])
			->andFilterWhere(['like', 'o_name', $this->o_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'ico', $this->ico])
            ->andFilterWhere(['like', 'dic', $this->dic])
            ->andFilterWhere(['like', 'kontaktni_osoba', $this->kontaktni_osoba])
            ->andFilterWhere(['like', 'f_ulice', $this->f_ulice])
            ->andFilterWhere(['like', 'f_mesto', $this->f_mesto])
            ->andFilterWhere(['like', 'f_psc', $this->f_psc])
            //->andFilterWhere(['like', 'f_zeme', $this->f_zeme])
            ->andFilterWhere(['like', 'p_ulice', $this->p_ulice])
            ->andFilterWhere(['like', 'p_mesto', $this->p_mesto])
            ->andFilterWhere(['like', 'p_psc', $this->p_psc]);
            //->andFilterWhere(['like', 'p_zeme', $this->p_zeme]);
		

        return $dataProvider;
    }
}
