<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_vehicle".
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
 * @property string $user
 * @property string $user_division
 * @property string $insured_to
 * @property string $remarks
 */
class VgInsuranceVehicle extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'vg_insurance_vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['icn_id', 'insurance_agent_id', 'property_type', 'vehicle_type', 'insurance_no', 'property_name', 'property_no', 'sum_insured', 'premium_paid', 'valid_from', 'valid_to', 'financial_year', 'insurance_status'], 'required'],
            [['icn_id', 'insurance_agent_id'], 'integer'],
            [['property_type', 'vehicle_type', 'insurance_status'], 'string'],
            [['property_value', 'sum_insured', 'premium_paid'], 'number'],
            [['valid_from', 'valid_to','pollution_valid_from','pollution_valid_to'], 'safe'],
            [['financial_year'], 'string', 'max' => 250],
            [['insurance_no', 'user_division'], 'string', 'max' => 100],
            [['property_name'], 'string', 'max' => 250],
            [['property_no', 'location', 'user', 'insured_to'], 'string', 'max' => 150],
            [['remarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icn_id' => 'ISP Name',
            'insurance_agent_id' => 'Insurance Agent Name',
            'property_type' => 'Property Type',
            'vehicle_type' => 'Vehicle Type',
            'insurance_no' => 'Policy No',
            'property_name' => 'Vehicle Name',
            'property_no' => 'Registration No',
            'property_value' => 'Property Value',
            'sum_insured' => 'Sum Insured',
            'premium_paid' => 'Premium Paid',
            'valid_from' => 'Valid From',
            'valid_to' => 'Valid To',
            'financial_year' => 'Year',
            'location' => 'Location',
            'user' => 'User',
            'user_division' => 'User Division',
            'insured_to' => 'Insured To',
			'pollution_valid_from'=>'Pollution Valid From',
			'pollution_valid_to'=>'Pollution Valid To',
            'remarks' => 'Remarks',
            'insurance_status' => 'Status',
        ];
    }

    public function getCompany() {
        return $this->hasOne(VgInsuranceCompany::className(), ['id' => 'icn_id']);
    }

    public function getAgent() {
        return $this->hasOne(VgInsuranceAgents::className(), ['id' => 'insurance_agent_id']);
    }

}
