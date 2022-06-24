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
class EmpEducationdetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_educationdetails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid', 'course', 'institute','qualification'], 'integer'],
            [['yop'], 'safe'],           
            [['board'], 'string', 'max' => 255],
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
	public function getCourses()
    {
        return $this->hasOne(Course::className(), ['id' => 'course']);
    }
	public function getQualifications()
    {
        return $this->hasOne(Qualification::className(), ['id' => 'qualification']);
    }
	public function getCollege()
    {
        return $this->hasOne(College::className(), ['id' => 'institute']);
    }
}
