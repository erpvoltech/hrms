<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_promotion".
 *
 * @property int $id
 * @property int $user
 * @property string $createdate
 * @property int $empid
 * @property string $effectdate
 * @property string $ss_from
 * @property string $ss_to
 * @property string $wl_from
 * @property string $wl_to
 * @property string $grade_from
 * @property string $grade_to
 * @property double $basic
 * @property double $other_allowance
 * @property double $gross_from
 * @property double $gross_to
 * @property int $flag
 */
class EmpPromotion extends \yii\db\ActiveRecord {

   public $searchuser;
   public $hra;
   public $splallowance;
   public $dearness_allowance;
   public $lta;
   public $medical;
   public $conveyance;

   public static function tableName() {
      return 'emp_promotion';
   }

   /**
    * {@inheritdoc}
    */
   public function rules() {
      return [
          [['user', 'createdate', 'empid', 'effectdate', 'flag'], 'required'],
          [['user', 'empid', 'flag','type','email_flag'], 'integer'],
          [['createdate', 'effectdate'], 'safe'],
          [['basic', 'other_allowance', 'gross_from', 'gross_to','pli_from','pli_to'], 'number'],
          [['ss_from', 'ss_to'], 'string', 'max' => 100],
          [['wl_from', 'wl_to'], 'string', 'max' => 25],
          [['grade_from', 'grade_to'], 'string', 'max' => 10],
          [['designation_from', 'designation_to'], 'integer'],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels() {
      return [
          'id' => 'ID',
          'user' => 'Entry User',
          'createdate' => 'Createdate',
          'empid' => 'Empid',
          'effectdate' => 'Effectdate',
          'ss_from' => 'Salary Structure From',
          'ss_to' => 'Salary Structure',
          'wl_from' => 'Wl From',
          'wl_to' => 'Work Level',
          'grade_from' => 'Grade From',
          'grade_to' => 'Grade ',
          'basic' => 'Basic',
          'other_allowance' => 'Other Allowance',
          'gross_from' => 'Gross From',
          'gross_to' => 'Gross',
          'flag' => 'Flag',
          'designation_to' => 'Designation',
		  'PLI from' => 'PLI from',
		  'PLI to' => 'PLI To',
		  'type' => 'Type',
      ];
   }

   public function getEmployee() {
      return $this->hasOne(EmpDetails::className(), ['id' => 'empid']);
   }

   public function getUserdetails() {
      return $this->hasOne(User::className(), ['id' => 'user']);
   }

}
