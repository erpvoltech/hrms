<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_gpa_endorsement".
 *
 * @property int $id
 * @property int $gpa_mother_policy_id
 * @property string $endorsement_no
 * @property string $start_date
 * @property string $end_date
 * @property double $endorsement_premium_paid
 */
class VgGpaEndorsement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_gpa_endorsement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gpa_mother_policy_id', 'endorsement_no', 'start_date', 'end_date', 'endorsement_premium_paid'], 'required'],
            [['gpa_mother_policy_id'], 'safe'],
            [['start_date', 'end_date'], 'safe'],
            [['endorsement_premium_paid'], 'number'],
            [['endorsement_no'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gpa_mother_policy_id' => 'GPA Mother Policy No',
            'endorsement_no' => 'Endorsement No',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'endorsement_premium_paid' => 'Endorsement Premium Paid',
        ];
    }
    
    public function getGpaPolicy()
    {
        return $this->hasOne(VgGpaPolicy::className(), ['id' => 'gpa_mother_policy_id']);
    }
}
