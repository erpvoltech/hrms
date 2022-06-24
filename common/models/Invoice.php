<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $name
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id','invoice_number','invoice_date','invoice_value'], 'required'],
            [['project_id'], 'integer'],
			[['invoice_number'], 'string'],
			[['invoice_value'], 'number'],
			[['invoice_date'],'safe'],
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
			'invoice_number'=>'Invoice Number',
			'invoice_date'=>'Invoice Date',
			'invoice_value' => 'Invoice Value',
        ];
    }
}
