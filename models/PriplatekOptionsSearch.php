<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PriplatekOptions;

/**
 * PriplatekOptionsSearch represents the model behind the search form of `app\models\PriplatekOptions`.
 */
class PriplatekOptionsSearch extends PriplatekOptions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'priplatek_id'], 'integer'],
            [['uuid', 'name', 'zkratka', 'cena'], 'safe'],
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
        $query = PriplatekOptions::find();

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
            'priplatek_id' => $this->priplatek_id,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'zkratka', $this->zkratka])
			->andFilterWhere(['like', 'cena', $this->cena]);

        return $dataProvider;
    }
}
