<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PfList;

/**
 * PfListSearch represents the model behind the search form of `common\models\PfList`.
 */
class PfListSearch extends PfList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'list_id', 'list_no', 'empid'], 'integer'],
            [['gross', 'epf_wages', 'eps_wages', 'edli_wages', 'epf_contri_remitted', 'eps_contri_remitted', 'epf_eps_diff_remitted', 'ncp_days', 'refund_of_advance'], 'number'],
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
        $query = PfList::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			 'pagination' => [
					'pageSize' => 50,
				],
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
            'list_id' => $this->list_id,
            'list_no' => $this->list_no,
            'empid' => $this->empid,
            'gross' => $this->gross,
            'epf_wages' => $this->epf_wages,
            'eps_wages' => $this->eps_wages,
            'edli_wages' => $this->edli_wages,
            'epf_contri_remitted' => $this->epf_contri_remitted,
            'eps_contri_remitted' => $this->eps_contri_remitted,
            'epf_eps_diff_remitted' => $this->epf_eps_diff_remitted,
            'ncp_days' => $this->ncp_days,
            'refund_of_advance' => $this->refund_of_advance,
        ]);

        return $dataProvider;
    }
}