<?php
	
	namespace app\models;
	
	use Yii;
	use yii\base\Model;
	use yii\data\ActiveDataProvider;
	use common\models\EmpDetails;
	
	/**
		* EmpDetailsSearch represents the model behind the search form of `common\models\EmpDetails`.
	*/
	class EngineerSearch extends EmpDetails
	{
		/**
			* {@inheritdoc}
		*/
		
		
		
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
			$query = EmpDetails::find()->where(['IN','category',['International Engineer','Domestic Engineer']]);
			
			// add conditions that should always apply here
			
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
			
			
				
				// grid filtering conditions
				$query->andFilterWhere([
				'id' => $this->id,				
				'designation_id' => $this->designation_id,
				'unit_id' => $this->unit_id,
				'division_id' => $this->division_id,             
				'department_id' => $this->department_id,				
				]);
				
				$query->andFilterWhere(['like', 'empcode', $this->empcode])
				->andFilterWhere(['like', 'empname', $this->empname]);
				
				return $dataProvider;
			}
		
	}
