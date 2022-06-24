<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_wc_policy".
 *
 * @property int $id
 * @property string $policy_name
 * @property int $insurance_comp_id
 * @property int $insurance_agents_id
 * @property string $policy_no
 * @property string $from_date
 * @property string $to_date
 * @property double $premium_paid
 * @property string $remarks
 * @property string $employer_name_address
 * @property string $contractor_name_address
 * @property string $nature_of_work
 * @property string $policy_holder_address
 * @property string $project_address
 * @property string $wc_coverage_days
 * @property string $wc_type
 */
class VgWcPolicy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_wc_policy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['policy_name', 'insurance_comp_id', 'insurance_agents_id', 'policy_no', 'from_date', 'to_date', 'premium_paid', 'employer_name_address', 'nature_of_work', 'policy_holder_address', 'wc_coverage_days', 'wc_type'], 'required'],
            [['policy_name', 'employer_name_address', 'contractor_name_address', 'nature_of_work', 'policy_holder_address', 'project_address', 'wc_type'], 'string'],
            [['insurance_comp_id', 'insurance_agents_id'], 'integer'],
            [['from_date', 'to_date'], 'safe'],
            [['premium_paid'], 'number'],
            [['policy_no'], 'string', 'max' => 200],
            [['remarks'], 'string', 'max' => 256],
            [['wc_coverage_days'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'policy_name' => 'Policy Name',
            'insurance_comp_id' => 'Insurance Comp ID',
            'insurance_agents_id' => 'Insurance Agents ID',
            'policy_no' => 'Policy No',
            'from_date' => 'Valid From',
            'to_date' => 'Valid To',
            'premium_paid' => 'Premium Paid',
            'remarks' => 'Remarks',
            'employer_name_address' => 'Client Name',
            'contractor_name_address' => 'Contractor Name Address',
            'nature_of_work' => 'Nature Of Work',
            'policy_holder_address' => 'Policy Holder Address',
            'project_address' => 'Site Name/Location',
            'wc_coverage_days' => 'Wc Coverage Days',
            'wc_type' => 'Wc Type',
        ];
    }
    
    public function getCompany()
    {
        return $this->hasOne(VgInsuranceCompany::className(), ['id' => 'insurance_comp_id']);
    }
    
    public function getAgent()
    {
        return $this->hasOne(VgInsuranceAgents::className(), ['id' => 'insurance_agents_id']);
    }
}
