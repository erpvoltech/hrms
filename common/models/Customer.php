<?php
namespace common\models;
use Yii;

class Customer extends \yii\db\ActiveRecord
{    
    public static function tableName()
    {
        return 'customer';
    }
	
    public function rules()
    {
        return [
            [['customer_name'], 'required'],
            [['type'], 'string'],
            [['customer_name'], 'string', 'max' => 255],
            [['customer_name'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_name' => 'Customer Name',
            'type' => 'Type',
        ];
    }
	
	public function getContacts()
    {
        return $this->hasMany(CustomerContact::className(), ['customer_id'=>'id']);
    }
    public function getCustomer()
    {
        return $this->hasOne(CustomerContact::className(), ['customer_id'=>'id'])->one();
    }
}

