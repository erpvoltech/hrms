<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "appointment_letter".
 *
 * @property int $id
 * @property int $empid
 * @property string $type
 * @property int $app_no
 * @property string $letter
 */
class AppointmentLetter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointment_letter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid', 'type', 'app_no', 'letter'], 'required'],
            [['empid', 'app_no'], 'integer'],
            [['type', 'letter'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empid' => 'Empid',
            'type' => 'Type',
            'app_no' => 'App No',
            'letter' => 'Letter',
        ];
    }
}
