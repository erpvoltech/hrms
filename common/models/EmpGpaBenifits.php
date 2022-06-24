<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_gpa_benifits".
 *
 * @property int $id
 * @property string $wl
 * @property string $grade
 * @property double $engg
 * @property double $staff
 * @property double $driver_security
 * @property double $consultant
 */
class EmpGpaBenifits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_gpa_benifits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wl', 'grade', 'engg', 'staff', 'driver_security', 'consultant'], 'required'],
            [['engg', 'staff', 'driver_security', 'consultant'], 'number'],
            [['wl', 'grade'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wl' => 'Wl',
            'grade' => 'Grade',
            'engg' => 'Engg',
            'staff' => 'Staff',
            'driver_security' => 'Driver Security',
            'consultant' => 'Consultant',
        ];
    }
}
