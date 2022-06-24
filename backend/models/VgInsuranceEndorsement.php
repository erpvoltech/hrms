<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_endorsement".
 *
 * @property int $id
 * @property int $mother_policy_id
 * @property string $endorsement_no
 * @property string $start_date
 * @property string $end_date
 * @property double $endorsement_premium_paid
 */
class VgInsuranceEndorsement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_endorsement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mother_policy_id', 'endorsement_no', 'start_date', 'end_date', 'endorsement_premium_paid'], 'required'],           
            [['start_date', 'end_date','mother_policy_id'], 'safe'],
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
            'mother_policy_id' => 'Mother Policy ID',
            'endorsement_no' => 'Endorsement No',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'endorsement_premium_paid' => 'Premium Paid',
        ];
    }
}
