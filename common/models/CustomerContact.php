<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_contact".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $contact_person
 * @property string $contact_mobile
 * @property string $contact_email
 */
class CustomerContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_contact';
    }

    /**
		* {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id'], 'required'],
            [['customer_id'], 'integer'],
            [['contact_person', 'contact_email'], 'string', 'max' => 250],
            [['contact_mobile'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer',
            'contact_person' => 'Contact Person',
            'contact_mobile' => 'Contact Mobile',
            'contact_email' => 'Contact Email',
        ];
    }
	public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id'=>'customer_id']);
    }
}
