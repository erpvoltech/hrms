<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_gpa_policy_claim".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $policy_serial_no
 * @property string $contact_person
 * @property string $contact_no
 * @property string $nature_of_accident
 * @property string $injury_detail
 * @property string $accident_place_address
 * @property string $accident_time
 * @property string $accident_notes
 * @property double $total_bill_amount
 * @property string $claim_status
 */
class VgGpaPolicyClaim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_gpa_policy_claim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'policy_serial_no', 'contact_person', 'contact_no', 'nature_of_accident', 'injury_detail', 'accident_place_address', 'accident_time', 'total_bill_amount', 'claim_status'], 'required'],
            [['employee_id'], 'integer'],
            [['total_bill_amount'], 'number'],
            [['claim_status'], 'string'],
            [['policy_serial_no', 'contact_person', 'contact_no'], 'string', 'max' => 50],
            [['nature_of_accident', 'injury_detail', 'accident_place_address', 'accident_notes'], 'string', 'max' => 256],
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
            'employee_id' => 'Employee ID',
            'policy_serial_no' => 'Policy Serial No',
            'contact_person' => 'Contact Person',
            'contact_no' => 'Contact No',
            'nature_of_accident' => 'Nature Of Accident',
            'injury_detail' => 'Injury Detail',
            'accident_place_address' => 'Accident Place Address',
            'accident_time' => 'Accident Time',
            'accident_notes' => 'Accident Notes',
            'total_bill_amount' => 'Total Bill Amount',
            'claim_status' => 'Claim Status',
        ];
    }
    
    public function getEmployeeData()
    {
        return $this->hasOne(EmpDetails::className(), ['id' => 'employee_id']);
    }
}
