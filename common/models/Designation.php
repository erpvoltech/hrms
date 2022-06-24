<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "designation".
 *
 * @property int $id
 * @property string $designation
 */
class Designation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'designation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designation'], 'required'],
            [['designation'], 'string', 'max' => 100],
			[['salary_slot'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'designation' => 'Designation',
			'salary_slot' => 'Salary Slot',
        ];
    }
}
