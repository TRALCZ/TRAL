<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Objednavky;

/**
 * ObjednavkySearch represents the model behind the search form about `app\models\Objednavky`.
 */
class ObjednavkySearch extends Objednavky
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cislo'], 'integer'],
            [['popis', 'zpusoby_platby_id', 'zakazniky_id', 'zpusoby_platby', 'zakazniky', 'user_id', 'vystaveno'], 'safe'],
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
        $query = Objednavky::find();

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
            'objednavky.id' => $this->id,
            'objednavky.cislo' => $this->cislo,
			//'vystaveno' => $this->vystaveno,
        ]);
		
		$vystaveno = $this->vystaveno;

        $query->andFilterWhere(['like', 'popis', $this->popis]);
		$query->andFilterWhere(['like', 'zpusoby_platby.name', $this->zpusoby_platby_id]);
		$query->andFilterWhere(['like', 'zakazniky.name', $this->zakazniky_id]);
		$query->andFilterWhere(['like', 'user.name', $this->user_id]);
		$query->andFilterWhere(['like', 'DATE_FORMAT(objednavky.vystaveno, "%d.%m.%Y")', $vystaveno]);

        return $dataProvider;
    }
}
