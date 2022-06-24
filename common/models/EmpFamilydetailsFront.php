<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_familydetails".
 *
 * @property int $id
 * @property int $empid
 * @property string $relationship
 * @property string $name
 * @property string $mobileno
 * @property string $aadhaarno
 * @property string $birthdate
 * @property string $nominee
 */
class EmpFamilydetailsFront extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_familydetails_front';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid'], 'integer'],
            [['birthdate'], 'safe'],
            [['nominee'], 'string'],
            [['relationship'], 'string', 'max' => 150],
            [['name'], 'string', 'max' => 250],
            [['mobileno'], 'string', 'max' => 10],
            [['aadhaarno'], 'string', 'max' => 12],
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
            'relationship' => 'Relationship',
            'name' => 'Name',
            'mobileno' => 'Mobileno',
            'aadhaarno' => 'Aadhaarno',
            'birthdate' => 'Birthdate',
            'nominee' => 'Nominee',
        ];
    }
}
