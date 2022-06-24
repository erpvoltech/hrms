<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_remuneration_details".
 *
 * @property int $id
 * @property int $empid
 * @property string $salary_structure
 * @property int $staff_pay_scale_id
 * @property string $work_level
 * @property string $grade
 * @property string $attendance_type
 * @property string $esi_applicability
 * @property string $pf_applicablity
 * @property string $restrict_pf
 * @property double $basic
 * @property double $hra
 * @property double $splallowance
 * @property double $dearness_allowance
 * @property double $conveyance
 * @property double $lta
 * @property double $medical
 * @property double $pli
 * @property double $personpay
 * @property double $dust_allowance
 * @property double $guaranteed_benefit
 * @property double $other_allowance
 * @property double $gross_salary
 * @property double $employer_pf_contribution
 * @property double $employer_est_contribution
 * @property double $ctc
 */
class EmpRemunerationDetails extends \yii\db\ActiveRecord
{
    public $ctcgross;
	  
    public static function tableName()
    {
        return 'emp_remuneration_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid'], 'integer'],
            [['grade', 'attendance_type', 'esi_applicability', 'pf_applicablity', 'restrict_pf','food_allowance'], 'string'],
            [['basic', 'hra', 'splallowance', 'dearness_allowance', 'conveyance', 'lta', 'medical', 'pli', 'personpay', 'dust_allowance','washing_allowance', 'misc','guaranteed_benefit', 'other_allowance', 'gross_salary', 'employer_pf_contribution', 'employer_esi_contribution','employer_pli_contribution','employer_lta_contribution','employer_medical_contribution','ctc','ctcgross'], 'number'],
            [['salary_structure'], 'string', 'max' => 255],
            [['work_level'], 'string', 'max' => 20],
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
            'salary_structure' => 'Salary Structure',          
            'work_level' => 'Work Level',
            'grade' => 'Grade',
            'attendance_type' => 'Attendance Type',
            'esi_applicability' => 'ESI Applicability',
            'pf_applicablity' => 'PF Applicability',
            'restrict_pf' => 'Restrict PF',
            'basic' => 'Basic',
            'hra' => 'HRA',
            'splallowance' => 'Splallowance',
            'dearness_allowance' => 'Dearness Allowance',
            'conveyance' => 'Conveyance',
            'lta' => 'LTA',
            'medical' => 'Medical',
            'pli' => 'PLI',
            'personpay' => 'Personpay',
            'dust_allowance' => 'Dust Allowance',
			'washing_allowance' => 'Washing Allowance',
            'guaranteed_benefit' => 'Guaranteed Benefit',				
			'misc' => 'Miscellaneous**',
            'other_allowance' => 'Other Allowance',
            'gross_salary' => 'Gross Salary',
			'food_allowance' => 'Food Allowance',
            'employer_pf_contribution' => 'PF',
            'employer_esi_contribution' => 'ESI',
            'employer_pli_contribution' => 'PLI',
            'employer_lta_contribution' => 'LTA',
            'employer_medical_contribution' => 'Medical',
            'ctc' => 'CTC',
			'ctcgross' =>'Gross Salary (Inclusive of PLI)*',
        ];
    }
}
