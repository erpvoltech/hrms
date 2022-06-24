<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Document;

/**
 * DocumentSearch represents the model behind the search form of `common\models\Document`.
 */
class ShowcauseSearch extends Document
{
    public $department;
    public $unit;
    public $lastwork;
	public $division;
	public $empname;
	public $empcode;
    public function rules()
    {
        return [
            [['id', 'empid', 'date', 'type'], 'integer'],
            [['document','empcode','empname','division','department','unit','lastwork'], 'safe'],
        ];
    }
	public function attributeLabels()
    {
        return [
           
            'empcode' => 'Employee Code',
            'empname' => 'Employee Name',
			'lastwork' => 'Last Working Date',
        ];
    }
	
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
        $query = Document::find()->where(['type'=>3]);
		$query->joinWith(['employee']);
        // add conditions that should always apply here

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
        $query->andFilterWhere([           
            'emp_details.department_id'=> $this->department,
            'emp_details.unit_id'=> $this->unit, 
			'emp_details.division_id'=> $this->division,            
        ]);
		
		if($this->lastwork !=''){
			 $query->andFilterWhere([
			 'document.last_working_date'=>Yii::$app->formatter->asDate($this->lastwork, "yyyy-MM-dd")
			 ]);
			}
		
        $query->andFilterWhere(['like', 'emp_details.empname', $this->empname]);
		$query->andFilterWhere(['like', 'emp_details.empcode', $this->empcode]);

        return $dataProvider;
       
    }
}
