<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpDetails;
use yii\db\conditions\InCondition;

/**
 * PorecTrainingSearch represents the model behind the search form of `app\models\PorecTraining`.
 */
class EmpEcodeSearch extends EmpDetails
{
    /**
     * {@inheritdoc}
     */
	public $ecode_id;
    public function rules()
    {
        return [
            [['ecode_id'], 'safe'],
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
		
		$ecode_id		=	$params['empModel']['ecode_id'];		
        $query = EmpDetails::find();			        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);		
        $this->load($params);
	   
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
	
		$ecode_id_arr	=	explode(',',$ecode_id);		
		$query->andFilterWhere(['IN', 'id', $ecode_id_arr]);
       
		#echo $dataProvider;
		#echo "<pre>";print_r($query);echo "</pre>";
		#print_r($dataProvider);
        return $dataProvider;
    }
}