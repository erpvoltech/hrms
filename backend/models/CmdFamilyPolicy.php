<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cmd_family_policy".
 *
 * @property int $id
 * @property string $name
 * @property string $insured_company
 * @property double $sum_insured
 * @property double $premium_amount
 * @property string $terms
 * @property string $policy_date
 * @property string $maturity_date
 * @property string $remarks
 */
class CmdFamilyPolicy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cmd_family_policy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'policy_number', 'insured_company', 'sum_insured', 'premium_amount', 'terms', 'policy_date', 'maturity_date'], 'required'],
            [['sum_insured', 'premium_amount'], 'number'],
            [['terms'], 'string'],
            [['policy_date', 'maturity_date', 'policy_paid_date'], 'safe'],
            [['name', 'policy_number'], 'string', 'max' => 50],
            [['insured_company'], 'string', 'max' => 100],
            [['remarks'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'policy_number' => 'Policy No',
            'insured_company' => 'Insured Company',
            'sum_insured' => 'Sum Insured',
            'premium_amount' => 'Premium Amount',
            'terms' => 'Terms',
            'policy_date' => 'Policy Date',
            'maturity_date' => 'Maturity Date',
			'policy_paid_date' => 'Policy Paid Date',
            'remarks' => 'Remarks',
        ];
    }
}
