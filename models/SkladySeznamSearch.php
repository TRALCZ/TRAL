<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SkladySeznam;

/**
 * SkladySeznamSearch represents the model behind the search form of `app\models\SkladySeznam`.
 */
class SkladySeznamSearch extends SkladySeznam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sklady_id', 'stav_zasoby', 'objednano', 'rezervace', 'predpokladny_stav', 'zasoba_pojistna'], 'integer'],
            [['uuid', 'seznam_id'], 'safe'],
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
        $query = SkladySeznam::find()->where(['sklady_seznam.is_delete' => '0']);

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

		$query->leftJoin('seznam', 'seznam.id = sklady_seznam.seznam_id');
		
        // grid filtering conditions
        $query->andFilterWhere(['sklady_seznam.sklady_id' => $this->sklady_id]);
        $query->andFilterWhere(['like', 'sklady_seznam.uuid', $this->uuid]);
		$query->andFilterWhere(['like', 'seznam.name', $this->seznam_id]);
		$query->andFilterWhere(['like', 'sklady_seznam.stav_zasoby', $this->stav_zasoby]);
		$query->andFilterWhere(['like', 'sklady_seznam.objednano', $this->objednano]);
		$query->andFilterWhere(['like', 'sklady_seznam.rezervace', $this->rezervace]);
		$query->andFilterWhere(['like', 'sklady_seznam.predpokladny_stav', $this->predpokladny_stav]);
		$query->andFilterWhere(['like', 'sklady_seznam.zasoba_pojistna', $this->zasoba_pojistna]);

        return $dataProvider;
    }
}
