<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmpSalaryUpload;

class SalaryUploadSearch extends EmpSalaryUpload {

   public $department;
   public $unit;
   public $designation;
   public $division;
   public $category;
   public $empname;
    public $empcode;
   public function rules() {
      return [
          [['month','designation', 'empcode', 'department', 'unit','division','empname','category'], 'safe'],
      ];
   }

   public function scenarios() {

      return Model::scenarios();
   }

   public function search($params) {
      $query = EmpSalaryUpload::find()->where(['emp_salary_upload.status' => 'Uploaded']);
      $query->joinWith(['employee.department', 'employee.units','employee.division']);

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
		  	'pagination' => [
        'pageSize' => 200,
    ],
      ]);
	  
	$query->orderBy('month DESC');
	
      $this->load($params);

      if (!$this->validate()) {
         return $dataProvider;
      }
      if ($this->month != '') {
         $salarymonth = Yii::$app->formatter->asDate('01-' . $this->month, "yyyy-MM-dd");
         $query->andFilterWhere(['like', 'month', $salarymonth]);
      }

      $query->andFilterWhere([
          'empcode' => $this->empcode,
          'department_id' => $this->department,
          'unit_id' => $this->unit,
		  'division_id' => $this->division,
		  'category' => $this->category,		 
      ]);
	   $query->andFilterWhere(['like', 'empname', $this->empname]);
      return $dataProvider;
	  }

}
