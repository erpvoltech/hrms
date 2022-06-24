<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpDetails;

class EmpSearch extends EmpDetails {

   public $e_code;
   public $name;
   public $designation;
   public $department;
   public $unit;
   public $category;

   public function rules() {
      return [
          [['e_code', 'name', 'designation', 'department', 'unit','category'], 'safe'],
      ];
   }

   public function scenarios() {
      return Model::scenarios();
   }

   public function search($params) {
      $query = EmpDetails::find();
      $query->joinWith(['department', 'units']);
      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);
	  
      if (!($this->load($params))) {
         return $dataProvider;
      }
      $query->orFilterWhere([
          'empcode' => $this->e_code,
          'empname' => $this->name,
          'department_id' => $this->department,
          'unit_id' => $this->unit,
          'designation_id' => $this->designation,		  
      ]);
		$query->orFilterWhere(['like', 'category', $this->category]);
      return $dataProvider;
   }

}
