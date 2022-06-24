<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_wage_components".
 *
 * @property int $id
 * @property int $project_id
 * @property string $month
 * @property int $emp_id
 * @property double $wages
 * @property double $days
 * @property double $overtime_hours
 * @property double $basic_da
 * @property double $spacial_basic
 * @property double $overtime_payment
 * @property double $hra
 * @property double $canteen_allowance
 * @property double $transport_allowance
 * @property double $washing_allowance
 * @property double $other_allowance
 * @property double $total
 * @property double $pf
 * @property double $esi
 * @property double $society
 */
class ProjectWageComponents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_wage_components';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'month', 'emp_id', 'wages', 'days', 'overtime_hours', 'basic_da', 'spacial_basic', 'overtime_payment', 'hra', 'canteen_allowance', 'transport_allowance', 'washing_allowance', 'other_allowance', 'total', 'pf', 'esi', 'society'], 'required'],
            [['project_id', 'emp_id'], 'integer'],
            [['month'], 'safe'],
            [['wages', 'days', 'overtime_hours', 'basic_da', 'spacial_basic', 'overtime_payment', 'hra', 'canteen_allowance', 'transport_allowance', 'washing_allowance', 'other_allowance', 'total', 'pf', 'esi', 'society'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'month' => 'Month',
            'emp_id' => 'Emp ID',
            'wages' => 'Wages',
            'days' => 'Days',
            'overtime_hours' => 'Overtime Hours',
            'basic_da' => 'Basic Da',
            'spacial_basic' => 'Spacial Basic',
            'overtime_payment' => 'Overtime Payment',
            'hra' => 'Hra',
            'canteen_allowance' => 'Canteen Allowance',
            'transport_allowance' => 'Transport Allowance',
            'washing_allowance' => 'Washing Allowance',
            'other_allowance' => 'Other Allowance',
            'total' => 'Total',
            'pf' => 'Pf',
            'esi' => 'Esi',
            'society' => 'Society',
        ];
    }
}
