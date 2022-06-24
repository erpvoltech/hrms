<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VgWcPolicy;

/**
 * VgWcPolicySearch represents the model behind the search form of `app\models\VgWcPolicy`.
 */
class VgWcPolicySearch extends VgWcPolicy {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'insurance_comp_id', 'insurance_agents_id'], 'integer'],
            [['policy_name', 'policy_no', 'from_date', 'to_date', 'premium_paid', 'remarks', 'employer_name_address', 'contractor_name_address', 'nature_of_work', 'policy_holder_address', 'project_address', 'wc_coverage_days', 'wc_type'], 'safe'],
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
        $query = VgWcPolicy::find();

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
        ]);

        $query->andFilterWhere(['like', 'policy_name', $this->policy_name])
                ->andFilterWhere(['like', 'policy_no', $this->policy_no])
                ->andFilterWhere(['like', 'premium_paid', $this->premium_paid])
                ->andFilterWhere(['like', 'employer_name_address', $this->employer_name_address])
                ->andFilterWhere(['like', 'contractor_name_address', $this->contractor_name_address])
                ->andFilterWhere(['like', 'nature_of_work', $this->nature_of_work])
                ->andFilterWhere(['like', 'policy_holder_address', $this->policy_holder_address])
                ->andFilterWhere(['like', 'project_address', $this->project_address])
                ->andFilterWhere(['like', 'wc_coverage_days', $this->wc_coverage_days])
                ->andFilterWhere(['like', 'wc_type', $this->wc_type]);
        return $dataProvider;
    }

}
