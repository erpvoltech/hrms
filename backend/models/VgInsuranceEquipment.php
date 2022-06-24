<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_equipment".
 *
 * @property int $id
 * @property int $icn_id
 * @property int $insurance_agent_id
 * @property string $property_type
 * @property string $insurance_no
 * @property string $property_name
 * @property string $property_no
 * @property double $property_value
 * @property double $sum_insured
 * @property double $premium_paid
 * @property string $valid_from
 * @property string $valid_to
 * @property string $location
 * @property string $user_division
 * @property string $insured_to
 * @property string $equipment_service
 * @property string $remarks
 */
class VgInsuranceEquipment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	 
	public $sum_total;
	public $premium_total;
    public static function tableName()
    {
        return 'vg_insurance_equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icn_id', 'insurance_agent_id', 'property_type', 'insurance_no', 'property_name', 'property_no', 'sum_insured', 'premium_paid', 'valid_from', 'valid_to', 'financial_year', 'insured_to', 'equipment_service'], 'required'],
            [['icn_id', 'insurance_agent_id'], 'integer'],
            [['property_type', 'equipment_service'], 'string'],
            [['property_value', 'sum_insured', 'premium_paid'], 'number'],
            [['valid_from', 'valid_to', 'sum_total', 'premium_total'], 'safe'],
			[['financial_year'], 'string', 'max' => 50],
            [['insurance_no', 'user_division'], 'string', 'max' => 100],
            [['property_name'], 'string', 'max' => 250],
            [['property_no', 'location', 'insured_to'], 'string', 'max' => 150],
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
            'icn_id' => 'ISP Name',
            'insurance_agent_id' => 'Insurance Agent Name ',
            'property_type' => 'Property Type',
            'insurance_no' => 'Policy No',
            'property_name' => 'Equipment Name',
            'property_no' => 'Equipment Serial No',
            'property_value' => 'Property Value',
            'sum_insured' => 'Sum Insured',
            'premium_paid' => 'Premium Paid',
            'valid_from' => 'Valid From',
            'valid_to' => 'Valid To',
			'financial_year' => 'Year',
            'location' => 'Location',
            'user_division' => 'User Division',
            'insured_to' => 'Insured To',
            'equipment_service' => 'Equipment Service',
            'remarks' => 'Remarks',
        ];
    }
    
    public function getCompany()
    {
        return $this->hasOne(VgInsuranceCompany::className(), ['id' => 'icn_id']);
    }
    
    public function getAgent()
    {
        return $this->hasOne(VgInsuranceAgents::className(), ['id' => 'insurance_agent_id']);
    }
}
