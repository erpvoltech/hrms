<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_supplier".
 *
 * @property int $id
 * @property string $supplier_name
 * @property string $supplier_address
 * @property string $supplier_contact_no
 */
class VeplSupplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vepl_supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_name', 'supplier_address_one', 'supplier_contact_no'], 'required'],
            [['supplier_name'], 'string', 'max' => 150],
            [['supplier_address_one', 'supplier_address_two', 'supplier_address_three'], 'string', 'max' => 150],
            [['supplier_contact_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_name' => 'Supplier Name',
            'supplier_address_one' => 'Shop No',
            'supplier_address_two' => 'Street Name',
            'supplier_address_three' => 'PIN Code',
            'supplier_contact_no' => 'Contact No',
        ];
    }
}
