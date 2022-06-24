<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_leave".
 *
 * @property int $id
 * @property int $empid
 * @property double $eligible_first_half
 * @property double $eligible_second_half
 * @property double $leave_taken_first_half
 * @property double $leave_taken_second_half
 * @property double $remaining_leave_first_half
 * @property double $remaining_leave_second_half
 */
class EngineerLeave extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'engineer_leave';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid'], 'integer'],
             [['empcode'], 'string'],
            [['eligible_first_half', 'eligible_second_half'], 'number'],
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
            'empcode' => 'EmpCode',
            'eligible_first_half' => 'Eligible First Half',
            'eligible_second_half' => 'Eligible Second Half',
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
}
