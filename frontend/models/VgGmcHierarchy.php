<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_gmc_hierarchy".
 *
 * @property int $id
 * @property int $gmc_policy_id
 * @property double $sum_insured
 * @property double $fellow_share
 * @property string $age_group
 */
class VgGmcHierarchy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_gmc_hierarchy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gmc_policy_id', 'sum_insured', 'fellow_share'], 'required'],
            [['gmc_policy_id'], 'integer'],
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
            'gmc_policy_id' => 'Gmc Policy ID',
            'sum_insured' => 'Sum Insured',
            'fellow_share' => 'Fellow Share',
            'age_group' => 'Age Group',
        ];
    }
}
