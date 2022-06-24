<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $name
 */
class PoMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'po_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id','po_number','po_date','po_delivery_date','po_value'], 'required'],
            [['project_id'], 'integer'],
			[['po_number','po_details'], 'string'],
			[['po_value'], 'number'],
			[['po_date','po_delivery_date'],'safe'],
        ];
    }

    /**
     * {@inheritdoc} integer
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project Code',
			'po_number'=>'Po Number',
			'po_date'=>'Po Date',
			'po_delivery_date'=>'Po Delivery Date',
			'po_value' => 'Po Value',
			'po_details' => 'Po Details',
        ];
    }
}
