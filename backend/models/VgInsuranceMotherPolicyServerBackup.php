<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_mother_policy".
 *
 * @property int $id
 * @property int $policy_for_id
 * @property int $insurance_comp_id
 * @property int $insurance_agents_id
 * @property string $policy_no
 * @property string $from_date
 * @property string $to_date
 * @property double $premium_paid
 * @property string $remarks
 */
class VgInsuranceMotherPolicy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_mother_policy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['policy_for_id', 'insurance_comp_id', 'insurance_agents_id', 'policy_no', 'from_date', 'to_date', 'premium_paid'], 'required'],
            [['policy_for_id', 'insurance_comp_id', 'insurance_agents_id'], 'integer'],
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
            'policy_for_id' => 'Policy Type',
            'insurance_comp_id' => 'Insurance Service Provider',
            'insurance_agents_id' => 'Agents Name',
            'policy_no' => 'Policy No',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'premium_paid' => 'Premium Paid',
            'remarks' => 'Remarks',
        ];
    }
    
    public function getCompanies()
    {
        return $this->hasOne(VgInsuranceMotherPolicy::className(), ['id' => 'insurance_comp_id']);
    }
}
