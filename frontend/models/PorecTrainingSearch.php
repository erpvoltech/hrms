<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PorecTraining;

/**
 * PorecTrainingSearch represents the model behind the search form of `app\models\PorecTraining`.
 */
class PorecTrainingSearch extends PorecTraining
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'unit_id', 'department_id', 'trainig_topic_id', 'batch_id'], 'integer'],
            [['training_type', 'division', 'ecode', 'training_startdate', 'training_enddate', 'created_date', 'created_by'], 'safe'],			
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
		#echo "</pre>";print_r($params);echo "</pre>";
        $query = PorecTraining::find();

        // add conditions that should always apply here
		
		if($params != ''){
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);		

        $this->load($params);
		}

        if (!$this->validate() && $params != '') {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([            
            'trainig_topic_id' => $this->trainig_topic_id,
            'training_batch_id' => $this->training_batch_id,
        ]);

        
		if($params != ''){
			return $dataProvider;
		}else{
			return false;
		}
		
    }
}
