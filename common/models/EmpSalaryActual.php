<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_salary_actual".
 *
 * @property int $id
 * @property int $empid
 * @property string $month
 * @property double $basic
 * @property double $hra
 * @property double $spl_allowance
 * @property double $dearness_allowance
 * @property double $conveyance_allowance
 * @property double $lta_earning
 * @property double $medical_earning
 * @property double $guaranted_benefit
 * @property double $holiday_pay
 * @property double $washing_allowance
 * @property double $dust_allowance
 * @property double $performance_pay
 * @property double $misc
 * @property double $other_allowance
 */
class EmpSalaryActual extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_salary_actual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid', 'month', 'basic'], 'required'],
            [['empid'], 'integer'],
            [['month'], 'safe'],
            [['basic', 'hra', 'spl_allowance', 'dearness_allowance', 'conveyance_allowance', 'lta_earning', 'medical_earning', 'guaranted_benefit', 'holiday_pay', 'washing_allowance', 'dust_allowance', 'performance_pay', 'misc', 'other_allowance','gross'], 'number'],
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
            'month' => 'Month',
            'basic' => 'Basic',
            'hra' => 'Hra',
            'spl_allowance' => 'Spl Allowance',
            'dearness_allowance' => 'Dearness Allowance',
            'conveyance_allowance' => 'Conveyance Allowance',
            'lta_earning' => 'Lta Earning',
            'medical_earning' => 'Medical Earning',
            'guaranted_benefit' => 'Guaranted Benefit',
            'holiday_pay' => 'Holiday Pay',
            'washing_allowance' => 'Washing Allowance',
            'dust_allowance' => 'Dust Allowance',
            'performance_pay' => 'Performance Pay',
            'misc' => 'Misc',
            'other_allowance' => 'Other Allowance',
			'gross' => 'Gross',
        ];
    }
}
