<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_benefits".
 *
 * @property int $id
 * @property string $wl
 * @property string $grade
 * @property string $travelmode_ss
 * @property string $travelmode_ts
 * @property double $loading_metro
 * @property double $loading_nonmetro
 * @property double $boarding_metro
 * @property double $boarding_nonmetro
 * @property double $gpa
 * @property double $gmc
 */
class EmpBenefits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_benefits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wl', 'grade', 'travelmode_ss', 'travelmode_ts', 'lodging_metro', 'lodging_nonmetro', 'boarding_metro', 'boarding_nonmetro', 'gpa', 'gmc'], 'required'],
            [['lodging_metro', 'lodging_nonmetro', 'boarding_metro', 'boarding_nonmetro', 'gpa', 'gmc'], 'number'],
            [['wl', 'grade'], 'string', 'max' => 10],
            [['travelmode_ss', 'travelmode_ts'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wl' => 'WL',
            'grade' => 'Grade',
            'travelmode_ss' => 'Travelmode Ss',
            'travelmode_ts' => 'Travelmode Ts',
            'lodging_metro' => 'Lodging Metro',
            'lodging_nonmetro' => 'Lodging Nonmetro',
            'boarding_metro' => 'Boarding Metro',
            'boarding_nonmetro' => 'Boarding Non Metro',
            'gpa' => 'GPA',
            'gmc' => 'GMC',
        ];
    }
}
