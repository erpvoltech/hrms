<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff_leve_monthwise".
 *
 * @property int $id
 * @property int $empid
 * @property int $eligible
 * @property int $leavedays
 * @property int $flop
 * @property int $lop
 * @property int $spl_leave
 * @property int $next_eligible
 */
class StaffLeveMonthwise extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_leve_monthwise';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid', 'eligible', 'next_eligible'], 'required'],
            [['empid', 'eligible', 'leavedays', 'flop', 'lop', 'spl_leave', 'next_eligible'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empid' => 'Empid',
            'eligible' => 'Eligible',
            'leavedays' => 'Leavedays',
            'flop' => 'Flop',
            'lop' => 'Lop',
            'spl_leave' => 'Spl Leave',
            'next_eligible' => 'Next Eligible',
        ];
    }
}
