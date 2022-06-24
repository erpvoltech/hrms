<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VgGmcEndorsement;

/**
 * VgGmcEndorsementSearch represents the model behind the search form of `app\models\VgGmcEndorsement`.
 */
class VgGmcEndorsementSearch extends VgGmcEndorsement
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gmc_mother_policy_id'], 'integer'],
            [['endorsement_no', 'start_date', 'end_date'], 'safe'],
            [['endorsement_premium_paid'], 'number'],
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
        $query = VgGmcEndorsement::find();

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
            'gmc_mother_policy_id' => $this->gmc_mother_policy_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'endorsement_premium_paid' => $this->endorsement_premium_paid,
        ]);

        $query->andFilterWhere(['like', 'endorsement_no', $this->endorsement_no]);

        return $dataProvider;
    }
}
