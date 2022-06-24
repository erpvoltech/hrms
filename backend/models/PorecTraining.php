<?php

namespace app\models;

use Yii;
use common\models\Department;
use common\models\Unit;
use app\models\RecruitmentBatch;

/**
 * This is the model class for table "porec_training".
 *
 * @property int $id
 * @property string $training_type
 * @property int $division
 * @property int $unit
 * @property int $department
 * @property string $training_startdate
 * @property string $training_enddate
 * @property int $trainig_topic
 * @property int $batch
 * @property string $created_date
 * @property string $created_by
 */
class PorecTraining extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	 
	public $offerletter;
	public $offerletter_type;
	public $rec_id;
    public static function tableName()
    {
        return 'porec_training';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
		$scen1	=	['ecode', 'division', 'unit_id', 'department_id'];
        return [
            [['training_type', 'training_startdate', 'training_enddate', 'trainig_topic_id', 'batch_id','training_batch_id', 'offerletter_type'], 'required'],
            //[['training_type', 'division', 'unit_id', 'department_id', 'ecode', 'training_startdate', 'training_enddate', 'trainig_topic_id', 'batch_id'], 'required'],
            [['ecode', 'division', 'unit_id', 'department_id'], 'required', 'when' => function ($model) {
				return $model->training_type == 'existing';
			}],
			[['training_type','division'], 'string'],
			[['recruitment_id'], 'string'],
			['ecode', 'exist', 'targetAttribute' => 'ecode', 'targetClass' => 'app\models\PorecTraining'],
            //[['unit_id', 'department_id', 'trainig_topic_id', 'batch_id'], 'integer'],
            [['training_startdate', 'training_enddate', 'created_date'], 'safe'],
            [['created_by'], 'string', 'max' => 50],
            #[['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'recruitment_id' => 'Name',
            'training_type' => 'Training Type',
			'training_batch_id' => 'Training Batch',
            'division' => 'Division',
            'unit_id' => 'Unit',
            'department_id' => 'Department',
            'ecode' => 'Ecode',
            'offer_date' => 'Offer Date',
            #'name' => 'Name',
            'training_startdate' => 'Training Startdate',
            'training_enddate' => 'Training Enddate',
            'trainig_topic_id' => 'Training Topic',
            'batch_id' => 'Batch',            
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
	
	public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
	
	public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }
	
	public function getRecruitmentBatch()
    {
        return $this->hasOne(RecruitmentBatch::className(), ['id' => 'batch_id']);
    }
	
	public function getTrainingBatch()
    {
        return $this->hasOne(TrainingBatch::className(), ['id' => 'training_batch_id']);
    }
	
	public function getTrainingTopics()
    {
        return $this->hasOne(TrainingTopics::className(), ['id' => 'trainig_topic_id']);
    }
}