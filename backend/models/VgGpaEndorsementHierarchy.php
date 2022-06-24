<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_gpa_endorsement_hierarchy".
 *
 * @property int $id
 * @property int $gpa_endorsement_id
 * @property double $endorsement_sum_insured
 * @property double $endorsement_fellow_share
 */
class VgGpaEndorsementHierarchy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_gpa_endorsement_hierarchy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gpa_endorsement_id', 'endorsement_sum_insured', 'endorsement_fellow_share'], 'required'],
            [['gpa_endorsement_id'], 'integer'],
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
            'gpa_endorsement_id' => 'Gpa Endorsement ID',
            'endorsement_sum_insured' => 'Endorsement Sum Insured',
            'endorsement_fellow_share' => 'Endorsement Fellow Share',
        ];
    }
}
