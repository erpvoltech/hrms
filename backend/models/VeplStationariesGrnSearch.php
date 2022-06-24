<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VeplStationariesGrn;

/**
 * VeplStationariesGrnSearch represents the model behind the search form of `backend\models\VeplStationariesGrn`.
 */
class VeplStationariesGrnSearch extends VeplStationariesGrn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id'], 'integer'],
            [['grn_date', 'bill_no', ], 'safe'],           
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
        $query = VeplStationariesGrn::find();

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
            'grn_date' => $this->grn_date,           
            'supplier_id' => $this->supplier_id,         
        ]);

        $query->andFilterWhere(['like', 'bill_no', $this->bill_no]);
        

        return $dataProvider;
    }
}
