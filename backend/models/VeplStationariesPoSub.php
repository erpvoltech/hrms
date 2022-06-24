<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_stationaries_po_sub".
 *
 * @property int $id
 * @property int $po_id
 * @property int $po_item_id
 * @property int $po_qty
 * @property double $po_rate
 * @property double $po_amount
 * @property double $po_total_amount
 * @property int $po_sgst
 * @property int $po_igst
 * @property int $po_cgst
 * @property double $po_net_amount
 */
class VeplStationariesPoSub extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vepl_stationaries_po_sub';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['po_id', 'po_item_id', 'po_qty', 'po_rate', 'po_amount'], 'required'],
            [['po_id', 'po_item_id', 'po_qty'], 'integer'],
            [['po_rate', 'po_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'po_id' => 'PO ID',
            'po_item_id' => 'Item Name',
            'po_qty' => 'Qty',
            'po_rate' => 'Rate',
            'po_amount' => 'Amount',
        ];
    }
}
