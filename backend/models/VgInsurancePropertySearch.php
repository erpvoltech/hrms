<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VgInsuranceProperty;

/**
 * VgInsurancePropertySearch represents the model behind the search form of `app\models\VgInsuranceProperty`.
 */
class VgInsurancePropertySearch extends VgInsuranceProperty
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['property_type', 'property_name', 'property_no', 'location', 'user', 'user_division', 'equipment_service', 'remarks'], 'safe'],
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
        $query = VgInsuranceProperty::find();

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

        $query->andFilterWhere(['like', 'property_type', $this->property_type])
            ->andFilterWhere(['like', 'property_name', $this->property_name])
            ->andFilterWhere(['like', 'property_no', $this->property_no])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'user_division', $this->user_division])
            ->andFilterWhere(['like', 'equipment_service', $this->equipment_service])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
