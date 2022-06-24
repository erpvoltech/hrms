<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_stationaries_stock".
 *
 * @property int $id
 * @property int $item_id
 * @property int $balance_qty
 */
class VeplStationariesStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vepl_stationaries_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'balance_qty'], 'required'],
            [['item_id', 'balance_qty'], 'integer'],
            [['item_id'], 'unique', 'targetAttribute' => ['item_id'], 'message' => 'This data already exists'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Stationaries Name',
            'balance_qty' => 'Quantity',
        ];
    }
    
    public function getStationaries()
    {
        return $this->hasOne(VeplStationaries::className(), ['id' => 'item_id']);
    }
}
