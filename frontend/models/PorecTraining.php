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
class PorecTraining extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public $rec_id;
	public $porec_id;
	public $faculty_name;
	public $print_type;
	public $print_date;
	public $attendance_date;
	public $training_topic_id;
    public static function tableName()
    {
        return 'porec_training';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_type', 'division', 'unit_id', 'department_id', 'ecode', 'training_startdate', 'training_enddate', 'trainig_topic_id', 'batch_id', 'created_date', 'created_by','attendance_date'], 'required'],
            [['training_type'], 'string'],
            [['unit_id', 'department_id', 'trainig_topic_id', 'batch_id'], 'integer'],
            [['training_startdate', 'training_enddate', 'created_date'], 'safe'],
            #[['name'], 'string', 'max' => 255],
            [['division', 'created_by'], 'string', 'max' => 50],
            [['ecode'], 'string', 'max' => 20],
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