<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpSalary;
use common\models\EmpDetails;
use common\models\SalaryMonth;
use common\models\Finance;

error_reporting(0);
/**
 * SalarySearch represents the model behind the search form of `common\models\EmpSalary`.
 */
class FinanceSearch extends Finance
{
    public $department;
    public $unit;
    public $designation;
	public $division;
	public $empname;
	public $empcode;
	public $category;
	public $monthto;
	public $netamount;
	public $netamountto;
	
    public function rules()
    {
        return [          
            [['date','empname', 'empid', 'attendancetype','monthto', 'month','division_id','department_id','unit_id','designation','empcode','category','net_amount','netamountto','app_date'], 'safe'],
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
		'net_amount' => 'Net Amount',
		'netamountto' => 'Net Amount To',
		'app_date'=>'Approval Date',
		];
	}
	
    public function search($params)
	
    {
		$sal_month = SalaryMonth::find()->select(['id'=>'MAX(`id`)'])->one()->id;
		
		$get_month = SalaryMonth::find()->where(['id'=>$sal_month])->one();
        
		$query = Finance::find();

        $query->joinWith(['employee']);
		
		$query->where(['month'=>$get_month->month]);
		
		//$query->andWhere(['<>','approval',1]);
		
		$query->andWhere(['finance_approval1' => 1,'finance_approval2'=>NULL]);
		
	   
		$query->orderBy('month DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,	
			'pagination' => [ 'pageSize' => 945 ],
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
		
		if($this->net_amount !='') {
			$amount1 =$this->net_amount;
			$amount2 =$this->netamountto;
			$query->andFilterWhere(['between','net_amount',$amount1,$amount2]);
		}
		
        $query->andFilterWhere([           
            'finance.department_id'=> $this->department_id,
            'finance.unit_id'=> $this->unit_id, 
			'finance.division_id'=> $this->division_id, 
            'designation'=> $this->designation,   
			'category' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'empname', $this->empname]);
		$query->andFilterWhere(['like', 'empcode', $this->empcode]);

        return $dataProvider;
    }
}
