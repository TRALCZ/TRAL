<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ModelyOdstin;

/**
 * ModelyOdstinSearch represents the model behind the search form about `app\models\ModelyOdstin`.
 */
class ModelyOdstinSearch extends ModelyOdstin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'modely_id', 'odstin_id'], 'integer'],
			[['cena_odstin'], 'safe'],
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
        $query = ModelyOdstin::find();

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
            'modely_id' => $this->modely_id,
            'odstin_id' => $this->odstin_id,
        ]);
		
		$query->andFilterWhere(['like', 'cena_odstin', $this->cena_odstin]);

        return $dataProvider;
    }
}
