<?php

namespace common\models;

use Yii;
use common\models\EmpLeaveCounter;

class EmpSalary extends \yii\db\ActiveRecord {

   public $absent;
   public $statutory_rate;
   public $lop;
   public $allowance_paid;
   public $statutory_rate_esi;
   public $esirestric;
   public $netsalary;

   public static function tableName() {
      return 'emp_salary';
   }

   /**
    * {@inheritdoc}
    */
   public function rules() {
      return [
          [['date', 'empid', 'attendancetype', 'designation', 'month', 'paiddays', 'basic', 'total_earning', 'total_deduction', 'net_amount', 'earned_ctc'], 'required'],
          [['date', 'month'], 'safe'],
          [['user', 'empid', 'designation', 'unit_id', 'department_id','revised','email_status','customer_id','hold','approval'], 'integer'],
          [['pf_wages','esi_wages','food_allowance', 'caution_deposit','statutoryrate', 'absent', 'statutory_rate_esi', 'allowance_paid', 'lop', 'earnedgross', 'paiddays', 'forced_lop', 'paidallowance', 'basic', 'hra', 'spl_allowance', 'dearness_allowance', 'conveyance_allowance', 'over_time', 'arrear', 'advance_arrear_tes', 'lta_earning', 'medical_earning', 'guaranted_benefit', 'misc', 'holiday_pay', 'washing_allowance', 'dust_allowance', 'performance_pay', 'other_allowance', 'total_earning', 'pf', 'insurance', 'professional_tax', 'esi', 'advance', 'tes', 'mobile', 'loan', 'rent', 'tds', 'lwf', 'other_deduction', 'total_deduction', 'net_amount', 'pf_employer_contribution', 'esi_employer_contribution', 'pli_employer_contribution', 'lta_employer_contribution', 'med_employer_contribution', 'earned_ctc'], 'number'],
          [['attendancetype'], 'string', 'max' => 100],
          [['work_level', 'grade'], 'string', 'max' => 50],
          [['salary_structure'], 'string', 'max' => 255],
		  [['email_hash'], 'string', 'max' => 32],
		  [['priority'], 'string'],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels() {
      return [
          'id' => 'ID',
          'date' => 'Date',
          'empid' => 'Empid',
          'attendancetype' => 'Attendancetype',
          'designation' => 'Designation',
          'unit_id' => 'Unit',
          'department_id' => 'Department',
          'work_level' => 'Work Level',
          'grade' => 'Grade',
          'salary_structure' => 'Salary Structure',
          'earnedgross' => 'Earned Gross',
          'month' => 'Month',
          'paiddays' => 'Paiddays',
          'forced_lop' => 'Forced Lop',
          'paidallowance' => 'Paidallowance',
          'basic' => 'Basic',
          'hra' => 'HRA',
          'spl_allowance' => 'Spl. Allowance',
          'dearness_allowance' => 'Dearness Allowance',
          'conveyance_allowance' => 'Conveyance Allowance',
          'over_time' => 'Over Time',
          'arrear' => 'Arrear',
          'advance_arrear_tes' => 'Advance Arrear TES',
          'lta_earning' => 'LTA Earning',
          'medical_earning' => 'Medical Earning',
          'guaranted_benefit' => 'Guaranted Benefit',
          'holiday_pay' => 'Holiday Pay',
          'washing_allowance' => 'Washing Allowance',
          'dust_allowance' => 'Dust Allowance',
          'performance_pay' => 'Performance Pay',
		  'misc' => 'Miscellaneous',
          'other_allowance' => 'Other Allowance',
          'total_earning' => 'Total Earning',
          'pf' => 'PF',
          'insurance' => 'Insurance',
          'professional_tax' => 'Professional Tax',
          'esi' => 'ESI',
          'advance' => 'Advance',
          'tes' => 'TES',
          'mobile' => 'Mobile',
          'loan' => 'Loan',
          'rent' => 'Rent',
          'tds' => 'TDS',
          'lwf' => 'LWF',
          'other_deduction' => 'Other Deduction',
          'total_deduction' => 'Total Deduction',
          'net_amount' => 'Net Amount',
          'pf_employer_contribution' => 'PF Employer Contribution',
          'esi_employer_contribution' => 'ESI Employer Contribution',
          'pli_employer_contribution' => 'PLI Employer Contribution',
          'lta_employer_contribution' => 'LTA Employer Contribution',
          'med_employer_contribution' => 'Medical Employer Contribution',
          'earned_ctc' => 'Earned CTC',
		   'approval' => 'Approval',
      ];
   }

   public function getEmployee() {
      return $this->hasOne(EmpDetails::className(), ['id' => 'empid']);
   }

   public function getDesignations() {
      return $this->hasOne(Designation::className(), ['id' => 'designation']);
   }

   public function getUnits() {
      return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
   }
   	public function getDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'division_id']);
    }
	
   public function getDepartment() {
	   return $this->hasOne(Department::className(), ['id' => 'department_id']);
   }

   public function getStatutory() {
      return $this->hasOne(EmpStatutorydetails::className(), ['empid' => 'empid']);
   }

   public function getRemuneration() {
      return $this->hasOne(EmpRemunerationDetails::className(), ['empid' => 'empid']);
   }
    public function getBank() {
      return $this->hasOne(EmpBankdetails::className(), ['empid' => 'empid']);
   }
   public function getEmployeePersonalDetail()
    {
        return $this->hasOne(EmpPersonaldetails::className(), ['empid' => 'empid']);
    }

   public function PaidDaysEngg($m, $leave, $model) {

      $total_leave = 0;
      $balance_leave = 0;
      $balance_first_half = 0;
      $balance_second_half = 0;
      $loss_of_pay_day = 0;
      $lop_day = 0;

      if ($m > 3 && $m <= 9) {
         if ($model->remaining_leave_first_half > 0) {
            $lop_day = $model->remaining_leave_first_half - $leave;
            $total_leave = $model->leave_taken_first_half + $leave;
            $balance_leave = $model->eligible_first_half - $total_leave;
            $model->leave_taken_first_half = $total_leave;
            if ($balance_leave > 0)
               $model->remaining_leave_first_half = $balance_leave;
            else
               $model->remaining_leave_first_half = 0;
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $model->leave_taken_first_half + $leave;
            $model->leave_taken_first_half = $total_leave;
            $loss_of_pay_day = $leave;
         }
      } else if ($m > 9 && $m <= 12) {
         if ($model->remaining_leave_second_half > 0) {
            $total_leave = $model->leave_taken_second_half + $leave;
            if ($model->remaining_leave_first_half > 0) {
               $balance_first_half = $model->remaining_leave_first_half;
               $balance_second_half = ($model->eligible_second_half + $balance_first_half) - $total_leave;
               $model->remaining_leave_first_half = 0;
               $lop_day = $balance_second_half;
            } else {
               $balance_second_half = $model->eligible_second_half - $total_leave;
               $lop_day = $balance_second_half;
            }
            if ($balance_second_half > 0)
               $balance_second_half = $balance_second_half;
            else
               $balance_second_half = 0;
            $model->remaining_leave_second_half = $balance_second_half;
            $model->leave_taken_second_half = $total_leave;
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $Leave->leave_taken_second_half + $leave;
            $model->leave_taken_second_half = $total_leave;
            $loss_of_pay_day = $leave;
         }
      } else if ($m >= 1 && $m <= 3) {
         if ($model->remaining_leave_second_half > 0) {
            $total_leave = $model->leave_taken_second_half + $leave;
            if ($model->remaining_leave_first_half > 0) {
               $balance_first_half = $model->remaining_leave_first_half;
               $balance_second_half = ($model->eligible_second_half + $balance_first_half) - $total_leave;
               $model->remaining_leave_first_half = 0;
               $lop_day = $balance_second_half;
            } else {
               $balance_second_half = $model->eligible_second_half - $total_leave;
               $lop_day = $balance_second_half;
            }
            if ($balance_second_half > 0)
               $balance_second_half = $balance_second_half;
            else
               $balance_second_half = 0;
            $model->remaining_leave_second_half = $balance_second_half;
            $model->leave_taken_second_half = $total_leave;
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $total_leave = $Leave->leave_taken_second_half + $leave;
            $model->leave_taken_second_half = $total_leave;
            $loss_of_pay_day = $leave;
         }
      }
      return $loss_of_pay_day;
   }

   public function PaidDaysStaff($m, $leave, $model) {

      $total_leave = 0;
      $balance_first_quarter = 0;
      $balance_second_quarter = 0;
      $balance_third_quarter = 0;
      $balance_fourth_quarter = 0;
      $loss_of_pay_day = 0;
      $lop_day = 0;

      if ($m > 3 && $m <= 6) {
         if ($model->remaining_leave_first_quarter > 0) {
            $lop_day = $model->remaining_leave_first_quarter - $leave;
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $loss_of_pay_day = $leave;
         }
      } else if ($m > 6 && $m <= 9) {
         if ($model->remaining_leave_second_quarter > 0) {
            if ($model->remaining_leave_first_quarter > 0) {
               $balance_first_quarter = $model->remaining_leave_first_quarter;
               $lop_day = ($model->eligible_second_quarter + $balance_first_quarter) - $leave;
            } else {
               $lop_day = $model->eligible_second_quarter - $leave;
            }
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $loss_of_pay_day = $leave;
         }
      } else if ($m > 9 && $m <= 12) {
         if ($model->remaining_leave_third_quarter > 0) {
            if ($model->remaining_leave_second_quarter > 0) {
               $balance_second_quarter = $model->remaining_leave_second_quarter;
               $balance_third_quarter = ($model->eligible_third_quarter + $balance_second_quarter) - $leave;
               $lop_day = $balance_third_quarter;
            } else {
               $balance_third_quarter = $model->eligible_third_quarter - $leave;
               $lop_day = $balance_third_quarter;
            }
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $loss_of_pay_day = $leave;
         }
      } else if ($m >= 1 && $m <= 3) {
         if ($model->remaining_leave_fourth_quarter > 0) {
            if ($model->remaining_leave_third_quarter > 0) {
               $balance_third_quarter = $model->remaining_leave_third_quarter;
               $balance_fourth_quarter = ($model->eligible_fourth_quarter + $balance_third_quarter) - $leave;
               $lop_day = $balance_fourth_quarter;
            } else {
               $balance_fourth_quarter = $model->eligible_fourth_quarter - $leave;
               $lop_day = $balance_fourth_quarter;
            }
            if ($lop_day < 0)
               $loss_of_pay_day = abs($lop_day);
         } else {
            $loss_of_pay_day = $leave;
         }
      }
      return $loss_of_pay_day;
   }

}
