<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee_log".
 *
 * @property int $id
 * @property int $user
 * @property string $updatedate
 * @property string $designation_from
 * @property string $designation_to
 * @property string $attendance_from
 * @property string $attendance_to
 * @property string $esi_from
 * @property string $esi_to
 * @property string $pf_from
 * @property string $pf_to
 * @property string $pf_ restrict_from
 * @property string $pf_ restrict_to
 * @property double $pli_from
 * @property double $pli_to
 */
class EmployeeLog extends \yii\db\ActiveRecord {

   /**
    * {@inheritdoc}
    */
   public static function tableName() {
      return 'employee_log';
   }

   /**
    * {@inheritdoc}
    */
   public function rules() {
      return [
          [['user', 'effectdate','empid'], 'required'],
          [['user', 'flag'], 'integer'],
          [['createdate', 'effectdate'], 'safe'],
          [['esi_from', 'esi_to', 'pf_from', 'pf_to', 'pf_ restrict_from', 'pf_ restrict_to'], 'string'],
          [['pli_from', 'pli_to'], 'number'],
          [['designation_from', 'designation_to'], 'string', 'max' => 255],
          [['attendance_from', 'attendance_to'], 'string', 'max' => 25],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels() {
      return [
          'id' => 'ID',
          'user' => 'User',
          'effectdate' => 'With Effect From',
          'designation_from' => 'Designation From',
          'designation_to' => 'Designation To',
          'attendance_from' => 'Attendance From',
          'attendance_to' => 'Attendance To',
          'esi_from' => 'Esi From',
          'esi_to' => 'Esi To',
          'pf_from' => 'Pf From',
          'pf_to' => 'Pf To',
          'pf_ restrict_from' => 'Pf  Restrict From',
          'pf_ restrict_to' => 'Pf  Restrict To',
          'pli_from' => 'Pli From',
          'pli_to' => 'Pli To',
      ];
   }

}
