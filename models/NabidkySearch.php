<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nabidky;

/**
 * NabidkySearch represents the model behind the search form about `app\models\Nabidky`.
 */
class NabidkySearch extends Nabidky
{
    public $zpusob_platby;
	
	
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cislo'], 'integer'],
            [['name', 'zpusoby_platby_id', 'zakazniky_id', 'zpusoby_platby', 'zakazniky', 'user_id', 'vystaveno', 'status_id', 'skupiny_id'], 'safe'],
			//[['vystaveno'], 'date']
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
        $query = Nabidky::find();
		
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

		$query->joinWith('zpusoby_platby');
		$query->joinWith('zakazniky');
		$query->joinWith('status');
		$query->joinWith('user');
		$query->joinWith('skupiny');
		
        // grid filtering conditions
        $query->andFilterWhere([
            'nabidky.id' => $this->id,
            'nabidky.cislo' => $this->cislo,
			//'vystaveno' => $this->vystaveno,
        ]);
		
		$vystaveno = $this->vystaveno;

        $query->andFilterWhere(['like', 'name', $this->name]);
		$query->andFilterWhere(['like', 'zpusoby_platby.name', $this->zpusoby_platby_id]);
		$query->andFilterWhere(['like', 'zakazniky.name', $this->zakazniky_id]);
		$query->andFilterWhere(['like', 'status.name', $this->status_id]);
		$query->andFilterWhere(['like', 'user.name', $this->user_id]);
		$query->andFilterWhere(['like', 'skupiny.name', $this->skupiny_id]);
		$query->andFilterWhere(['like', 'DATE_FORMAT(nabidky.vystaveno, "%d.%m.%Y")', $vystaveno]);
		$query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
