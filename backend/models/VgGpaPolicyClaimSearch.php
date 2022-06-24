<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VgGpaPolicyClaim;

/**
 * VgGpaPolicyClaimSearch represents the model behind the search form of `app\models\VgGpaPolicyClaim`.
 */
class VgGpaPolicyClaimSearch extends VgGpaPolicyClaim
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id'], 'integer'],
            [['policy_serial_no', 'contact_person', 'contact_no', 'nature_of_accident', 'injury_detail', 'accident_place_address', 'accident_time', 'accident_notes', 'claim_status'], 'safe'],
            [['total_bill_amount'], 'number'],
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
        $query = VgGpaPolicyClaim::find();

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
            'employee_id' => $this->employee_id,
            'total_bill_amount' => $this->total_bill_amount,
        ]);

        $query->andFilterWhere(['like', 'policy_serial_no', $this->policy_serial_no])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'nature_of_accident', $this->nature_of_accident])
            ->andFilterWhere(['like', 'injury_detail', $this->injury_detail])
            ->andFilterWhere(['like', 'accident_place_address', $this->accident_place_address])
            ->andFilterWhere(['like', 'accident_time', $this->accident_time])
            ->andFilterWhere(['like', 'accident_notes', $this->accident_notes])
            ->andFilterWhere(['like', 'claim_status', $this->claim_status]);

        return $dataProvider;
    }
}
