<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recruitment;

/**
 * PorecTrainingSearch represents the model behind the search form of `app\models\PorecTraining`.
 */
class CallletterSearch extends Recruitment
{
    /**
     * {@inheritdoc}
     */
	 
	public $Search;
	public $callletter;
	public $mail_option;
	
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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 50),
        ]);

        $this->load($params);	
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		$query->orFilterWhere(['like', 'type', $this->Search])
            ->orFilterWhere(['like', 'register_no', $this->Search])
			->orFilterWhere(['like', 'name', $this->Search])
            ->orFilterWhere(['like', 'position', $this->Search])
            ->orFilterWhere(['like', 'contact_no', $this->Search])
            ->orFilterWhere(['like', 'status', $this->Search])
            ->orFilterWhere(['like', 'selection_mode', $this->Search]);
		
		
        // grid filtering conditions
        $query->andFilterWhere([				
            #'status' => 'selected',
            #'status' => 'interview',
			'callletter_status' => '0',
			'batch_id' => $this->batch_id, 
        ]);
		
		$query->andFilterWhere(['IN', 'status', ['selected','Interview']]);
		#$query->andWhere(['status','in',['selected','Interview']]);
		/*$query->andWhere(['or',
           ['status'=>'selected'],
           ['status'=>'Interview'],
		]);*/

        return $dataProvider;
    }
}