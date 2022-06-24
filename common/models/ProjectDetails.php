<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_details".
 *
 * @property int $id
 * @property string $project_code
 * @property string $location_code
 * @property int $principal_employer
 * @property int $employer_contact
 * @property int $customer_id
 * @property int $customer_contact
 * @property string $job_details
 * @property string $state
 * @property string $compliance_required
 * @property string $consultant
 * @property int $consultant_id
 * @property int $consultant_contact
 * @property string $project_status
 * @property int $unit_id
 * @property int $division_id
 * @property string $remark
 */
class ProjectDetails extends \yii\db\ActiveRecord
{
    public $file;
    
    public static function tableName()
    {
        return 'project_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_code' /*, 'location_code', 'job_details', 'project_status','state','district','compliance_required','unit_id', 'division_id'*/], 'required'],
            [['principal_employer', 'employer_contact', 'customer_id', 'customer_contact', 'consultant_id', 'consultant_contact', 'unit_id', 'division_id'], 'integer'],
            [['project_name','job_details',  'consultant', 'project_status', 'remark','location','zone','pono','po_date','po_deliverydate','pehr_name','pehr_contact','pehr_email',
            'petech_name','petech_contact','petech_email','conhr_name','conhr_contact','conhr_email','contech_name','contech_contact','contech_email','consulthr_name','consulthr_contact','consulthr_email','consultech_name','consultech_contact','consultech_email'], 'string'],
            [['project_code', 'location_code'], 'string', 'max' => 50],
            [['project_code', 'location_code'], 'unique'],
            [['state','district'], 'string', 'max' => 250],
            [['compliance_required'], 'safe'],
            [['file'], 'file', 'skipOnEmpty' => True, 'extensions' => 'xlsx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_code' => 'Project Code',
            'project_name' => 'Project Name',
            'pono'         => 'Po No',
            'po_date'      => 'PO Date',
            'po_deliverydate'=>'Po Delivery Date',
            'location_code' => 'Location Code',
            'location' => 'Location',
            'principal_employer' => 'Principal Employer',
            'employer_contact' => 'Employer Contact',
            'customer_id' => 'Customer',
            'customer_contact' => 'Customer Contact',
            'job_details' => 'Job Details',
            'state' => 'State',
            'district' => 'District',
            'compliance_required' => 'Compliance Required',
            'consultant' => 'Consultant',
            'consultant_id' => 'Consultant',
            'consultant_contact' => 'Consultant Contact',
            'project_status' => 'Project Status',
           /* 'unit_id' => 'Unit',
            'division_id' => 'Division',*/
            'remark' => 'Remark',
            'pehr_name'=>'PE HR Name',
            'pehr_contact'=>'PE HR Contact',
            'pehr_email'=>'PE HR Email',
            'petech_name'=>'PE Tech Name',
            'petech_contact'=>'PE Tech Contact',
            'petech_email'=>'PE Tech Email',
            'conhr_name'=>'Customer HR Name',
            'conhr_contact'=>'Customer HR Contact',
            'conhr_email'=>'Customer HR Email',
            'contech_name'=>'Customer Tech Name',
            'contech_contact'=>'Customer Tech Contact',
            'contech_email'=>'Customer Tech Email',
            'consulthr_name'=>'Consultant HR Name',
            'consulthr_contact'=>'Consultant HR Contact',
            'consulthr_email'=>'Consultant HR Email',
            'consultech_name'=>'Consultant Tech Name',
            'consultech_contact'=>'Consultant Tech Contact',
            'consultech_email'=>'Consultant Tech Email',
        ];
    }
    
        public function getUnits()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
        public function getDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'division_id']);
    }   
        public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id'=>'customer_id']);
    }
        public function getEmployer()
    {
        return $this->hasOne(Customer::className(), ['id'=>'principal_employer']);
    }
        public function getConsultants()
    {
        return $this->hasOne(Customer::className(), ['id'=>'consultant_id']);
    }
    public function getStates()
    {
        return $this->hasOne(State::className(), ['id'=>'state']);
    }
    
    public function getDistricts()
    {
        return $this->hasOne(District::className(), ['id'=>'district']);
    }
}
