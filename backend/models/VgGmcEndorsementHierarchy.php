<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_gmc_endorsement_hierarchy".
 *
 * @property int $id
 * @property int $gmc_endorsement_id
 * @property double $endorsement_sum_insured
 * @property double $endorsement_fellow_share
 */
class VgGmcEndorsementHierarchy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_gmc_endorsement_hierarchy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gmc_endorsement_id', 'endorsement_sum_insured', 'endorsement_fellow_share', 'endorsement_age_group'], 'required'],
            [['gmc_endorsement_id'], 'safe'],
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
            'gmc_endorsement_id' => 'Gmc Endorsement ID',
            'endorsement_sum_insured' => 'Sum Insured',
            'endorsement_fellow_share' => 'Fellow Share',
            'endorsement_age_group' => 'Age Group',
        ];
    }
}
