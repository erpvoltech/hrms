<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_endorsement_hierarchy".
 *
 * @property int $id
 * @property int $endorsement_policy_id
 * @property double $endorsement_sum_insured
 * @property double $endorsement_fellow_share
 */
class VgInsuranceEndorsementHierarchy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_endorsement_hierarchy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['endorsement_policy_id', 'endorsement_sum_insured', 'endorsement_fellow_share'], 'required'],
            [['endorsement_policy_id'], 'integer'],
            [['endorsement_sum_insured', 'endorsement_fellow_share'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'endorsement_policy_id' => 'Endorsement Policy ID',
            'endorsement_sum_insured' => 'Endorsement Sum Insured',
            'endorsement_fellow_share' => 'Endorsement Fellow Share',
        ];
    }
}
