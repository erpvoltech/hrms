<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_hierarchy".
 *
 * @property int $id
 * @property int $master_policy_id
 * @property double $sum_insured
 * @property double $fellow_share
 */
class VgInsuranceHierarchy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_hierarchy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_policy_id', 'sum_insured', 'fellow_share'], 'required'],
            [['master_policy_id'], 'integer'],
            [['sum_insured', 'fellow_share'], 'number'],
            [['age_group'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_policy_id' => 'Master Policy ID',
            'sum_insured' => 'Sum Insured',
            'fellow_share' => 'Fellow Share',
            'age_group' => 'Age Group',
        ];
    }
}
