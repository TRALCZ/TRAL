<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Seznam;

/**
 * SeznamSearch represents the model behind the search form about `app\models\Seznam`.
 */
class SeznamSearch extends Seznam
{
    /**
     * @inheritdoc
     */
	
	
    public function rules()
    {
        
		return [
            [['id', 'category_id', 'typ_id', 'norma_id', 'modely_id', 'odstin_id', 'rozmer_id', 'otevirani_id', 'typzamku_id', 'vypln_id', 'ventilace_id'], 'integer'],
            [['name', 'kod', 'uuid', 'hmotnost'], 'safe'],
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
        $query = Seznam::find()->where(['seznam.is_delete' => '0']);

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

        $query->andFilterWhere([
            'uuid' => $this->uuid,
			'category_id' => $this->category_id,
        ]);

		$query->andFilterWhere(['like', 'kod', $this->kod]);
        $query->andFilterWhere(['like', 'name', $this->name]);
		$query->andFilterWhere(['like', 'hmotnost', $this->hmotnost]);
		//$query->andFilterWhere(['like', 'category_id', $this->category_id]);
		
        return $dataProvider;
    }
}
