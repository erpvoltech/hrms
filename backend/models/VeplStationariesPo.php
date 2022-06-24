<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_stationaries_po".
 *
 * @property int $id
 * @property int $po_no
 * @property string $po_date
 * @property string $last_purchase_date
 * @property int $po_supplier_id
 * @property string $po_prepared_by
 * @property string $po_apporoved_by
 * @property string $po_approval_status
 */
class VeplStationariesPo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vepl_stationaries_po';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['po_no', 'po_date', 'last_purchase_date', 'po_supplier_id', 'po_sgst', 'po_cgst'], 'required'],
            [['po_supplier_id', 'po_sgst', 'po_igst', 'po_cgst', 'po_approved_by', 'po_approval_status'], 'integer'],
            [['po_date', 'last_purchase_date'], 'safe'],
            [['po_prepared_by'], 'string', 'max' => 150],
            [['po_no'], 'string', 'max' => 25],
            [['po_total_amount', 'po_net_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'po_no' => 'PO No',
            'po_date' => 'PO Date',
            'last_purchase_date' => 'Last Purchase Date',
            'po_supplier_id' => 'Supplier Name',
            'po_prepared_by' => 'PO Prepared by',
            'po_approved_by' => 'PO Apporoved by',
            'po_approval_status' => 'PO Approval Status',
            'po_total_amount'=>' Total Amount',
            'po_sgst'=>'SGST(%)',
            'po_igst'=>'IGST(%)',
            'po_cgst'=>'CGST(%)',
            'po_net_amount'=>'Net Amount',
        ];
    }
    
    public function getSuppliers()
    {
        return $this->hasOne(VeplSupplier::className(), ['id' => 'po_supplier_id']);
    }
    
    public function getIems()
    {
        return $this->hasOne(VeplStationaries::className(), ['id' => 'po_item_id']);
    }
    
    public function getGrnIems()
    {
        return $this->hasOne(VeplStationariesPoSub::className(), ['id' => 'po_id']);
    }
}
