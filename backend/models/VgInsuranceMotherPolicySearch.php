<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VgInsuranceMotherPolicy;

/**
 * VgInsuranceMotherPolicySearch represents the model behind the search form of `app\models\VgInsuranceMotherPolicy`.
 */
class VgInsuranceMotherPolicySearch extends VgInsuranceMotherPolicy
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'policy_for_id', 'insurance_comp_id', 'insurance_agents_id'], 'integer'],
            [['policy_no', 'from_date', 'to_date', 'remarks'], 'safe'],
            [['premium_paid'], 'number'],
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
        $query = VgInsuranceMotherPolicy::find();

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
            'policy_for_id' => $this->policy_for_id,
            'insurance_comp_id' => $this->insurance_comp_id,
            'insurance_agents_id' => $this->insurance_agents_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'premium_paid' => $this->premium_paid,
        ]);

        $query->andFilterWhere(['like', 'policy_no', $this->policy_no])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
