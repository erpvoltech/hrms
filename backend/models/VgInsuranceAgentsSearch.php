<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VgInsuranceAgents;

/**
 * VgInsuranceAgentsSearch represents the model behind the search form of `app\models\VgInsuranceAgents`.
 */
class VgInsuranceAgentsSearch extends VgInsuranceAgents
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['agent_name', 'official_contact_no', 'personal_contact_no', 'email_address'], 'safe'],
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
        $query = VgInsuranceAgents::find();

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
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'agent_name', $this->agent_name])
            ->andFilterWhere(['like', 'official_contact_no', $this->official_contact_no])
            ->andFilterWhere(['like', 'personal_contact_no', $this->personal_contact_no])
            ->andFilterWhere(['like', 'email_address', $this->email_address]);

        return $dataProvider;
    }
}
