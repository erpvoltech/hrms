<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "salary_month".
 *
 * @property int $id
 * @property string $month
 */
class SalaryMonth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salary_month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month'], 'required'],
            [['month'], 'safe'],				
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
        ];
    }
	
}
