<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VeplStationariesIssue;
//use app\models\VeplStationariesIssueSub;

/**
 * VeplStationariesIssueSearch represents the model behind the search form of `backend\models\VeplStationariesIssue`.
 */
class VeplStationariesIssueSearch extends VeplStationariesIssue {

 
    public $stationaries_id;
    public function rules() {
        return [
            [['id', 'stationaries_id'], 'integer'],
            [['issue_date', 'issued_to', 'remarks'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = VeplStationariesIssue::find();
        $query->joinWith(['issuesub']);
        $query->joinWith(['issuesub.stationaries']);
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
            'issue_date' => $this->issue_date,
            'issued_to' => $this->issued_to,          
        ]);
        $query ->andFilterWhere(['like', 'vepl_stationaries.item_name', $this->stationaries_id]) 
                ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }

}
