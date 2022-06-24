<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EsiList;

/**
 * EsiListSearch represents the model behind the search form of `common\models\EsiList`.
 */
class EsiListSearch extends EsiList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'esi_list_id', 'esi_list_no', 'empid'], 'integer'],
            [['esino'], 'safe'],
            [['gross', 'esi_employee_contribution', 'esi_employer_contribution'], 'number'],
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
        $query = EsiList::find();

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
            'esi_list_id' => $this->esi_list_id,
            'esi_list_no' => $this->esi_list_no,
            'empid' => $this->empid,
            'gross' => $this->gross,
            'esi_employee_contribution' => $this->esi_employee_contribution,
            'esi_employer_contribution' => $this->esi_employer_contribution,
        ]);

        $query->andFilterWhere(['like', 'esino', $this->esino]);

        return $dataProvider;
    }
}
