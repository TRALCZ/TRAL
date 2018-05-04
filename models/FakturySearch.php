<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Faktury;

/**
 * FakturySearch represents the model behind the search form about `app\models\Faktury`.
 */
class FakturySearch extends Faktury
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nabidky_id', 'zpusoby_platby_id', 'zakazniky_id', 'user_id'], 'integer'],
            [['cislo', 'popis', 'vystaveno', 'platnost', 'datetime_add'], 'safe'],
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
         $query = Faktury::find();

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
		
		$query->joinWith('zpusoby_platby');
		$query->joinWith('zakazniky');
		$query->joinWith('user');
		
        // grid filtering conditions
        $query->andFilterWhere([
            'faktury.id' => $this->id,
            'faktury.cislo' => $this->cislo,
			//'vystaveno' => $this->vystaveno,
        ]);
		
		$vystaveno = $this->vystaveno;

        $query->andFilterWhere(['like', 'popis', $this->popis]);
		$query->andFilterWhere(['like', 'zpusoby_platby.name', $this->zpusoby_platby_id]);
		$query->andFilterWhere(['like', 'zakazniky.name', $this->zakazniky_id]);
		$query->andFilterWhere(['like', 'user.name', $this->user_id]);
		$query->andFilterWhere(['like', 'DATE_FORMAT(faktury.vystaveno, "%d.%m.%Y")', $vystaveno]);

        return $dataProvider;
    }
}