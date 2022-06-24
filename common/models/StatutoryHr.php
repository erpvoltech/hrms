<?php
	
	namespace common\models;
	
	use Yii;
	
	/**
		* This is the model class for table "statutory_hr".
		*
		* @property int $id
		* @property int $emp_id
		* @property string $month
		* @property int $list_no
		* @property string $trrn_no
	*/
	class StatutoryHr extends \yii\db\ActiveRecord
	{
		public $file;
		public $unit;
		public $dept;
		public $division;
		public $category;	
		public $pfesi;
		
		public static function tableName()
		{
			return 'statutory_hr';
		}
		
		/**
			* {@inheritdoc}
		*/
		public function rules()
		{
			return [
            [['month', 'list_no', 'trrn_no', 'pfesi'], 'required'],
            [['list_no'], 'integer'],          
			[['month'], 'date', 'format' => 'php:m-Y'],
            [['trrn_no'], 'string', 'max' => 15],
			[['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
			[['pfesi'], 'safe'],
			];
		}
		
		/**
			* {@inheritdoc}
		*/
		public function attributeLabels()
		{
			return [
            'id' => 'ID',          
            'month' => 'Month',
            'list_no' => 'List No',
            'trrn_no' => 'Trrn No',
			];
		}
	}
