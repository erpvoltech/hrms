<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_policy".
 *
 * @property int $id
 * @property string $policy_for
 * @property string $policy_type
 */
class VgInsurancePolicy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_policy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['policy_for', 'policy_type'], 'required'],
            [['policy_for', 'policy_type'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'policy_for' => 'Policy For',
            'policy_type' => 'Policy Type',
        ];
    }
}
