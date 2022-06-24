<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_personaldetails".
 *
 * @property int $id
 * @property int $empid
 * @property string $dob
 * @property string $birthday
 * @property string $gender
 * @property string $mobile_no
 * @property string $email
 * @property string $blood_group
 * @property string $caste
 * @property string $community
 * @property string $martialstatus
 * @property string $panno
 * @property string $aadhaarno
 * @property string $passportno
 * @property string $passportvalid
 * @property string $passport_remark
 * @property string $voteridno
 * @property string $drivinglicenceno
 * @property string $licence_categories
 * @property string $licence_remark
 */
class EmpPersonaldetailsFront extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_personaldetails_front';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid','dob','birthday','gender','caste','community','blood_group','martialstatus','aadhaarno'], 'required'],
            [['empid'], 'integer'],
            [['dob', 'birthday', 'passportvalid'], 'safe'],
            [['gender', 'martialstatus', 'passport_remark', 'licence_categories', 'licence_remark'], 'string'],
            [['mobile_no', 'panno', 'voteridno'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 255],
            [['blood_group'], 'string', 'max' => 50],
            [['caste'], 'string', 'max' => 150],
            [['community'], 'string', 'max' => 100],
            [['aadhaarno'], 'string', 'max' => 12],
            [['passportno'], 'string', 'max' => 7],
            [['drivinglicenceno'], 'string', 'max' => 16],
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
            'dob' => 'DOB (as per document)',
            'birthday' => 'Birthday',
            'gender' => 'Gender',
            'mobile_no' => 'Mobile No',
            'email' => 'Email',
            'blood_group' => 'Blood Group',
            'caste' => 'Caste',
            'community' => 'Community',
            'martialstatus' => 'Martialstatus',
            'panno' => 'Panno',
            'aadhaarno' => 'Aadhaarno',
            'passportno' => 'Passportno',
            'passportvalid' => 'Passportvalid',
            'passport_remark' => 'Passport Remark',
            'voteridno' => 'Voteridno',
            'drivinglicenceno' => 'Drivinglicenceno',
            'licence_categories' => 'Licence Categories',
            'licence_remark' => 'Licence Remark',
        ];
    }
     public function getEmployee() {
      return $this->hasOne(EmpDetails::className(), ['id' => 'empid']);
   }
}
