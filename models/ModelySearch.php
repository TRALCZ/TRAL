<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Modely;

/**
 * ModelySearch represents the model behind the search form about `app\models\Modely`.
 */
class ModelySearch extends Modely
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rada_id'], 'integer'],
            [['name', 'cena'], 'safe'],
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
        $query = Modely::find();

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
			'rada_id' => $this->rada_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
		$query->andFilterWhere(['like', 'cena', $this->cena]);

        return $dataProvider;
    }
}
