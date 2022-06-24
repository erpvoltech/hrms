<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProjectDetails;

/**
 * ProjectDetailsSearch represents the model behind the search form of `common\models\ProjectDetails`.
 */
class ProjectDetailsSearch extends ProjectDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'principal_employer', 'customer_id', 'consultant_id', 'unit_id', 'division_id'], 'integer'],
            [['project_code', 'location_code', 'job_details', 'state', 'compliance_required', 'consultant', 'project_status', 'remark'], 'safe'],
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
        $query = ProjectDetails::find();

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
            'principal_employer' => $this->principal_employer,
            'customer_id' => $this->customer_id,
            'consultant_id' => $this->consultant_id,
            'unit_id' => $this->unit_id,
            'division_id' => $this->division_id,
        ]);

        $query->andFilterWhere(['like', 'project_code', $this->project_code])
            ->andFilterWhere(['like', 'location_code', $this->location_code])
            ->andFilterWhere(['like', 'job_details', $this->job_details])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'compliance_required', $this->compliance_required])
            ->andFilterWhere(['like', 'consultant', $this->consultant])
            ->andFilterWhere(['like', 'project_status', $this->project_status])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
