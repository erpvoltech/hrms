<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrainingBatch;
use app\models\PorecTraining;

/**
 * RecruitmentBatchSearch represents the model behind the search form of `app\models\RecruitmentBatch`.
 */
class TrainingBatchSearch extends PorecTraining
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_batch_id'], 'integer'],
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
        $query = PorecTraining::find();
		#echo $query;
		#echo "<pre>";print_r($params);echo "</pre>";
		#echo "training_batch: *******".$params['recModel']['training_batch_id'];
		#exit;
        // add conditions that should always apply here
		$training_batch_id	=	$params['recModel']['training_batch_id'];
		
		/*if( isset($params['recModel']['status']) && !empty($params['recModel']['status']) ){
			$status				=	$params['recModel']['status'];
			$qrystatus			=	"'status' => $status";
		}else{
			$qrystatus			=	'';
		}*/
		
		#echo "training_batch: *******".$training_batch_id;
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
        $query->orFilterWhere([
            'training_batch_id' => $training_batch_id,
        ]);

        #$query->andFilterWhere(['like', 'batch_name', $this->batch_name]);
		#echo "<pre>";print_r($dataProvider);echo "</pre>";
		#exit;
        return $dataProvider;
    }
}