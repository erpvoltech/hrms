<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recruitment;
use yii\db\conditions\InCondition;

/**
 * PorecTrainingSearch represents the model behind the search form of `app\models\PorecTraining`.
 */
class RecruitmentTrainingSearch extends Recruitment
{
    /**
     * {@inheritdoc}
     */
	public $rec_id;
    public function rules()
    {
        return [
            [['rec_id','status', 'name', 'type', 'specialization', 'qualification', 'position', 'batch_id','register_no'], 'safe'],
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
		
		$rec_id		=	$params['recModel']['rec_id'];		
        $query = Recruitment::find();			        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);		
        $this->load($params);
	   
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
	
		$rec_id_arr	=	explode(',',$rec_id);		
		$query->andFilterWhere(['IN', 'id', $rec_id_arr]);
       
		#echo $dataProvider;
		#echo "<pre>";print_r($query);echo "</pre>";
		#print_r($dataProvider);
        return $dataProvider;
    }
}