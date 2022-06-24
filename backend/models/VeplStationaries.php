<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_stationaries".
 *
 * @property int $id
 * @property string $item_category
 * @property string $item_name
 */
class VeplStationaries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vepl_stationaries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_category', 'item_name'], 'required'],
            [['item_category'], 'string', 'max' => 100],
            [['item_name'], 'string', 'max' => 256],
			[['item_name'], 'unique', 'targetAttribute' => ['item_name'], 'message' => 'This data already exists'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_category' => 'Item Category',
            'item_name' => 'Item Name',
        ];
    }
    
   
}
