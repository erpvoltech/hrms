<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpDetails;

class NonuanSearch extends EmpDetails {

   public $empcode;
   public $empname;
   public $unit_id;
   public $status;
  

   public function rules() {
      return [
          [['empcode', 'empname', 'unit_id','status'], 'safe'],
      ];
   }

   public function scenarios() {
      return Model::scenarios();
   }

   public function search($params) {
    //  $query = EmpDetails::find();

      $query = EmpDetails::find()->where(['emp_statutorydetails.epfuanno'=>'']);
      $query->joinWith(['employeeStatutoryDetail','units'])
      ->orWhere(['IS', 'emp_statutorydetails.epfuanno', NULL])
      ->andWhere(['<>','emp_details.status', 'Relieved']);
      //$query->joinWith(['department', 'units']);
      $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
        'pageSize' => 30,
    ],
      ]);
	  
      if (!($this->load($params))) {
         return $dataProvider;
      }
      $query->orFilterWhere([
          'empcode' => $this->empcode,
          'empname' => $this->empname,
        //  'department_id' => $this->department,
          'unit_id' => $this->unit_id,
           'status' => $this->status,
         // 'designation_id' => $this->designation,		  
      ]);
		//$query->orFilterWhere(['like', 'empcode', $this->empcode]);
      return $dataProvider;
   }

}
