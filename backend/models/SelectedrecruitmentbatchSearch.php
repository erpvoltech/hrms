<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recruitment;

/**
 * PorecTrainingSearch represents the model behind the search form of `app\models\PorecTraining`.
 */
class SelectedrecruitmentbatchSearch extends Recruitment
{
    /**
     * {@inheritdoc}
     */
	 
	public $Search;
    public function rules()
    {
        return [
            [['Search', 'name', 'type', 'specialization', 'qualification', 'position', 'batch_id','register_no'], 'safe'],
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
        $query = Recruitment::find();
		#echo "<pre>";print_r($params);echo "</pre>";
        // add conditions that should always apply here
		$batch_id		=	$params['recModel']['batch_id'];
		$status			=	$params['recModel']['status'];
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);	
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        		
		
		$query->andFilterWhere([				
            'batch_id' => $batch_id,            
            'process_status' => $status,            
        ]);

        return $dataProvider;
    }
}