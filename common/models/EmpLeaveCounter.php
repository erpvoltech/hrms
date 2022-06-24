<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_leave_counter".
 *
 * @property int $id
 * @property int $empid
 * @property string $month
 * @property double $leave_days
 * @property double $forced_lop
 */
class EmpLeaveCounter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_leave_counter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid'], 'integer'],
            [['month'], 'safe'],
            [['leave_days', 'forced_lop','lop_days'], 'number'],
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
            'month' => 'Month',
            'leave_days' => 'Leave Days',
            'forced_lop' => 'Forced LOP',
			'lop_days' => 'LOP',
        ];
    }
}
