<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "engineer_attendance".
 *
 * @property int $id
 * @property int $emp_id
 * @property int $project_id
 * @property string $date
 * @property string $attendance
 */
class EngineerAttendance extends \yii\db\ActiveRecord
{
    public $ecode;
    public static function tableName()
    {
        return 'engineer_attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['emp_id','date',], 'required'],
            [['emp_id', 'project_id'], 'integer'],
            [['ecode'], 'safe'],
			[['overtime','special_allowance','advance_amount'], 'number'],
            [['attendance','date','role'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emp_id' => 'Emp ID',
            'project_id' => 'Project ID',
            'date' => 'Date',
            'attendance' => 'Attendance',
			'overtime'=>'Over Time',
			'special_allowance'=>'Special Allowance',
			'advance_amount'=>'Advance Amount',
			'role'=>'Role',
        ];
    }
     public function getEmps()
    {
        return $this->hasOne(EmpDetails::className(), ['id' => 'emp_id']);
    }
        public function getPros()
    {
        return $this->hasOne(ProjectDetails::className(), ['id' => 'project_id']);
    }   
}
