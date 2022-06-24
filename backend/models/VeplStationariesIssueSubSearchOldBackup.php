<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VeplStationariesIssueSub;

/**
 * VeplStationariesIssueSubSearch represents the model behind the search form of `backend\models\VeplStationariesIssueSub`.
 */
class VeplStationariesIssueSubSearch extends VeplStationariesIssueSub
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'issue_id', 'issue_item_id', 'issued_qty'], 'integer'],
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
        $query = VeplStationariesIssueSub::find();

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
            'issue_id' => $this->issue_id,
            'issue_item_id' => $this->issue_item_id,
            'issued_qty' => $this->issued_qty,
        ]);

        return $dataProvider;
    }
}
