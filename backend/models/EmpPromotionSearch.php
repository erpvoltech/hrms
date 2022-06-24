<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpPromotion;

/**
 * EmpPromotionSearch represents the model behind the search form of `common\models\EmpPromotion`.
 */
class EmpPromotionSearch extends EmpPromotion
{
    public $searchuser;
    public function rules()
    {
        return [
            [['id', 'user', 'empid', 'flag'], 'integer'],
            [['searchuser','createdate', 'effectdate', 'ss_from', 'ss_to', 'wl_from', 'wl_to', 'grade_from', 'grade_to'], 'safe'],
            [['basic', 'other_allowance', 'gross_from', 'gross_to'], 'number'],
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
        $query = EmpPromotion::find()->orderBy([         
            'id' => SORT_DESC,
        ]);
          $query->joinWith(['employee']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [ 'pageSize' => 50 ],
        ]);

        $this->load($params);        
        if (!$this->validate()) {           
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([          
            'empcode' => $this->searchuser,           
        ]);

        return $dataProvider;
    }
}
