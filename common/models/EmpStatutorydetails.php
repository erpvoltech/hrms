<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_statutorydetails".
 *
 * @property int $id
 * @property int $empid
 * @property string $esino
 * @property string $esidispensary
 * @property string $epfno
 * @property string $epfuanno
 * @property string $zeropension
 * @property string $professionaltax
 * @property string $pmrpybeneficiary
 * @property string $lin_no
 */
class EmpStatutorydetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_statutorydetails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid'], 'integer'],
			[['gmc_sum_insured','gpa_sum_insured','gpa_premium','gmc_premium'], 'number'],					
            [['zeropension', 'professionaltax', 'pmrpybeneficiary','gpa_no','gmc_no','age_group','gpa_applicability','gmc_applicability', 'wc_applicability', 'wc_no'], 'string'],
            [['esino', 'esidispensary', 'epfno', 'lin_no'], 'string', 'max' => 20],
            [['epfuanno'], 'string', 'max' => 12],
            [['epfuanno'], 'unique'],
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
            'esino' => 'ESI No.',
            'esidispensary' => 'ESI Dispensary',
            'epfno' => 'EPF No.',
            'epfuanno' => 'EPF UAN No.',
            'zeropension' => 'Zeropension',
            'professionaltax' => 'Professional Tax',
            'pmrpybeneficiary' => 'PMRPY Beneficiary',
            'lin_no' => 'LIN No.',
			'gpa_no' => 'GPA No.',
			'gmc_no' => 'GMC No.',
			'gpa_sum_insured' => 'GPA SUM Insured',
			'gmc_sum_insured' => 'GMC SUM Insured',
			'age_group' => 'GMC Age Group',
			'wc_applicability' => 'WC Applicability',
            'wc_no' => 'WC No',
			'gmc_premium' => 'GMC Premium',
			'gpa_premium' => 'GPA Premium',
			
        ];
    }
}
