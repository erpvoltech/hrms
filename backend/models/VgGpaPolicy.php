<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_gpa_policy".
 *
 * @property int $id
 * @property string $policy_name
 * @property int $insurance_comp_id
 * @property int $insurance_agents_id
 * @property string $policy_no
 * @property string $from_date
 * @property string $to_date
 * @property double $premium_paid
 * @property string $location
 * @property string $remarks
 * @property string $gpa_type
 */
class VgGpaPolicy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_gpa_policy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['policy_name', 'insurance_comp_id', 'insurance_agents_id', 'policy_no', 'from_date', 'to_date', 'premium_paid', 'gpa_type'], 'required'],
            [['policy_name', 'gpa_type'], 'string'],
            [['insurance_comp_id', 'insurance_agents_id'], 'integer'],
            [['from_date', 'to_date'], 'safe'],
            [['premium_paid'], 'number'],
            [['policy_no'], 'string', 'max' => 200],
            [['remarks'], 'string', 'max' => 256],
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
            'insurance_comp_id' => 'ISP Name',
            'insurance_agents_id' => 'Insurance Agents Name',
            'policy_no' => 'Policy No',
            'from_date' => 'Valid From',
            'to_date' => 'Valid To ',
            'premium_paid' => 'Premium Paid',
            'remarks' => 'Remarks',
            'gpa_type' => 'GPA Type',
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
