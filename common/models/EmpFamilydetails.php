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
class EmpFamilydetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_familydetails';
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
            [['nominee','age_group','gmc_no'], 'string'],
            [['relationship'], 'string', 'max' => 150],
            [['name'], 'string', 'max' => 250],
            [['mobileno'], 'string', 'max' => 10],
            [['aadhaarno'], 'string', 'max' => 12],
			[['sum_insured'], 'number'],
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
			'gmc_no' => 'GMC No.',
			'sum_insured' => 'GMC SUM Insured',
			'age_group' => 'GMC Age Group',
        ];
    }
}
