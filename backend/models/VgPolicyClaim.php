<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_policy_claim".
 *
 * @property int $id
 * @property string $employee_code
 * @property string $employee_name
 * @property string $insurance_type
 * @property string $policy_no
 * @property string $policy_serial_no
 * @property string $contact_person
 * @property string $contact_no
 * @property string $nature_of_accident
 * @property string $loss_type
 * @property string $injury_detail
 * @property string $accident_place_address
 * @property string $accident_time
 * @property string $accident_notes
 * @property string $settlement_notes
 * @property double $settlement_amount
 * @property double $claim_estimate
 * @property string $claim_status
 */
class VgPolicyClaim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_policy_claim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['insurance_type', 'policy_no', 'contact_person', 'contact_no', 'nature_of_accident', 'loss_type', 'injury_detail', 'accident_place_address', 'accident_time', 'settlement_amount', 'claim_estimate', 'claim_status'], 'required'],
            [['employee_code', 'employee_name'], 'safe'],
            [['insurance_type', 'loss_type', 'claim_status'], 'string'],
            [['settlement_amount', 'claim_estimate'], 'number'],
            [['employee_code', 'policy_serial_no', 'contact_person', 'contact_no'], 'string', 'max' => 50],
            [['employee_name'], 'string', 'max' => 125],
            [['policy_no'], 'string', 'max' => 150],
            [['nature_of_accident', 'injury_detail', 'accident_place_address', 'accident_notes', 'settlement_notes'], 'string', 'max' => 256],
            [['accident_time'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_code' => 'Employee Code',
            'employee_name' => 'Employee Name',
            'insurance_type' => 'Insurance Type',
            'policy_no' => 'Policy No',
            'policy_serial_no' => 'Policy Serial No',
            'contact_person' => 'Contact Person',
            'contact_no' => 'Contact No',
            'nature_of_accident' => 'Nature of Loss/Damage/Accident',
            'loss_type' => 'Loss Type',
            'injury_detail' => 'Details of Damage/Theft/Injury',
            'accident_place_address' => 'Place of Accident/Loss',
            'accident_time' => 'Date and Time of Loss/Accident',
            'accident_notes' => 'Des.of Accident/Loss',
            'settlement_notes' => 'Des.of Settlement',
            'settlement_amount' => 'Settlement Amount',
            'claim_estimate' => 'Claim Estimate',
            'claim_status' => 'Claim Status',
        ];
    }
}
