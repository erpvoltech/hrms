<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "emp_salarystructure".
 *
 * @property int $id
 * @property string $salarystructure
 * @property string $worklevel
 * @property string $grade
 * @property double $basic
 * @property double $hra
 * @property double $splallowance
 * @property double $gross
 * @property double $daperday
 * @property double $dapermonth
 * @property double $payableallowance
 * @property double $netsalary
 */
class EmpSalarystructure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_salarystructure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salarystructure', 'worklevel', 'grade', 'basic', 'hra', 'other_allowance', 'gross', 'daperday', 'dapermonth', 'payableallowance', 'netsalary'], 'required'],
            [['salarystructure', 'worklevel', 'grade'], 'string'],
            [['basic', 'hra', 'other_allowance', 'gross', 'daperday', 'dapermonth', 'payableallowance', 'netsalary'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salarystructure' => 'Salarystructure',
            'worklevel' => 'Worklevel',
            'grade' => 'Grade',
            'basic' => 'Basic',
            'hra' => 'Hra',
            'other_allowance' => 'Other Allowance',
            'gross' => 'Gross',
            'daperday' => 'Daperday',
            'dapermonth' => 'Dapermonth',
            'payableallowance' => 'Payableallowance',
            'netsalary' => 'Netsalary',
        ];
    }
}
