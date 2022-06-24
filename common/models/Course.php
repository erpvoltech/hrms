<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property string $coursename
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coursename'], 'required'],
            [['coursename'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coursename' => 'Coursename',
        ];
    }
}
