<?php
	
	namespace common\models;
	
	use Yii;
	use yii\base\Model;
	use yii\data\ActiveDataProvider;
	use common\models\EmpDetails;
	
	/**
		* EmpDetailsSearch represents the model behind the search form of `common\models\EmpDetails`.
	*/
	class EmpDetailsSearch extends EmpDetails
	{
		/**
			* {@inheritdoc}
		*/
		
		public $seektext;
		public $caste;
		public $community;
		public $blood_group;
		public $email;
		public $mobileno;
		public $dob;
		public $birthday;
		
		public function rules()
		{
			return [
            [['id', 'designation_id', 'unit_id', 'department_id'], 'integer'],
            [['employment_type','category', 'empcode', 'empname', 'doj', 'confirmation_date', 'division_id', 'email', 'mobileno', 'referedby', 'probation', 'appraisalmonth', 'recentdop', 'joining_status', 'experience', 'dateofleaving', 'reasonforleaving', 'photo', 'status','training_status', 'seektext', 'caste', 'community', 'blood_group', 'dob', 'birthday'], 'safe'],
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
			//$query = EmpDetails::find()->leftJoin(['employeePersonalDetail', 'employeeAddress', 'family']);
			//$query = EmpDetails::find()->joinWith(['employeePersonalDetail', 'employeeAddress', 'family']);
			// add conditions that should always apply here
			$query = EmpDetails::find();
			$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [ 'pageSize' => 50 ],
			]);
			
			$this->load($params);
			
			if (!$this->validate()) {
				// uncomment the following line if you do not want to return any records when validation fails
				// $query->where('0=1');
				return $dataProvider;
			}
			
			if ($this->seektext != '') {
				
				$query->orFilterWhere(['like', 'employment_type', $this->seektext])
				->orFilterWhere(['like', 'empcode', $this->seektext])
				->orFilterWhere(['like', 'empname', $this->seektext])
				->orFilterWhere(['like', 'emp_personaldetails.email', $this->seektext])
				->orFilterWhere(['like', 'emp_details.mobileno', $this->seektext])
				->orFilterWhere(['like', 'referedby', $this->seektext])
				->orFilterWhere(['like', 'probation', $this->seektext])
				->orFilterWhere(['like', 'appraisalmonth', $this->seektext])
				->orFilterWhere(['like', 'joining_status', $this->seektext])
				->orFilterWhere(['like', 'experience', $this->seektext])
				->orFilterWhere(['like', 'reasonforleaving', $this->seektext])
				->orFilterWhere(['like', 'status', $this->seektext])
				->orFilterWhere(['=', 'emp_personaldetails.caste', $this->seektext])
				->orFilterWhere(['=', 'emp_personaldetails.community', $this->seektext])
				->orFilterWhere(['=', 'emp_personaldetails.blood_group', $this->seektext])
				->orFilterWhere(['like', 'emp_personaldetails.dob', Yii::$app->formatter->asDate($this->seektext, "yyyy-MM-dd")])
				->orFilterWhere(['like', 'emp_personaldetails.birthday', Yii::$app->formatter->asDate($this->seektext, "yyyy-MM-dd")])
				->orFilterWhere(['=', 'emp_familydetails.name', $this->seektext])
				->orFilterWhere(['like', 'emp_address.addfield5', $this->seektext])
				->orFilterWhere(['like', 'emp_address.district', $this->seektext])
				->orFilterWhere(['like', 'emp_address.state', $this->seektext]);
				
				return $dataProvider;
				} else {
				
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
				'category' => $this->category,
				]);
				
				$query->andFilterWhere(['like', 'employment_type', $this->employment_type])
				//	->andFilterWhere(['like', 'category', $this->category])
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
				->andFilterWhere(['like', 'status', $this->status]);
				
				return $dataProvider;
			}
		}
	}
