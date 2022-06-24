<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "porec_training".
 *
 * @property int $id
 * @property string $training_type
 * @property string $name
 * @property string $division
 * @property int $unit_id
 * @property int $department_id
 * @property string $ecode
 * @property string $training_startdate
 * @property string $training_enddate
 * @property int $trainig_topic_id
 * @property int $batch_id
 * @property string $created_date
 * @property string $created_by
 */
class PorecTrainingAttendance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	
    public static function tableName()
    {
        return 'training_attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_batch_id', 'attendance_date'], 'required'],            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'training_type' => 'Training Type',
            #'name' => 'Name',
            'division' => 'Division',
            'unit_id' => 'Unit ID',
            'department_id' => 'Department ID',
            'ecode' => 'Ecode',
            'training_startdate' => 'Training Startdate',
            'training_enddate' => 'Training Enddate',
            'trainig_topic_id' => 'Training Topic',
            'batch_id' => 'Batch',
            'training_batch_id' => 'Training Batch',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
	
	public function getRecruitment()	
    {
        return $this->hasMany(Recruitment::className(), ['training_id' => 'id']);
    }
	
	public function getRecruitmentBatch()
    {
        return $this->hasOne(RecruitmentBatch::className(), ['id' => 'batch_id']);
    }
	
	public function getTrainingTopics()
    {
        return $this->hasOne(TrainingTopics::className(), ['id' => 'trainig_topic_id']);
    }
}
