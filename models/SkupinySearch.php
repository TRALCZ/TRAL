<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Skupiny;

/**
 * SkupinySearch represents the model behind the search form of `app\models\Skupiny`.
 */
class SkupinySearch extends Skupiny
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cinnost_id', 'stredisko_id'], 'integer'],
            [['id_ms', 'name'], 'safe'],
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
        $query = Skupiny::find();

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
            'cinnost_id' => $this->cinnost_id,
            'stredisko_id' => $this->stredisko_id,
        ]);

        $query->andFilterWhere(['like', 'id_ms', $this->id_ms])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
