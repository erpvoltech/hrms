<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StatutoryHr;

/**
 * StatutoryHrSearch represents the model behind the search form of `common\models\StatutoryHr`.
 */
class StatutoryHrSearch extends StatutoryHr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'list_no'], 'integer'],
            [['month', 'trrn_no'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = StatutoryHr::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['month'=>SORT_DESC]]
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
            'month' => $this->month,
            'list_no' => $this->list_no,
        ]);

        $query->andFilterWhere(['like', 'trrn_no', $this->trrn_no]);

        return $dataProvider;
    }
}