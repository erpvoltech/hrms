<?php
namespace common\models;
use Yii;

class ProjectSalary extends \yii\db\ActiveRecord
{   
    public static function tableName()
    {
        return 'project_salary';
    }
   
    public function rules()
    {
        return [
            [['project_id', 'month', 'emp_id', 'wages', 'days', 'overtime_hours', 'basic_da', 'spacial_basic', 'overtime_payment', 'hra', 'canteen_allowance', 'transport_allowance', 'washing_allowance', 'other_allowance', 'total', 'pf', 'esi', 'society', 'income_tax', 'insurance', 'others', 'recoveries', 'deduction_total', 'netpayment', 'employer_pf'], 'required'],
            [['project_id', 'emp_id'], 'integer'],
            [['month'], 'safe'],
            [['wages', 'days', 'overtime_hours', 'basic_da', 'spacial_basic', 'overtime_payment', 'hra', 'canteen_allowance', 'transport_allowance', 'washing_allowance', 'other_allowance', 'total', 'pf', 'esi', 'society', 'income_tax', 'insurance', 'others', 'recoveries', 'deduction_total', 'netpayment', 'employer_pf'], 'number'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'month' => 'Month',
            'emp_id' => 'Emp ID',
            'wages' => 'Wages',
            'days' => 'Days',
            'overtime_hours' => 'Overtime Hours',
            'basic_da' => 'Basic Da',
            'spacial_basic' => 'Spacial Basic',
            'overtime_payment' => 'Overtime Payment',
            'hra' => 'Hra',
            'canteen_allowance' => 'Canteen Allowance',
            'transport_allowance' => 'Transport Allowance',
            'washing_allowance' => 'Washing Allowance',
            'other_allowance' => 'Other Allowance',
            'total' => 'Total',
            'pf' => 'Pf',
            'esi' => 'Esi',
            'society' => 'Society',
            'income_tax' => 'Income Tax',
            'insurance' => 'Insurance',
            'others' => 'Others',
            'recoveries' => 'Recoveries',
            'deduction_total' => 'Deduction Total',
            'netpayment' => 'Netpayment',
            'employer_pf' => 'Employer Pf',
        ];
    }
	
	public function getProject()
    {
        return $this->hasOne(ProjectDetails::className(), ['id' => 'project_id']);
    }
	public function getEmployee()
    {
        return $this->hasOne(ProjectEmp::className(), ['id' => 'emp_id']);
    }
}
