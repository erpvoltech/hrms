<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VeplStationariesStock;

/**
 * VeplStationariesStockSearch represents the model behind the search form of `backend\models\VeplStationariesStock`.
 */
class VeplStationariesStockSearch extends VeplStationariesStock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',  'balance_qty'], 'integer'],
            [['item_id'],'safe'],
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
        $query = VeplStationariesStock::find();
        $query->joinWith('stationaries');
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
            'balance_qty' => $this->balance_qty,
        ]);
        $query->andFilterWhere(['like','vepl_stationaries.item_name',$this->item_id]);
        return $dataProvider;
    }
}
