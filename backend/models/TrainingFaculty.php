<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "training_faculty".
 *
 * @property int $id
 * @property string $faculty_ecode
 * @property string $faculty_name
 * @property string $created_by
 * @property string $created_date
 */
class TrainingFaculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_faculty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faculty_ecode', 'faculty_name', 'created_by', 'created_date'], 'required'],
            [['created_date'], 'safe'],
            [['faculty_ecode'], 'string', 'max' => 50],
            [['faculty_name', 'created_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'faculty_ecode' => 'Faculty Ecode',
            'faculty_name' => 'Faculty Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
        ];
    }
}
