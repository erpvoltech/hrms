<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_stationaries_grn_item".
 *
 * @property int $id
 * @property int $grn_id
 * @property int $item_id
 * @property double $quantity
 * @property double $amount
 * @property string $unit
 */
class VeplStationariesGrnItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vepl_stationaries_grn_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grn_id', 'item_id', 'quantity', 'rate', 'amount', 'unit'], 'required'],
            [['grn_id', 'item_id'], 'integer'],
            [['quantity', 'rate', 'amount'], 'number'],
            [['unit'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grn_id' => 'GRN ID',
            'item_id' => 'Item ID',
            'quantity' => 'Quantity',
            'rate' => 'Rate',
            'amount' => 'Amount',
            'unit' => 'Unit',
        ];
    }
}
