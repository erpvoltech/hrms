<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecruitmentBatch;

/**
 * RecruitmentBatchSearch represents the model behind the search form of `app\models\RecruitmentBatch`.
 */
class RecruitmentBatchSearch extends RecruitmentBatch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['date', 'batch_name'], 'safe'],
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
        $query = RecruitmentBatch::find();
		$query->orderBy('id DESC');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,	
			'pagination' => array('pageSize' => 100),
			#'sort' => ['attributes' => ['id' => ['default' => SORT_DESC],]]
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
            'date' => $this->date,
        ]);

       $query->andFilterWhere(['like', 'batch_name', $this->batch_name]);

        return $dataProvider;
    }
}
