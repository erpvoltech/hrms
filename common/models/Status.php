<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $name
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid','status_from','status_to','status_change_date'], 'required'],
            [['empid'], 'integer'],
			[['status_from','status_to'], 'string'],
			[['status_change_date'],'safe'],
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
			'status_from'=>'Status From',
			'status_to'=>'Status To',
			'status_change_date' => 'Date',
        ];
    }
}
