<?php

namespace app\models;

use Yii;
use common\models\EmpLeave;
use common\models\EmpLeaveStaff;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;

/**
 * This is the model class for table "emp_salary_upload".
 *
 * @property int $id
 * @property int $empid
 * @property string $staff_type
 * @property string $month
 * @property string $salary_structure
 * @property double $gross
 * @property double $statutory_rate
 * @property double $leavedays
 * @property double $lop_days
 * @property double $allowance_paid
 * @property double $over_time
 * @property double $holiday_pay
 * @property double $arrear
 * @property double $other_allowance
 * @property double $advance
 * @property double $mobile
 * @property double $loan
 * @property double $insurance
 * @property double $rent
 * @property double $tds
 * @property double $lwf
 * @property double $others
 * @property string $periority
 * @property int $customer_id
 * @property string $status
 */
class EmpSalaryUpload extends \yii\db\ActiveRecord {

   public $file;
    public $unitgroup;
	public $category;

   public static function tableName() {
      return 'emp_salary_upload';
   }

   /**
    * {@inheritdoc}
    */
   public function rules() {
      return [
          [['empid', 'staff_type', 'month'], 'required'],
          [['empid', 'customer_id'], 'integer'],
          [['month'], 'safe'],
          [['gross', 'statutory_rate', 'leavedays', 'caution_deposit', 'spl_leave', 'lop_days', 'allowance_paid', 'over_time', 'holiday_pay', 'arrear', 'special_allowance', 'advance', 'mobile', 'loan', 'insurance', 'rent', 'tds', 'lwf', 'others'], 'number'],
          [['priority', 'status'], 'string'],
          [['staff_type'], 'string', 'max' => 20],
          [['salary_structure'], 'string', 'max' => 250],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels() {
      return [
          'id' => 'ID',
          'empid' => 'Empid',
          'staff_type' => 'Staff Type',
          'month' => 'Month',
          'salary_structure' => 'Salary Structure',
          'gross' => 'Gross',
          'statutory_rate' => 'Statutory Rate',
          'leavedays' => 'Leave Days',
		  'spl_leave' => 'Special Leave',
          'lop_days' => 'Lop Days',
          'allowance_paid' => 'Allowance Paid',
          'over_time' => 'Over Time',
          'holiday_pay' => 'Holiday Pay',
          'arrear' => 'Arrear',
          'special_allowance' => 'Special Allowance',
          'advance' => 'Advance',
          'mobile' => 'Mobile',
          'loan' => 'Loan',
		  'caution_deposit'=> 'Caution Deposit',
          'insurance' => 'Insurance',
          'rent' => 'Rent',
          'tds' => 'TDS',
          'lwf' => 'LWF',
          'others' => 'Others',
          'priority' => 'Priority',
          'customer_id' => 'Customer',
          'status' => 'Status',
      ];
   }

   public function getEmployee() {
      return $this->hasOne(EmpDetails::className(), ['id' => 'empid']);
   }

   public function getDesignation() {
      return $this->hasOne(Designation::className(), ['id' => 'designation_id'])->with(['employee']);
   }

   public function getUnits() {
      return $this->hasOne(Unit::className(), ['id' => 'unit_id'])->with(['employee']);
   }

   public function getDepartment() {
      return $this->hasOne(Department::className(), ['id' => 'department_id'])->with(['employee']);
   }

   public function LeaveUpdate($m, $absentdays, $Leave) {   
      $total_leave = 0;
      $balance_leave = 0;
      $balance_first_half = 0;
      $balance_second_half = 0;
      $loss_of_pay_day = 0;
      $lop_day = 0;

      if ($m > 3 && $m <= 9) {
         if ($Leave->remaining_leave_first_half > 0) {
            $lop_day = $Leave->remaining_leave_first_half - $absentdays;
            $total_leave = $Leave->leave_taken_first_half + $absentdays;
            $balance_leave = $Leave->eligible_first_half - $total_leave;
            $Leave->leave_taken_first_half = $total_leave;

            if ($balance_leave > 0)
               $Leave->remaining_leave_first_half = $balance_leave;
            else
               $Leave->remaining_leave_first_half = 0;

            $Leave->save(false);

            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {

            $total_leave = $Leave->leave_taken_first_half + $absentdays;
            $Leave->leave_taken_first_half = $total_leave;
            $Leave->save(false);
            $loss_of_pay_day = $absentdays;
         }
      } else if ($m > 9 && $m <= 12) {	 
         if ($Leave->remaining_leave_second_half > 0) {
            $total_leave = $Leave->leave_taken_second_half + $absentdays;
            if ($Leave->remaining_leave_first_half > 0) {
               $balance_first_half = $Leave->remaining_leave_first_half;
               $balance_second_half = ($Leave->eligible_second_half + $balance_first_half) - $total_leave;
               $Leave->remaining_leave_first_half = 0;
               $lop_day = $balance_second_half;
            } else {
                $balance_second_half = $Leave->eligible_second_half - $total_leave;
               $lop_day = $balance_second_half;
            }
            if ($balance_second_half > 0)
               $balance_second_half = $balance_second_half;
            else
               $balance_second_half = 0;
		   
             $Leave->remaining_leave_second_half = $balance_second_half;
             $Leave->leave_taken_second_half = $total_leave;			
            $Leave->save(false);
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $Leave->leave_taken_second_half + $absentdays;
            $Leave->leave_taken_second_half = $total_leave;
            $Leave->save(false);
            $loss_of_pay_day = $absentdays;
         }
      }else if ($m >= 1 && $m <= 3) {
         if ($Leave->remaining_leave_second_half > 0) {
            $total_leave = $Leave->leave_taken_second_half + $absentdays;
            if ($Leave->remaining_leave_first_half > 0) {
               $balance_first_half = $Leave->remaining_leave_first_half;
               $balance_second_half = ($Leave->eligible_second_half + $balance_first_half) - $total_leave;
               $Leave->remaining_leave_first_half = 0;
               $lop_day = $balance_second_half;
            } else {
               $balance_second_half = $Leave->eligible_second_half - $total_leave;
               $lop_day = $balance_second_half;
            }
            if ($balance_second_half > 0)
               $balance_second_half = $balance_second_half;
            else
               $balance_second_half = 0;
            $Leave->remaining_leave_second_half = $balance_second_half;
            $Leave->leave_taken_second_half = $total_leave;
            $Leave->save(false);
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $Leave->leave_taken_second_half + $absentdays;
            $Leave->leave_taken_second_half = $total_leave;
            $Leave->save(false);
            $loss_of_pay_day = $absentdays;
         }
      }
      return $loss_of_pay_day;
   }

   public function LeaveUpdateStaff($m, $absentdays, $LeaveStaff) {

      $total_leave = 0;
      $balance_first_quarter = 0;
      $balance_second_quarter = 0;
      $balance_third_quarter = 0;
      $balance_fourth_quarter = 0;
      $loss_of_pay_day = 0;
      $lop_day = 0;

      if ($m > 3 && $m <= 6) {
         if ($LeaveStaff->remaining_leave_first_quarter > 0) {
            $lop_day = $LeaveStaff->remaining_leave_first_quarter - $absentdays;
            $total_leave = $LeaveStaff->leave_taken_first_quarter + $absentdays;
            $balance_first_quarter = $LeaveStaff->eligible_first_quarter - $total_leave;
            $LeaveStaff->leave_taken_first_quarter = $total_leave;
            if ($balance_first_quarter > 0)
               $LeaveStaff->remaining_leave_first_quarter = $balance_first_quarter;
            else
               $LeaveStaff->remaining_leave_first_quarter = 0;
            $LeaveStaff->save(false);
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $LeaveStaff->leave_taken_first_quarter + $absentdays;
            $LeaveStaff->leave_taken_first_quarter = $total_leave;
            $LeaveStaff->save(false);
            $loss_of_pay_day = $absentdays;
         }
      } else if ($m > 6 && $m <= 9) {
         if ($LeaveStaff->remaining_leave_second_quarter > 0) {
            $total_leave = $LeaveStaff->leave_taken_second_quarter + $absentdays;
            if ($LeaveStaff->remaining_leave_first_quarter > 0) {
               $balance_first_quarter = $LeaveStaff->remaining_leave_first_quarter;
               $balance_second_quarter = ($LeaveStaff->eligible_second_quarter + $balance_first_quarter) - $total_leave;
               $LeaveStaff->remaining_leave_first_quarter = 0;
               $lop_day = $balance_second_quarter;
            } else {
               $balance_second_quarter = $LeaveStaff->eligible_second_quarter - $total_leave;
               $lop_day = $balance_second_quarter;
            }
            if ($balance_second_quarter > 0)
               $balance_second_quarter = $balance_second_quarter;
            else
               $balance_second_quarter = 0;
            $LeaveStaff->remaining_leave_second_quarter = $balance_second_quarter;
            $LeaveStaff->leave_taken_second_quarter = $total_leave;
            $LeaveStaff->save(false);
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $LeaveStaff->leave_taken_second_quarter + $absentdays;
            $LeaveStaff->leave_taken_second_quarter = $total_leave;
            $LeaveStaff->save(false);
            $loss_of_pay_day = $absentdays;
         }
      } else if ($m > 9 && $m <= 12) {
         if ($LeaveStaff->remaining_leave_third_quarter > 0) {
            $total_leave = $LeaveStaff->leave_taken_third_quarter + $absentdays;
            if ($LeaveStaff->remaining_leave_second_quarter > 0) {
               $balance_second_quarter = $LeaveStaff->remaining_leave_second_quarter;
               $balance_third_quarter = ($LeaveStaff->eligible_third_quarter + $balance_second_quarter) - $total_leave;
               $LeaveStaff->remaining_leave_second_quarter = 0;
               $lop_day = $balance_third_quarter;
            } else {
               $balance_third_quarter = $LeaveStaff->eligible_third_quarter - $total_leave;
               $lop_day = $balance_third_quarter;
            }
            if ($balance_third_quarter > 0)
               $balance_third_quarter = $balance_third_quarter;
            else
               $balance_third_quarter = 0;
            $LeaveStaff->remaining_leave_third_quarter = $balance_third_quarter;
            $LeaveStaff->leave_taken_third_quarter = $total_leave;
            $LeaveStaff->save(false);
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $LeaveStaff->leave_taken_third_quarter + $absentdays;
            $LeaveStaff->leave_taken_third_quarter = $total_leave;
            $LeaveStaff->save(false);
            $loss_of_pay_day = $absentdays;
         }
      } else if ($m >= 1 && $m <= 3) {
         if ($LeaveStaff->remaining_leave_fourth_quarter > 0) {
            $total_leave = $LeaveStaff->leave_taken_fourth_quarter + $absentdays;
            if ($LeaveStaff->remaining_leave_third_quarter > 0) {
               $balance_third_quarter = $LeaveStaff->remaining_leave_third_quarter;
               $balance_fourth_quarter = ($LeaveStaff->eligible_fourth_quarter + $balance_third_quarter) - $total_leave;
               $LeaveStaff->remaining_leave_third_quarter = 0;
               $lop_day = $balance_fourth_quarter;
            } else {
               $balance_fourth_quarter = $LeaveStaff->eligible_fourth_quarter - $total_leave;
               $lop_day = $balance_fourth_quarter;
            }
            if ($balance_fourth_quarter > 0)
               $balance_fourth_quarter = $balance_fourth_quarter;
            else
               $balance_fourth_quarter = 0;
            $LeaveStaff->remaining_leave_fourth_quarter = $balance_fourth_quarter;
            $LeaveStaff->leave_taken_fourth_quarter = $total_leave;
            $LeaveStaff->save(false);
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $LeaveStaff->leave_taken_fourth_quarter + $absentdays;
            $LeaveStaff->leave_taken_fourth_quarter = $total_leave;
            $LeaveStaff->save(false);
            $loss_of_pay_day = $absentdays;
         }
      }
      return $loss_of_pay_day;
   }

}
