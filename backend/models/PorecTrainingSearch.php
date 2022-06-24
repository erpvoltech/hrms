<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PorecTraining;

/**
 * PorecTrainingSearch represents the model behind the search form of `app\models\PorecTraining`.
 */
class PorecTrainingSearch extends PorecTraining
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'division', 'unit_id', 'department_id', 'trainig_topic_id', 'ecode', 'batch_id'], 'integer'],
            [['training_type', 'training_startdate', 'training_enddate', 'created_date', 'created_by'], 'safe'],
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
        $query = PorecTraining::find();

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
            'division' => $this->division,
            'unit_id' => $this->unit_id,
            'department_id' => $this->department_id,
            'training_startdate' => $this->training_startdate,
            'training_enddate' => $this->training_enddate,
            'trainig_topic_id' => $this->trainig_topic_id,
            'batch_id' => $this->batch_id,
            'ecode' => $this->ecode,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'training_type', $this->training_type])
            ->andFilterWhere(['like', 'created_by', $this->created_by]);

        return $dataProvider;
    }
}