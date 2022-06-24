<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VeplStationariesPo;

/**
 * VeplStationariesPoSearch represents the model behind the search form of `backend\models\VeplStationariesPo`.
 */
class VeplStationariesPoSearch extends VeplStationariesPo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'po_supplier_id'], 'integer'],
            [['po_no', 'po_date', 'last_purchase_date', 'po_prepared_by', 'po_approved_by', 'po_approval_status', 'po_total_amount', 'po_sgst', 'po_igst', 'po_cgst', 'po_net_amount'], 'safe'],
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
        $query = VeplStationariesPo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['po_no' => SORT_DESC]]
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
            'po_no' => $this->po_no,
            'po_date' => $this->po_date,
            'last_purchase_date' => $this->last_purchase_date,
            'po_supplier_id' => $this->po_supplier_id,
            'po_total_amount' => $this->po_total_amount,
            'po_sgst' => $this->po_sgst,
            'po_igst' => $this->po_igst,
            'po_cgst' => $this->po_cgst,
            'po_net_amount' => $this->po_net_amount,
        ]);

        $query->andFilterWhere(['like', 'po_prepared_by', $this->po_prepared_by])
            ->andFilterWhere(['like', 'po_approved_by', $this->po_approved_by])
            ->andFilterWhere(['like', 'po_date', $this->po_date]) 
            ->andFilterWhere(['like', 'last_purchase_date', $this->last_purchase_date])    
            ->andFilterWhere(['like', 'po_approval_status', $this->po_approval_status]);

        return $dataProvider;
    }
}
