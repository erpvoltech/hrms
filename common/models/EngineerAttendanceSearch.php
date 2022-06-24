<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EngineerAttendance;

/**
 * EngineerAttendanceSearch represents the model behind the search form of `common\models\EngineerAttendance`.
 */
class EngineerAttendanceSearch extends EngineerAttendance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'emp_id', 'project_id'], 'integer'],
            [['date', 'attendance'], 'safe'],
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
        $query = EngineerAttendance::find();

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
            'emp_id' => $this->emp_id,
            'project_id' => $this->project_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'attendance', $this->attendance]);

        return $dataProvider;
    }
}
