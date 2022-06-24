<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_stationaries_issue_sub".
 *
 * @property int $id
 * @property int $issue_item_id
 * @property int $issued_qty
 */
class VeplStationariesIssueSub extends \yii\db\ActiveRecord
{
    public $stock_qty;
    public static function tableName()
    {
        return 'vepl_stationaries_issue_sub';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['issue_id', 'issue_item_id', 'issued_qty'], 'required'],
            [['issue_id', 'issue_item_id', 'issued_qty'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'issue_id' => 'Issued ID',
            'issue_item_id' => 'Item Name',
            'issued_qty' => 'Issued Qty',
            'stock_qty' =>'Stock Qty'
        ];
    }
}
