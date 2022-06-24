<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus".
 *
 * @property int $id
 * @property int $emp_id
 * @property double $amount
 */
class EmailSeparate extends \yii\db\ActiveRecord
{
    public $file;
    public static function tableName()
    {
        return 'email_separate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [           
            [['emp_id'], 'integer'],
            [['month'], 'safe'],
			[['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emp_id' => 'Emp ID',
            'month' => 'Month',
        ];
    }
	
	public function getEmployee()
    {
        return $this->hasOne(EmpDetails::className(), ['id' => 'emp_id']);
    }
	
}
