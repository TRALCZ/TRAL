<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CenikySeznam;

/**
 * CenikySeznamSearch represents the model behind the search form of `app\models\CenikySeznam`.
 */
class CenikySeznamSearch extends CenikySeznam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ceniky_id', 'typceny_id'], 'integer'],
            [['uuid', 'seznam_id'], 'safe'],
            [['cena'], 'number'],
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
        $query = CenikySeznam::find()->where(['ceniky_seznam.is_delete' => '0']);

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
		
		$query->leftJoin('seznam', 'seznam.id = ceniky_seznam.seznam_id');
		
        // grid filtering conditions
        $query->andFilterWhere([
            'ceniky_seznam.id' => $this->id,
            'ceniky_seznam.ceniky_id' => $this->ceniky_id,
			//'ceniky_seznam.seznam_id' => $this->seznam_id,
            'ceniky_seznam.cena' => $this->cena,
            'ceniky_seznam.typceny_id' => $this->typceny_id,
        ]);

        $query->andFilterWhere(['like', 'ceniky_seznam.uuid', $this->uuid]);
		$query->andFilterWhere(['like', 'seznam.name', $this->seznam_id]);

        return $dataProvider;
    }
}
