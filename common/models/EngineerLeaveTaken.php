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
class EngineerLeaveTaken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'engineer_leave_taken';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid','year'], 'integer'],
            [['month'], 'safe'],
            [['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','decm','leave_days'], 'number'],
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
			'year' => 'Year',
			'jan'=> 'Jan',
			'feb'=> 'Feb',
			'mar'=> 'Mar',
			'apr'=> 'Apr',
			'may'=> 'May',
			'jun'=> 'June',
			'jul'=> 'July',
			'aug'=> 'Aug',
			'sep'=> 'Sep',
			'oct'=> 'Oct',
			'nov'=> 'Nov',
			'decm'=> 'Dec',
            'leave_days' => 'Leave Days',
            
        ];
    }
}
