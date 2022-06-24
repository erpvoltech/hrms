<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_stationaries_grn".
 *
 * @property int $id
 * @property string $grn_date
 * @property int $supplier_id
 * @property string $bill_no
 */
class VeplStationariesGrn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vepl_stationaries_grn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grn_date', 'supplier_id', 'bill_no'], 'required'],
            [['grn_date'], 'safe'],
            [['supplier_id'], 'integer'],
            [['bill_no'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grn_date' => 'GRN Date',
            'supplier_id' => 'Supplier Name',
            'bill_no' => 'Bill No',
        ];
    }
    
    public function getSuppliers()
    {
        return $this->hasOne(VeplSupplier::className(), ['id' => 'supplier_id']);
    }
    
    public function getIems()
    {
        return $this->hasOne(VeplStationaries::className(), ['id' => 'item_id']);
    }
    
    public function getGrnIems()
    {
        return $this->hasOne(VeplStationariesGrnItem::className(), ['id' => 'grn_id']);
    }
}
