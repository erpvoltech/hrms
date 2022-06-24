<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmployeeLog;

/**
 * EmployeeLogSearch represents the model behind the search form of `common\models\EmployeeLog`.
 */
class EmployeeLogSearch extends EmployeeLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user'], 'integer'],
            [['effectdate', 'designation_from', 'designation_to', 'attendance_from', 'attendance_to', 'esi_from', 'esi_to', 'pf_from', 'pf_to', 'pf_ restrict_from', 'pf_ restrict_to'], 'safe'],
            [['pli_from', 'pli_to'], 'number'],
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
        $query = EmployeeLog::find();

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
            'user' => $this->user,
            'effectdate' => $this->effectdate,
            'pli_from' => $this->pli_from,
            'pli_to' => $this->pli_to,
        ]);

        $query->andFilterWhere(['like', 'designation_from', $this->designation_from])
            ->andFilterWhere(['like', 'designation_to', $this->designation_to])
            ->andFilterWhere(['like', 'attendance_from', $this->attendance_from])
            ->andFilterWhere(['like', 'attendance_to', $this->attendance_to])
            ->andFilterWhere(['like', 'esi_from', $this->esi_from])
            ->andFilterWhere(['like', 'esi_to', $this->esi_to])
            ->andFilterWhere(['like', 'pf_from', $this->pf_from])
            ->andFilterWhere(['like', 'pf_to', $this->pf_to])
            ->andFilterWhere(['like', 'pf_ restrict_from', $this->pf_ restrict_from])
            ->andFilterWhere(['like', 'pf_ restrict_to', $this->pf_ restrict_to]);

        return $dataProvider;
    }
}
