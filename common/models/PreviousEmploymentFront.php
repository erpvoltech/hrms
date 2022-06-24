<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "previous_employment".
 *
 * @property int $id
 * @property int $empid
 * @property string $company
 * @property string $company_address
 * @property string $designation
 * @property string $job_type
 * @property double $last_drawn_salary
 * @property string $work_from
 * @property string $work_to
 * @property string $reason_for_leaving
 */
class PreviousEmploymentFront extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'previous_employment_front';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid','company', 'designation', 'job_type','company_address','work_from', 'work_to'], 'required'],
            [['empid'], 'integer'],
            [['company_address', 'reason_for_leaving'], 'string'],
            [['last_drawn_salary'], 'number'],
            [['work_from', 'work_to'], 'safe'],
            [['company', 'designation', 'job_type'], 'string', 'max' => 250],
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
            'company' => 'Company',
            'company_address' => 'Place of work (city)',
            'designation' => 'Designation',
            'job_type' => 'Department',
            'last_drawn_salary' => 'Last Drawn Salary',
            'work_from' => 'Work From',
            'work_to' => 'Work To',
            'reason_for_leaving' => 'Reason For Leaving',
        ];
    }
}
