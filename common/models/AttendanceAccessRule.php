<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attendance_access_rule".
 *
 * @property int $id
 * @property string $user
 * @property string $unit
 * @property string $division
 */
class AttendanceAccessRule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance_access_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'unit'], 'required'],
            [['user', 'unit', 'division'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'unit' => 'Unit',
            'division' => 'Division',
        ];
    }
    public function getUnits()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit']);
    }
        public function getDivisions()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }   
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }   
}
