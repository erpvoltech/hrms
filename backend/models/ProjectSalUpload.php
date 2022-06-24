<?php
namespace app\models;
use Yii;

class ProjectSalUpload extends \yii\db\ActiveRecord
{
    public $file;
    public static function tableName()
    {
        return 'project_sal_upload';
    }

   
    public function rules()
    {
        return [
            [['project_id', 'month', 'project_emp_id', 'wage'], 'required'],
            [['project_id', 'project_emp_id'], 'integer'],
            [['month','file'], 'safe'],
            [['wage', 'special_basic', 'hra', 'canteen_allowance', 'transport_allowance', 'washing_allowance', 'other_allowance', 'society', 'income_tax', 'insurance', 'others', 'recoveries'], 'number'],
        ];
    }

   
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project',
            'month' => 'Month',
            'project_emp_id' => 'Project Emp',
            'wage' => 'Wage',
            'special_basic' => 'Special Basic',
            'hra' => 'Hra',
            'canteen_allowance' => 'Canteen Allowance',
            'transport_allowance' => 'Transport Allowance',
            'washing_allowance' => 'Washing Allowance',
            'other_allowance' => 'Other Allowance',
            'society' => 'Society',
            'income_tax' => 'Income Tax',
            'insurance' => 'Insurance',
            'others' => 'Others',
            'recoveries' => 'Recoveries',
        ];
    }
}
