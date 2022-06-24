<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_gpa_hierarchy".
 *
 * @property int $id
 * @property int $gpa_policy_id
 * @property double $sum_insured
 * @property double $fellow_share
 */
class VgGpaHierarchy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_gpa_hierarchy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sum_insured', 'fellow_share'], 'required'],
            [['gpa_policy_id'], 'safe'],
            [['gpa_policy_id'], 'integer'],
            [['sum_insured', 'fellow_share'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gpa_policy_id' => 'Gpa Policy ID',
            'sum_insured' => 'Sum Insured',
            'fellow_share' => 'Fellow Share',
        ];
    }
}
