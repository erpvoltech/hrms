<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_gmc_endorsement".
 *
 * @property int $id
 * @property int $gmc_mother_policy_id
 * @property string $endorsement_no
 * @property string $start_date
 * @property string $end_date
 * @property double $endorsement_premium_paid
 */
class VgGmcEndorsement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_gmc_endorsement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gmc_mother_policy_id', 'endorsement_no', 'start_date', 'end_date', 'endorsement_premium_paid'], 'required'],
            [['gmc_mother_policy_id'], 'safe'],
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
            'gmc_mother_policy_id' => 'GMC Mother Policy No',
            'endorsement_no' => 'Endorsement No',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'endorsement_premium_paid' => 'Endorsement Premium Paid',
        ];
    }
    
    public function getGmcPolicy()
    {
        return $this->hasOne(VgGmcPolicy::className(), ['id' => 'gmc_mother_policy_id']);
    }
}
