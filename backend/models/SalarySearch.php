<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpSalary;
use common\models\EmpDetails;
use common\models\SalaryMonth;
error_reporting(0);
/**
 * SalarySearch represents the model behind the search form of `common\models\EmpSalary`.
 */
class SalarySearch extends EmpSalary
{
    public $department;
    public $unit;
    public $designation;
	public $division;
	public $empname;
	public $empcode;
	public $category;
	public $monthto;
	
    public function rules()
    {
        return [          
            [['date','empname', 'empid', 'attendancetype','monthto', 'month','division_id','department_id','unit_id','designation','empcode','category'], 'safe'],
            ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

  public function attributeLabels()
    {
        return [
		'empname' => 'Employee Name',
		'empcode' => 'Employee Code',
		'monthto' => 'Month To',
		'month' => 'Month From',
		'division_id' => 'Division',
		'unit_id' => 'Unit',
		'department_id' => 'Department',		
		];
	}
	
    public function search($params)
    {
        $query = EmpSalary::find();

        $query->joinWith(['employee']);
	   
		$query->orderBy('month DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,	
			'pagination' => [ 'pageSize' => 50 ],
        ]);

        $this->load($params);

        if (!$this->validate()) {         
            return $dataProvider;
        }
		if($this->month !='') {
		$salarymonth1 =Yii::$app->formatter->asDate('01-'. $this->month, "yyyy-MM-dd");
		$salarymonth2 =Yii::$app->formatter->asDate('01-'. $this->monthto, "yyyy-MM-dd");
		$query->andFilterWhere(['between','month', $salarymonth1,$salarymonth2]);
		} else {		
		$Salmonth = SalaryMonth::find()->orderBy(['month'=>SORT_DESC])->one();
		$salary_year =  date('Y',strtotime($Salmonth->month));
		$month =  date('m',strtotime($Salmonth->month));
		if($month <= 3) {
			$salary_year = $salary_year -1;
		} 
		$salarymonth1 = Yii::$app->formatter->asDate($salary_year.'-04-01', "yyyy-MM-dd");
		$query->andFilterWhere(['between','month', $salarymonth1,$Salmonth->month]);
		
		}
		
        $query->andFilterWhere([           
            'emp_salary.department_id'=> $this->department_id,
            'emp_salary.unit_id'=> $this->unit_id, 
			'emp_salary.division_id'=> $this->division_id, 
            'designation'=> $this->designation,   
			'category' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'empname', $this->empname]);
		$query->andFilterWhere(['like', 'empcode', $this->empcode]);

        return $dataProvider;
    }
}
