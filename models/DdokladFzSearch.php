<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PdokladFz;

/**
 * PdokladFzSearch represents the model behind the search form about `app\models\PdokladFz`.
 */
class DdokladFzSearch extends DdokladFz
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['cislo', 'vystaveno', 'datetime_add', 'user_id', 'celkem', 'celkem_dph', 'faktury_zalohove_id'], 'safe'],
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
        $query = DdokladFz::find();

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

		$query->joinWith('user');
		
        // grid filtering conditions
        $query->andFilterWhere([
            'ddoklad_fz.id' => $this->id,
            'ddoklad_fz.cislo' => $this->cislo,
			//'vystaveno' => $this->vystaveno,
        ]);
		
		$vystaveno = $this->vystaveno;

		$query->andFilterWhere(['like', 'user.name', $this->user_id]);
		$query->andFilterWhere(['like', 'DATE_FORMAT(ddoklad_fz.vystaveno, "%d.%m.%Y")', $vystaveno]);

        return $dataProvider;
    }
}
