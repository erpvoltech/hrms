<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VgInsuranceBuilding;

/**
 * VgInsuranceBuildingSearch represents the model behind the search form of `app\models\VgInsuranceBuilding`.
 */
class VgInsuranceBuildingSearch extends VgInsuranceBuilding
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'icn_id', 'insurance_agent_id'], 'integer'],
            [['property_type', 'insurance_no', 'property_name', 'property_no', 'valid_from', 'valid_to', 'financial_year', 'location', 'insured_to', 'remarks'], 'safe'],
            [['property_value', 'sum_insured', 'premium_paid'], 'number'],
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
        $query = VgInsuranceBuilding::find();

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
            'icn_id' => $this->icn_id,
            'insurance_agent_id' => $this->insurance_agent_id,
            'property_value' => $this->property_value,
            'sum_insured' => $this->sum_insured,
            'premium_paid' => $this->premium_paid,
            'valid_from' => $this->valid_from,
            'valid_to' => $this->valid_to,
			'financial_year' => $this->financial_year,
        ]);

        $query->andFilterWhere(['like', 'property_type', $this->property_type])
            ->andFilterWhere(['like', 'insurance_no', $this->insurance_no])
            ->andFilterWhere(['like', 'property_name', $this->property_name])
            ->andFilterWhere(['like', 'property_no', $this->property_no])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'insured_to', $this->insured_to])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
