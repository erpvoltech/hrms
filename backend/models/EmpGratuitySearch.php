<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpDetails;
use common\models\UnitGroup;
/**
 * EmpDetailsSearch represents the model behind the search form of `common\models\EmpDetails`.
 */
class EmpGratuitySearch extends EmpDetails
{
    public $year;
	public $noYear;
    public function rules()
    {
        return [
            [['id', 'designation_id', 'unit_id', 'division_id' , 'department_id'], 'integer'],
            [['year','employment_type', 'empcode', 'empname', 'doj','resignation_date', 'confirmation_date', 'division_id', 'email', 'mobileno', 'referedby', 'probation', 'appraisalmonth', 'recentdop', 'joining_status', 'experience', 'dateofleaving', 'reasonforleaving', 'photo', 'status'], 'safe'],
			
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
	  $this->load($params);
	 if($this->year){
			$cuYear = date("Y")- $this->year;
		} else {
			$cuYear = date("Y")- 3;
		}	 
	   
		$cuDay = date("m-d");
		$noYear = Yii::$app->formatter->asDate( $cuYear.'-'.$cuDay, "yyyy-MM-dd");	
	
      $query = EmpDetails::find()->where(['<=','doj',$noYear])->orderBy(['doj' => SORT_ASC]);
	  $query->joinWith(['department', 'units']);
	   $query->andWhere(['<>','status','Relieved']);
        // add conditions that should always apply here
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			 'pagination' => [ 'pageSize' => 50 ],
        ]);

       
		
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		//if($this->year){
		//$year1 = Yii::$app->formatter->asDate($this->year.'-01-01', "yyyy-MM-dd");
		//$year2 = Yii::$app->formatter->asDate($this->year.'-12-31', "yyyy-MM-dd");
		//$query->andFilterWhere(['between', 'last_working_date', $year1,$year2]);		
			 
		//}

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,          
            'confirmation_date' => $this->confirmation_date,
            'designation_id' => $this->designation_id,
            'unit_id' => $this->unit_id,
            'division_id' => $this->division_id,
            'department_id' => $this->department_id,
            'recentdop' => $this->recentdop,
            'dateofleaving' => $this->dateofleaving,			
        ]);

        $query->andFilterWhere(['like', 'employment_type', $this->employment_type])
            ->andFilterWhere(['like', 'empcode', $this->empcode])
            ->andFilterWhere(['like', 'empname', $this->empname])           
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobileno', $this->mobileno])
            ->andFilterWhere(['like', 'referedby', $this->referedby])
            ->andFilterWhere(['like', 'probation', $this->probation])
            ->andFilterWhere(['like', 'appraisalmonth', $this->appraisalmonth])
            ->andFilterWhere(['like', 'joining_status', $this->joining_status])
            ->andFilterWhere(['like', 'experience', $this->experience])
            ->andFilterWhere(['like', 'reasonforleaving', $this->reasonforleaving]);            
           

        return $dataProvider;
    }   
     
}
