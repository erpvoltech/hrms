<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\EmpDetails;
use common\models\EmpSalary;
use common\models\EmpLeaveCounter;
use common\models\EmpPersonaldetails;
use common\models\EmpPromotion;
use common\models\EmpRemunerationDetails;
use app\models\EmpSalarystructure;
use app\models\EmpStaffPayScale;
use common\models\EmpLeaveStaff;
use common\models\EmpLeave;
use common\models\StatutoryRates;
use common\models\EmpStatutorydetails;
use common\models\SalaryMonth;

error_reporting(0);

class HRComponent extends Component {

   public function promotion() {
      $current_date = date('Y-m-d H:i:s');	 
      $Promotionmodel = EmpPromotion::find()->where('effectdate <= :current_date and flag=1', [':current_date' => $current_date])->all();
      foreach ($Promotionmodel as $promotion) {
		$model_month = SalaryMonth::find()->where(['month'=> $promotion->effectdate])->one();		
		if($model_month) {
	    if(empty($promotion->ss_to)){
			 $ss = $promotion->ss_from;
			 } else {
			 $ss = $promotion->ss_to;
			 }
		 if(empty($promotion->wl_to)){
			 $wl = $promotion->wl_from;
			 } else {
			 $wl = $promotion->wl_to;
			 }
		 if(empty($promotion->grade_to)){
			 $grade = $promotion->grade_from;
			 } else {
			 $grade = $promotion->grade_to;
			 }
			 
			 if(empty($promotion->gross_to)){
			 $gross = $promotion->gross_from;
			 } else {
			 $gross = $promotion->gross_to;
			 }
			 
			 if(empty($promotion->pli_to)){
			 $pli = $promotion->pli_from;
			 } else {
			 $pli = $promotion->pli_to;
			 }
	 
         $Remuneration = EmpRemunerationDetails::find()->where(['empid' => $promotion->empid])->one();
         $SalStructure = EmpSalarystructure::find()->where(['salarystructure' => $ss, 'worklevel' => $wl, 'grade' => $grade])->one();
         $payScale = EmpStaffPayScale::find()->where(['salarystructure' => $ss])->one();
         $Empmodel = EmpDetails::find()->where(['id' => $promotion->empid])->one();
		 $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
		 $statutory = EmpStatutorydetails::find()->where(['empid' => $Empmodel->id])->one();

		 if(!empty($promotion->designation_to)){
		  $Empmodel->designation_id = $promotion->designation_to;		
		 }
         if ($SalStructure) {
            $Remuneration->salary_structure = $ss;
            $Remuneration->work_level = $wl;
            $Remuneration->grade = $grade;
            $Remuneration->basic = $SalStructure->basic;
            $Remuneration->hra = $SalStructure->hra;
            $Remuneration->dearness_allowance = $SalStructure->dapermonth;            
            $Remuneration->other_allowance = $SalStructure->other_allowance;
			$Remuneration->pli = $pli;	
			$gross = $SalStructure->netsalary;
         } else if ($payScale) {
            $Remuneration->salary_structure = $ss;
            $Remuneration->work_level = $wl;
            $Remuneration->grade = $grade;
            $Remuneration->basic = round($gross * $payScale->basic);
            $basic = round($gross * $payScale->basic);
            $Remuneration->hra = round($gross * $payScale->hra);
            $Remuneration->dearness_allowance = round($gross * $payScale->dearness_allowance);
           // $Remuneration->splallowance = round($gross * $payScale->spl_allowance);
            $Remuneration->conveyance = round($payScale->conveyance_allowance);
            $Remuneration->lta = round($basic * $payScale->lta);
            $Remuneration->medical = round($basic * $payScale->medical);
            $Remuneration->other_allowance = round(($gross - ($basic + $Remuneration->hra + $Remuneration->dearness_allowance + $Remuneration->splallowance + $Remuneration->lta + $Remuneration->medical)) - $Remuneration->conveyance);
			$Remuneration->pli = $pli;	
         } else if($ss =='Consolidated pay'){
			$Remuneration->basic = $gross;
		 } else if($ss =='Contract'){
		    $Remuneration->salary_structure = $ss;
			$Remuneration->work_level = $wl;
            $Remuneration->grade = $grade;
			$Remuneration->pli = $pli;
			$gross = $Remuneration->gross_salary;
		}
         $Remuneration->gross_salary = $gross;
		 if($ss =='Consolidated pay'){
		  $statutory_rate_pf = $gross;
		 } else {
		  $statutory_rate_pf = $gross - $Remuneration->hra;
		 }
		 $statutory_rate_esi = $gross;
		 
		 if ($Remuneration->pf_applicablity == 'Yes') {
                  if ($Remuneration->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {                        
                        $Remuneration->employer_pf_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {                       
                        if ($statutory->pmrpybeneficiary == 'Yes') {
							$Remuneration->employer_pf_contribution = 0;
                        } else {
                           $Remuneration->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     }
                  } else {                     
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $Remuneration->pf_employer_contribution = 0;
                        } else {
                           $Remuneration->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     } else {
                        $Remuneration->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                     }
                  }
               } else {
                  $Remuneration->employer_pf_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {                   
                     $Remuneration->employer_esi_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {                   
                     $Remuneration->employer_esi_contribution = 0;
                  }
               } else {                 
                  $Remuneration->employer_esi_contribution = 0;
               }	 
		
				 $Remuneration->employer_pli_contribution = round($Remuneration->basic * ($Remuneration->pli / 100));

            if ($ss == 'Manager' || $ss == 'Assistant Manager' || $ss == 'Sr. Engineer - I' || $ss == 'Sr. Engineer - II') {
               $Remuneration->employer_lta_contribution = round($Remuneration->basic * 0.0833);
               $Remuneration->employer_medical_contribution = round($Remuneration->basic * 0.0833);
            } else {
               $Remuneration->employer_lta_contribution = 0;
               $Remuneration->employer_medical_contribution = 0;
            }
		 
		  $Remuneration->ctc = ($gross + $Remuneration->employer_pf_contribution + $Remuneration->employer_esi_contribution + $Remuneration->employer_pli_contribution + $Remuneration->employer_lta_contribution + $Remuneration->employer_medical_contribution);
		 
		  if($promotion->type == 3){
			 $Empmodel->confirmation_date = $promotion->effectdate;
			 } else {
			 $Empmodel->recentdop = $promotion->effectdate;
			 }
			 
         $ProModel = EmpPromotion::findOne($promotion->id);
         $ProModel->flag = 2;
         $ProModel->save();
		 $Empmodel->save();
         $Remuneration->save();
      }
   }
   }

   public function leave_assign() {
      $current_date = date('Y-m-d H:i:s');
      $currentYear = date('Y', strtotime($current_date));
      $currentMonth = date('m', strtotime($current_date));

      $Employee = EmpDetails::find()->where('confirmation_date <= :current_date and leave_eligible_status=0', [':current_date' => $current_date])->all();
      foreach ($Employee as $Emp) {
         $year = date('Y', strtotime($Emp->confirmation_date));
         $month = date('m', strtotime($Emp->confirmation_date));
         $Remuneration = EmpRemunerationDetails::find()->where(['empid' => $Emp->id])->one();
         $SalStructure = EmpSalarystructure::find()->where(['salarystructure' => $Remuneration->salary_structure])->one();
         $payScale = EmpStaffPayScale::find()->where(['salarystructure' => $Remuneration->salary_structure])->one();
         if ($SalStructure) {
            $siteEng = new EmpLeave();
            $siteEng->empid = $Emp->id;

            if ($month >= 4 && $month <= 9 && $year == $currentYear) {
               $h1 = (9 - $month) + 1;
               $siteEng->eligible_first_half = ($h1 * 2.5);
               $siteEng->remaining_leave_first_half = ($h1 * 2.5);
               $siteEng->eligible_second_half = 15;
               $siteEng->remaining_leave_second_half = 15;
            } else {
               if ($month >= 10 && $month <= 12 && $year == $currentYear) {
                  $hq1 = (12 - $month) + 1;
                  $siteEng->eligible_second_half = (($hq1 + 3) * 2.5);
                  $siteEng->remaining_leave_second_half = (($hq1 + 3) * 2.5);
               } else if ($month >= 1 && $month <= 3 && $year == $currentYear && $currentMonth <= 3) {
                  $hq2 = (3 - $month) + 1;
                  $siteEng->eligible_second_half = $hq2 * 2.5;
                  $siteEng->remaining_leave_second_half = $hq2 * 2.5;
               }
              /* $siteEng->eligible_first_half = 15;
               $siteEng->remaining_leave_first_half = 15;
               $siteEng->eligible_second_half = 15;
               $siteEng->remaining_leave_second_half = 15; */
            }
            $siteEng->save(false);
         } else if ($payScale) {
            $offStaff = new EmpLeaveStaff();
            $offStaff->empid = $Emp->id;
            if ($month >= 1 && $month <= 3 && $year == $currentYear && $currentMonth <= 3) {
               $q4 = (3 - $month) + 1;
               $offStaff->eligible_fourth_quarter = $q4 * 2.5;
               $offStaff->remaining_leave_fourth_quarter = $q4 * 2.5;
            } else if ($month >= 4 && $month <= 6 && $year == $currentYear) {
               $q1 = (6 - $month) + 1;
               $offStaff->eligible_first_quarter = $q1 * 2.5;
               $offStaff->remaining_leave_first_quarter = $q1 * 2.5;
               $offStaff->eligible_second_quarter = 7.5;
               $offStaff->remaining_leave_second_quarter = 7.5;
               $offStaff->eligible_third_quarter = 7.5;
               $offStaff->remaining_leave_third_quarter = 7.5;
               $offStaff->eligible_fourth_quarter = 7.5;
               $offStaff->remaining_leave_fourth_quarter = 7.5;
            } else if ($month >= 7 && $month <= 9 && $year == $currentYear) {
               $q2 = (9 - $month) + 1;
               $offStaff->eligible_second_quarter = $q2 * 2.5;
               $offStaff->remaining_leave_second_quarter = $q2 * 2.5;
               $offStaff->eligible_third_quarter = 7.5;
               $offStaff->remaining_leave_third_quarter = 7.5;
               $offStaff->eligible_fourth_quarter = 7.5;
               $offStaff->remaining_leave_fourth_quarter = 7.5;
            } else if ($month >= 10 && $month <= 12 && $year == $currentYear) {
               $q3 = (12 - $month) + 1;
               $offStaff->eligible_third_quarter = $q3 * 2.5;
               $offStaff->remaining_leave_third_quarter = $q3 * 2.5;
               $offStaff->eligible_fourth_quarter = 7.5;
               $offStaff->remaining_leave_fourth_quarter = 7.5;
            }/* else {
               $offStaff->eligible_first_quarter = 7.5;
               $offStaff->remaining_leave_first_quarter = 7.5;
               $offStaff->eligible_second_quarter = 7.5;
               $offStaff->remaining_leave_second_quarter = 7.5;
               $offStaff->eligible_third_quarter = 7.5;
               $offStaff->remaining_leave_third_quarter = 7.5;
               $offStaff->eligible_fourth_quarter = 7.5;
               $offStaff->remaining_leave_fourth_quarter = 7.5;
            } */
            $offStaff->save(false);
         }
         $Empmodel = EmpDetails::findOne($Emp->id);
         $Empmodel->leave_eligible_status = 1;
         $Empmodel->save(false);
      }
   }

}

?>
