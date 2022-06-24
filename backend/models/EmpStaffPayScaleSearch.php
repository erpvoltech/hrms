<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmpStaffPayScale;

/**
 * EmpStaffPayScaleSearch represents the model behind the search form of `app\models\EmpStaffPayScale`.
 */
class EmpStaffPayScaleSearch extends EmpStaffPayScale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['salarystructure', 'other_allowance'], 'safe'],
            [['basic', 'dearness_allowance', 'hra',  'conveyance_allowance', 'lta', 'medical', 'pli'], 'number'],
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
        $query = EmpStaffPayScale::find();

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
            'basic' => $this->basic,
            'dearness_allowance' => $this->dearness_allowance,
            'hra' => $this->hra,
            //'spl_allowance' => $this->spl_allowance,
            'conveyance_allowance' => $this->conveyance_allowance,
            'lta' => $this->lta,
            'medical' => $this->medical,
            'pli' => $this->pli,
        ]);

        $query->andFilterWhere(['like', 'salarystructure', $this->salarystructure])
            ->andFilterWhere(['like', 'other_allowance', $this->other_allowance]);

        return $dataProvider;
    }
}
