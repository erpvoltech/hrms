<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $name
 */
class EngineertransferProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'engineertransfer_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid','unit_from','unit_to','division_from','division_to','transfer_date'], 'required'],
            [['empid','unit_from','unit_to','division_from','division_to'], 'integer'],
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
			'unit_from'=>'Unit From',
			'unit_to'=>'Unit To',
			'division_from' => 'Division From',
			'division_to' => 'Division To',
			'transfer_date' => 'Date',
        ];
    }
}
