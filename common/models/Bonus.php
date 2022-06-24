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
class Bonus extends \yii\db\ActiveRecord
{
    public $file;
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [           
            [['emp_id'], 'integer'],
            [['amount','mail_status'], 'number'],
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
            'amount' => 'Bonus Amount',
        ];
    }
	
	public function getEmployee()
    {
        return $this->hasOne(EmpDetails::className(), ['id' => 'emp_id']);
    }
}
