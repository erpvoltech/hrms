<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $name
 */
class EngineerTransfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'engineer_transfer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid','division_from','division_to','transfer_date'], 'required'],
            [['empid','division_from','division_to'], 'integer'],
			[['transfer_date'],'safe'],
        ];
    }

    /**
     * {@inheritdoc} integer
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empid' => 'Emp ID',
			'division_from' => 'Division From',
			'division_to' => 'Division To',
			'transfer_date' => 'Date',
        ];
    }
}
