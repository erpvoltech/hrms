<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_assign_emp".
 *
 * @property int $id
 * @property int $project_id
 * @property string $month
 * @property int $emp_id
 * @property string $category
 * @property string $date_of_exit
 */
class ProjectEmp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_emp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'month', 'emp_id'], 'required'],
            [['project_id'], 'integer'],
            [['month', 'date_of_exit','emp_id'], 'safe'],
            [['category'], 'string'],
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
            'category' => 'Category',
            'date_of_exit' => 'Date Of Exit',
        ];
    }
	public function getEmp()
    {
        return $this->hasOne(EmpDetails::className(), ['id' => 'emp_id']);
    }
}
