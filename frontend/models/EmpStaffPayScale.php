<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "emp_staff_pay_scale".
 *
 * @property int $id
 * @property string $package_name
 * @property double $basic
 * @property double $dearness_allowance
 * @property double $hra
 * @property double $spl_allowance
 * @property double $conveyance_allowance
 * @property double $lta
 * @property double $medical
 * @property double $pli
 * @property string $other_allowance
 */
class EmpStaffPayScale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_staff_pay_scale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salarystructure', 'basic', 'dearness_allowance', 'hra'], 'required'],
            [['basic', 'dearness_allowance', 'hra',  'conveyance_allowance', 'lta', 'medical', 'pli'], 'number'],
            [['salarystructure', 'other_allowance'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salarystructure' => 'Package Name',
            'basic' => 'Basic',
            'dearness_allowance' => 'Dearness Allowance',
            'hra' => 'Hra',
            //'spl_allowance' => 'Spl Allowance',
            'conveyance_allowance' => 'Conveyance Allowance',
            'lta' => 'Lta',
            'medical' => 'Medical',
            'pli' => 'Pli',
            'other_allowance' => 'Other Allowance',
        ];
    }
}
