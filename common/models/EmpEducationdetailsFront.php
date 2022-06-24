<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_educationdetails".
 *
 * @property int $id
 * @property int $empid
 * @property string $qualification
 * @property int $course
 * @property int $institute
 * @property string $yop
 * @property string $board
 */
class EmpEducationdetailsFront extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_educationdetails_front';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid','course', 'institute','qualification','yop','board'], 'required'],
            [['empid', 'course','qualification'], 'integer'],
            [['yop'], 'safe'],           
            [['board','institute'], 'string', 'max' => 255],
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
            'qualification' => 'Qualification',
            'course' => 'Course',
            'institute' => 'Institute',
            'yop' => 'Yop',
            'board' => 'Board',
        ];
    }
}
