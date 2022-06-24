<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VgPolicyClaim;

/**
 * VgPolicyClaimSearch represents the model behind the search form of `app\models\VgPolicyClaim`.
 */
class VgPolicyClaimSearch extends VgPolicyClaim
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['employee_code', 'employee_name', 'insurance_type', 'policy_no', 'policy_serial_no', 'contact_person', 'contact_no', 'nature_of_accident', 'loss_type', 'injury_detail', 'accident_place_address', 'accident_time', 'accident_notes', 'settlement_notes', 'claim_status'], 'safe'],
            [['settlement_amount', 'claim_estimate'], 'number'],
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
        $query = VgPolicyClaim::find();

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
           // 'id' => $this->id,
            'settlement_amount' => $this->settlement_amount,
            'claim_estimate' => $this->claim_estimate,
        ]);

        $query->andFilterWhere(['like', 'employee_code', $this->employee_code])
            ->andFilterWhere(['like', 'employee_name', $this->employee_name])
            ->andFilterWhere(['like', 'insurance_type', $this->insurance_type])
            ->andFilterWhere(['like', 'policy_no', $this->policy_no])
            ->andFilterWhere(['like', 'policy_serial_no', $this->policy_serial_no])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'nature_of_accident', $this->nature_of_accident])
            ->andFilterWhere(['like', 'loss_type', $this->loss_type])
            ->andFilterWhere(['like', 'injury_detail', $this->injury_detail])
            ->andFilterWhere(['like', 'accident_place_address', $this->accident_place_address])
            ->andFilterWhere(['like', 'accident_time', $this->accident_time])
            ->andFilterWhere(['like', 'accident_notes', $this->accident_notes])
            ->andFilterWhere(['like', 'settlement_notes', $this->settlement_notes])
            ->andFilterWhere(['like', 'claim_status', $this->claim_status]);

        return $dataProvider;
    }
}
