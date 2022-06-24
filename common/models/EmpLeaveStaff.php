<?php

namespace common\models;

use Yii;
use common\models\EmpLeaveCounter;
/**
 * This is the model class for table "emp_leave_staff".
 *
 * @property int $id
 * @property int $empid
 * @property double $eligible_first_quarter
 * @property double $eligible_second_quarter
 * @property double $eligible_third_quarter
 * @property double $eligible_fourth_quarter
 * @property double $leave_taken_first_quarter
 * @property double $leave_taken_second_quarter
 * @property double $leave_taken_third_quarter
 * @property double $leave_taken_fourth_quarter
 * @property double $remaining_leave_first_quarter
 * @property double $remaining_leave_second_quarter
 * @property double $remaining_leave_third_quarter
 * @property double $remaining_leave_fourth_quarter
 */
class EmpLeaveStaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_leave_staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid'], 'integer'],
            [['eligible_first_quarter', 'eligible_second_quarter', 'eligible_third_quarter', 'eligible_fourth_quarter', 'leave_taken_first_quarter', 'leave_taken_second_quarter', 'leave_taken_third_quarter', 'leave_taken_fourth_quarter', 'remaining_leave_first_quarter', 'remaining_leave_second_quarter', 'remaining_leave_third_quarter', 'remaining_leave_fourth_quarter'], 'number'],
            [['empid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empid' => 'Empid',
            'eligible_first_quarter' => 'Eligible I Quarter',
            'eligible_second_quarter' => 'Eligible II Quarter',
            'eligible_third_quarter' => 'Eligible III Quarter',
            'eligible_fourth_quarter' => 'Eligible IV Quarter',
            'leave_taken_first_quarter' => 'Leave Taken I Quarter',
            'leave_taken_second_quarter' => 'Leave Taken II Quarter',
            'leave_taken_third_quarter' => 'Leave Taken III Quarter',
            'leave_taken_fourth_quarter' => 'Leave Taken IV Quarter',
            'remaining_leave_first_quarter' => 'Balance Leave I Quarter',
            'remaining_leave_second_quarter' => 'Balance Leave II Quarter',
            'remaining_leave_third_quarter' => 'Balance Leave II Quarter',
            'remaining_leave_fourth_quarter' => 'Balance Leave IV Quarter',
        ];
    }
     public function getEmployee() {
		 return $this->hasOne(EmpDetails::className(), ['id'=>'empid']);
	}
	public function getDesignations()
	{
		return $this->hasOne(Designation::className(),['id'=>'designation_id'])->via('employee');
	}
	public function getUnits()
	{
		return $this->hasOne(Unit::className(),['id'=>'unit_id'])->via('employee');
	}
	public function getDepartment()
	{
		return $this->hasOne(Department::className(),['id'=>'department_id'])->via('employee');
	}
	public function getLeavecounter()
	{
		return $this->hasOne(EmpLeaveCounter::className(),['empid'=>'id'])->via('employee');
	}
	public function getAprilLeave($model){	
	
	}
	
}
