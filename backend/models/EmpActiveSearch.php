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
class EmpActiveSearch extends EmpDetails
{
    public $unit_group;
    public function rules()
    {
        return [
            [['id', 'designation_id', 'unit_id', 'division_id' , 'department_id'], 'integer'],
            [['unit_group','employment_type', 'empcode', 'empname', 'doj','resignation_date', 'confirmation_date', 'division_id', 'email', 'mobileno', 'referedby', 'probation', 'appraisalmonth', 'recentdop', 'joining_status', 'experience', 'dateofleaving', 'reasonforleaving', 'photo', 'status'], 'safe'],
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
	$unit_array=[];
      $query = EmpDetails::find()->orderBy(['unit_id' => SORT_ASC]);
	  $query->joinWith(['department', 'units']);
	
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                        'pageSize' => 50, 
                    ],
        ]);

        $this->load($params);
		
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		if($this->unit_group){
		$unit_group = UnitGroup::find()->Where(['vgunit_id'=>$this->unit_group])->all();
		foreach($unit_group as $units){
		$unit_array[] = $units->unit_id;
		}
		  $query->andFilterWhere(['IN', 'unit_id', $unit_array]);
		
		}

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'doj' => $this->doj,
            'confirmation_date' => $this->confirmation_date,
            'designation_id' => $this->designation_id,
            'unit_id' => $this->unit_id,
            'division_id' => $this->division_id,
            'department_id' => $this->department_id,
            'recentdop' => $this->recentdop,
            'dateofleaving' => $this->dateofleaving,
			'resignation_date' => $this->resignation_date,
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
            ->andFilterWhere(['like', 'reasonforleaving', $this->reasonforleaving])
            ->andFilterWhere(['like', 'photo', $this->photo])
          //  ->andFilterWhere(['like', 'status', $this->status]);
			->andFilterWhere(['in', 'emp_details.status', ['Active','Notice Period']]);
        return $dataProvider;
    }   
     
}
