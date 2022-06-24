<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_building".
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
 * @property string $insured_to
 * @property string $remarks
 */
class VgInsuranceBuilding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_building';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icn_id', 'insurance_agent_id', 'property_type', 'insurance_no', 'property_name', 'property_no', 'sum_insured', 'premium_paid', 'valid_from', 'valid_to', 'financial_year'], 'required'],
            [['icn_id', 'insurance_agent_id'], 'integer'],
            [['property_type'], 'string'],
            [['property_value', 'sum_insured', 'premium_paid'], 'number'],
            [['valid_from', 'valid_to'], 'safe'],
			[['financial_year'], 'string', 'max' => 50],
            [['insurance_no'], 'string', 'max' => 100],
            [['property_name'], 'string', 'max' => 250],
            [['property_no', 'location', 'insured_to'], 'string', 'max' => 150],
            [['remarks'], 'string', 'max' => 200],
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
            'insurance_agent_id' => 'Insurance Agent',
            'property_type' => 'Property Type',
            'insurance_no' => 'Policy No',
            'property_name' => 'Property Name',
            'property_no' => 'Property No',
            'property_value' => 'Property Value',
            'sum_insured' => 'Sum Insured',
            'premium_paid' => 'Premium Paid',
            'valid_from' => 'Valid From',
            'valid_to' => 'Valid To',
			'financial_year' => 'Year',
            'location' => 'Location',
            'insured_to' => 'Insured To',
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
