<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recruitment;

/**
 * PorecTrainingSearch represents the model behind the search form of `app\models\PorecTraining`.
 */
class RecruitmentprocessSearch extends Recruitment
{
    /**
     * {@inheritdoc}
     */
	 
	public $Search;
    public function rules()
    {
        return [
			#[['process_status'],'required'],
            [['Search', 'name', 'type', 'specialization', 'qualification', 'position', 'batch_id','register_no','process_status'], 'safe'],
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
			'callletter_status' => 1,
			'batch_id' => $this->batch_id, 			
        ]);
		$query->andWhere(['process_status'=>null]);
		#$query->andFilterWhere(['like','status','selected']);
		#$query->orWhere(['like','status','Interview']);	

        return $dataProvider;
    }
}