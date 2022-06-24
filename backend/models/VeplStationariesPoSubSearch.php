<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VeplStationariesPoSub;

/**
 * VeplStationariesPoSubSearch represents the model behind the search form of `backend\models\VeplStationariesPoSub`.
 */
class VeplStationariesPoSubSearch extends VeplStationariesPoSub
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'po_id', 'po_item_id', 'po_qty'], 'integer'],
            [['po_rate', 'po_amount'], 'number'],
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
        $query = VeplStationariesPoSub::find();

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
            'po_id' => $this->po_id,
            'po_item_id' => $this->po_item_id,
            'po_qty' => $this->po_qty,
            'po_rate' => $this->po_rate,
            'po_amount' => $this->po_amount,
        ]);

        return $dataProvider;
    }
}
