<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_agents".
 *
 * @property int $id
 * @property int $company_id
 * @property string $agent_name
 * @property string $official_contact_no
 * @property string $personal_contact_no
 * @property string $email_address
 */
class VgInsuranceAgents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_agents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'agent_name', 'official_contact_no', 'email_address'], 'required'],
            [['company_id'], 'integer'],
            [['agent_name'], 'string', 'max' => 100],
            [['official_contact_no', 'personal_contact_no'], 'string', 'max' => 25],
            [['email_address'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'ISP Name',
            'agent_name' => 'Agent Name',
            'official_contact_no' => 'Official Contact No',
            'personal_contact_no' => 'Personal Contact No',
            'email_address' => 'Email Address',
        ];
    }
    
    public function getCompanyName()
    {
        return $this->hasOne(VgInsuranceCompany::className(), ['id' => 'company_id']);
    }
}
