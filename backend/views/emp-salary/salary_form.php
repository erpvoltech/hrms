<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\EmpSalarystructure;
use common\models\EmpLeave;
use common\models\EmpLeaveStaff;
use common\models\EmpDetails;
use common\models\EmpSalary;
use app\models\EmpStatutorydetails;
use app\models\EmpStaffPayScale;
use common\models\EmpLeaveCounter;
use common\models\EmpRemunerationDetails;
use common\models\StatutoryRates;
use yii\db\Expression;

$ModelEmp = EmpDetails::find()->where(['id' => $id])->one();
$pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();

if (Yii::$app->getRequest()->getQueryParam('absent'))
   $absent = Yii::$app->getRequest()->getQueryParam('absent');
else
   $absent = 0;

if (Yii::$app->getRequest()->getQueryParam('lop'))
   $lop = Yii::$app->getRequest()->getQueryParam('lop');
else
   $lop = 0;

if (Yii::$app->getRequest()->getQueryParam('allowance_paid'))
   $allowance_paid = Yii::$app->getRequest()->getQueryParam('allowance_paid');
else
   $allowance_paid = '';

if (Yii::$app->getRequest()->getQueryParam('statutory_rate'))
   $statutory_rate = Yii::$app->getRequest()->getQueryParam('statutory_rate');
else
   $statutory_rate = '';


if (Yii::$app->getRequest()->getQueryParam('month'))
   $month = Yii::$app->getRequest()->getQueryParam('month');
else
   $month = '';

$workstatus = 0;

$remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $id])->one();

$m = date("m", strtotime('01-' . $month));
$y = date("Y", strtotime('01-' . $month));
$maxDays = cal_days_in_month(CAL_GREGORIAN, $m, $y); // maximum days for month

$relievemonth = date("m", strtotime($ModelEmp->dateofleaving));

if ($ModelEmp->status == 'Paid and Relieved' && $m == $relievemonth) {
   $relievedate = strtotime($ModelEmp->dateofleaving);
   $your_date = strtotime('01-' . $month);
   $datediff = $relievedate - $your_date;
   $workingDays = round($datediff / (60 * 60 * 24)) + 1; // maximum days for month	
   $workstatus = 1;
} else if ($ModelEmp->status == 'Relieved') {
   $workingDays = 0;
   $workstatus = 1;
}

$basic = 0;
$hra = 0;
$other_allowance = 0;
$provident_fund = 0;
$dearness_allowance = 0;
$spl_allowance = 0;
$conveyance_allowance = 0;
$pli_earning = 0;
$lta_earning = 0;
$medical_earning = 0;
$professional_tax = 0;
$employee_state_insurance = 0;
$grossamount = 0;
$max_statutory_rate = 0;
$tes = 0;
$avance_tes = 0;
$gb = 0;
$dust = 0;
$perpay = 0;
$workdays = 0;

$PayScale = EmpStaffPayScale::find()
        ->where(['salarystructure' => $remunerationmodel->salary_structure])
        ->one();

$Salarystructure = EmpSalarystructure::find()
        ->where(['salarystructure' => $remunerationmodel->salary_structure])
        ->one();


/* * *************************************** Office Staff Salary Calculation **************************** */
if ($PayScale) {
   $LeaveStaff = EmpLeaveStaff::find()
           ->where(['empid' => $ModelEmp->id])
           ->one();

   if ($LeaveStaff)   // leave caluculation
      $loss_of_pay_days = $model->PaidDaysStaff($m, $absent, $LeaveStaff);
   else
      $loss_of_pay_days = $absent;

   if ($workstatus == 1) {
      $present_days = $workingDays - ($loss_of_pay_days + $lop);
   } else {
      $present_days = $maxDays - ($loss_of_pay_days + $lop);
   }

   $grossamount = round(($remunerationmodel->gross_salary / $maxDays) * $present_days);

   $basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
   $hra = round(($remunerationmodel->hra / $maxDays) * $present_days);
   $dearness_allowance = round(($remunerationmodel->dearness_allowance / $maxDays) * $present_days);
   $spl_allowance = round(($remunerationmodel->splallowance / $maxDays) * $present_days);
   $conveyance_allowance = round(($remunerationmodel->conveyance / $maxDays) * $present_days);
   $lta_earning = round(($remunerationmodel->lta / $maxDays) * $present_days);
   $medical_earning = round(($remunerationmodel->medical / $maxDays) * $present_days);
   $other_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance + $lta_earning + $medical_earning));

   if ($remunerationmodel->pf_applicablity == 'Yes') {
      if ($remunerationmodel->restrict_pf == 'Yes') {
         if (($grossamount * 0.8) > 15000)
            $provident_fund = 15000 * ($pf_esi_rates->epf_ac_1_ee / 100);
         else
            $provident_fund = ($grossamount * 0.8) * ($pf_esi_rates->epf_ac_1_ee / 100);
      } else {
         $provident_fund = ($grossamount * 0.8) * ($pf_esi_rates->epf_ac_1_ee / 100);
      }
   }

   if ($remunerationmodel->esi_applicability == 'Yes') {
      if ($remunerationmodel->gross_salary <= 21000) {
         $employee_state_insurance = ceil(($grossamount * 0.8) * ($pf_esi_rates->esi_ee / 100));
      }
   }
   $max_statutory_rate = ($grossamount * 0.8);

   if ($remunerationmodel->gross_salary > 12500) {    // PT calculatin
      $professional_tax = 196;
   } else if ($remunerationmodel->gross_salary <= 12500 && $remunerationmodel->gross_salary > 10000) {
      $professional_tax = 147;
   } else if ($remunerationmodel->gross_salary <= 10000 && $remunerationmodel->gross_salary > 7500) {
      $professional_tax = 98;
   } else if ($remunerationmodel->gross_salary <= 7500 && $remunerationmodel->gross_salary > 5000) {
      $professional_tax = 49;
   } else if ($remunerationmodel->gross_salary <= 5000 && $remunerationmodel->gross_salary > 3500) {
      $professional_tax = 20;
   } else {
      $professional_tax = 0;
   }
} else { /* * ***************************** Site Engg Salary Calculation ***************** */

   if ($remunerationmodel->attendance_type != 'Contract' && $Salarystructure) {
      $Leave = EmpLeave::find()
              ->where(['empid' => $ModelEmp->id])
              ->one();

      if ($Leave)
         $loss_of_pay_days = $model->PaidDaysEngg($m, $absent, $Leave);
      else
         $loss_of_pay_days = $absent;

      if ($workstatus == 1) {
         $present_days = $workingDays - ($loss_of_pay_days + $lop);
         $day_count = $workingDays;
      } else {
         $present_days = $maxDays - ($loss_of_pay_days + $lop);
         $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);
      }
      if ($present_days > 30) {
         $dadays = 30;
      } else {
         $dadays = $present_days;
      }

      //loop through all days
      for ($i = 1; $i <= $day_count; $i++) {
         $date = $y . '/' . $m . '/' . $i; //format date
         $get_name = date('l', strtotime($date)); //get week day
         $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
         //if not a weekend add day to array
         if ($day_name != 'Sun') {
            $workdays += 1;
         }
      }
      $present_days_for_statutory = $workdays - ($loss_of_pay_days + $lop);

      $basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
      $hra = round(($remunerationmodel->hra / $maxDays) * $present_days);
      $dearness_allowance = round(($remunerationmodel->dearness_allowance / 30) * $dadays);
      $tes = $dearness_allowance - $allowance_paid;
      if ($tes > 0) {
         $tes = $tes;
         $avance_tes = 0;
      } else {
         $avance_tes = abs($tes);
         $tes = 0;
      }

      $spl_allowance = round(($remunerationmodel->splallowance / $maxDays) * $present_days);

      $earned_statutory_rate = $statutory_rate * $present_days_for_statutory;
      $earned_gross = ($remunerationmodel->gross_salary / $maxDays) * $present_days;
      $max_statutory_rate = max($earned_statutory_rate, ($earned_gross - $hra));
      $grossamount = $earned_gross;
      if ($remunerationmodel->pf_applicablity == 'Yes') {
         if ($remunerationmodel->restrict_pf == 'Yes') {
            if ($max_statutory_rate > 15000)
               $provident_fund = 15000 * ($pf_esi_rates->epf_ac_1_ee / 100);
            else
               $provident_fund = $max_statutory_rate * ($pf_esi_rates->epf_ac_1_ee / 100);
         } else {
            $provident_fund = $max_statutory_rate * ($pf_esi_rates->epf_ac_1_ee / 100);
         }
      }
      if ($remunerationmodel->esi_applicability == 'Yes') {
         if ($remunerationmodel->gross_salary <= 21000) {
            $employee_state_insurance = ceil($max_statutory_rate * ($pf_esi_rates->esi_ee / 100));
         } else {
            $employee_state_insurance = 0;
         }
      }
   } else if ($remunerationmodel->salary_structure == 'Consolidated pay') {
      if ($workstatus == 1) {
         $present_days = $workingDays - ($absent + $lop);
      } else {
         $present_days = $maxDays - ($absent + $lop);
      }

      $earned_gross = ($remunerationmodel->gross_salary / $maxDays) * $present_days;

      $basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
      $other_allowance = round(($remunerationmodel->other_allowance / $maxDays) * $present_days);
      $grossamount = $earned_gross;
      if ($remunerationmodel->gross_salary > 12500) {
         $professional_tax = 196;
      } else if ($remunerationmodel->gross_salary <= 12500 && $remunerationmodel->gross_salary > 10000) {
         $professional_tax = 147;
      } else if ($remunerationmodel->gross_salary <= 10000 && $remunerationmodel->gross_salary > 7500) {
         $professional_tax = 98;
      } else if ($remunerationmodel->gross_salary <= 7500 && $remunerationmodel->gross_salary > 5000) {
         $professional_tax = 49;
      } else if ($remunerationmodel->gross_salary <= 5000 && $remunerationmodel->gross_salary > 3500) {
         $professional_tax = 20;
      } else {
         $professional_tax = 0;
      }


      if ($remunerationmodel->pf_applicablity == 'Yes') {
         if ($remunerationmodel->restrict_pf == 'Yes') {
            if ($earned_gross > 15000)
               $provident_fund = 15000 * ($pf_esi_rates->epf_ac_1_ee / 100);
            else
               $provident_fund = $earned_gross * ($pf_esi_rates->epf_ac_1_ee / 100);
         } else {
            $provident_fund = $earned_gross * ($pf_esi_rates->epf_ac_1_ee / 100);
         }
      }

      if ($remunerationmodel->esi_applicability == 'Yes') {
         if ($remunerationmodel->gross_salary <= 21000) {
            $employee_state_insurance = ceil($earned_gross * ($pf_esi_rates->esi_ee / 100));
         } else {
            $employee_state_insurance = 0;
         }
      }
      $max_statutory_rate = $earned_gross;
   } else if ($remunerationmodel->attendance_type == 'Contract') {

      if ($workstatus == 1) {
         $day_count = $workingDays;
      } else {
         $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);
      }


      //loop through all days
      for ($i = 1; $i <= $day_count; $i++) {
         $date = $y . '/' . $m . '/' . $i; //format date
         $get_name = date('l', strtotime($date)); //get week day
         $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
         //if not a weekend add day to array
         if ($day_name != 'Sun') {
            $workdays += 1;
         }
      }

      $joinYear = date('Y', strtotime($ModelEmp->doj));
      $joinMonth = date('m', strtotime($ModelEmp->doj));
      $diff_year = $y - $joinYear;
      if ($diff_year == 0) {
         if ($joinMonth < 4) {
            if ($m < 4) {
               $num_month = 9 + $m;
            } else {
               $num_month = $m - 3;
            }
         } else {
            $diff_month = $m - $joinMonth;
            if ($diff_month == 0) {
               $num_month = 1;
            } else {
               $num_month = $diff_month;
            }
         }
      } else if ($diff_year > 1) {
         if ($m < 4) {
            $num_month = 9 + $m;
         } else {
            $num_month = $m - 3;
         }
      } else if ($diff_year == 1) {
         if ($joinMonth < 4 || $m < 4) {
            $num_month = 9 + $m;
         } else if ($joinMonth > 3 || $m < 4) {
            $diffMonth = 12 - $joinMonth;
            $num_month = $diffMonth + $m;
         } else if ($m > 3) {
            $num_month = $m - 3;
         }
      }

      if ($m < 4) {
         $year = $y - 1;
         $start = date('Y-m-d', strtotime('01-04-' . $year));
      } else {
         $start = date('Y-m-d', strtotime('01-04-' . $y));
      }
      $end = date('Y-m-d', strtotime('01-' . $month));

      $command = Yii::$app->db->createCommand("SELECT sum(leave_days) FROM emp_leave_counter where empid =" . $ModelEmp->id . " AND month  BETWEEN '$start' AND '$end'");
      $sumLeave = $command->queryScalar();
      $remaing_leave = ($num_month * 2) - $sumLeave;
      $balance_leave = $remaing_leave - $absent;

      if ($balance_leave >= 0) {
         $present_days = $workdays - ($absent + $lop);
      } else {
         $present_days = $workdays - (abs($balance_leave) + $lop);
      }

      $basic = round(($remunerationmodel->basic / $workdays) * $present_days);
      $hra = round(($remunerationmodel->hra / $workdays) * $present_days);
      $dearness_allowance = round(($remunerationmodel->dearness_allowance / $workdays) * $present_days);
      $tes = $dearness_allowance - $allowance_paid;
      if ($tes > 0) {
         $tes = $tes;
         $avance_tes = 0;
      } else {
         $avance_tes = abs($tes);
         $tes = 0;
      }

      $spl_allowance = round(($remunerationmodel->splallowance / $workdays) * $present_days);
      $gb = round(($remunerationmodel->guaranteed_benefit / $workdays) * $present_days);
      $dust = round(($remunerationmodel->dust_allowance / $workdays) * $present_days);
      $perpay = round(($remunerationmodel->personpay / $workdays) * $present_days);
      $other_allowance = round(($remunerationmodel->other_allowance / $workdays) * $present_days);

      $earned_statutory_rate = $model->statutory_rate * $present_days;
      $earned_gross = ($remunerationmodel->gross_salary / $workdays) * $present_days;
      $max_statutory_rate = max($earned_statutory_rate, ($earned_gross - $hra));
      $grossamount = $earned_gross;

      if ($remunerationmodel->pf_applicablity == 'Yes') {
         if ($remunerationmodel->restrict_pf == 'Yes') {
            if ($max_statutory_rate > 15000)
               $provident_fund = 15000 * ($pf_esi_rates->epf_ac_1_ee / 100);
            else
               $provident_fund = $max_statutory_rate * ($pf_esi_rates->epf_ac_1_ee / 100);
         } else {
            $provident_fund = $max_statutory_rate * ($pf_esi_rates->epf_ac_1_ee / 100);
         }
      }
      if ($remunerationmodel->esi_applicability == 'Yes') {
         if ($earned_statutory_rate <= 21000) {
            $employee_state_insurance = ceil($max_statutory_rate * ($pf_esi_rates->esi_ee / 100));
         } else {
            $employee_state_insurance = 0;
         }
      }
   }
}
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
<?php echo $this->render('reload', ['model' => $model, 'id' => $id, 'allowance_paid' => $allowance_paid, 'statutory_rate' => $statutory_rate, 'absent' => $absent, 'month' => $month, 'lop' => $lop]); ?>

<div class="emp-salary-form">
   <?php
   $form = ActiveForm::begin([
               'id' => 'form-signup',
               'layout' => 'horizontal',
   ]);
   ?>

   <style>
      .icon_text_feild .col-sm-6{position:relative;}
      .icon_text_feild .col-sm-6:before{content: "\f156";display: inline-block; font: normal normal normal 14px/1 FontAwesome;
                                        font-size: inherit;   text-rendering: auto;   -webkit-font-smoothing: antialiased;position: absolute;
                                        top: 7px;   left: 23px;color: #ccc;}
      .icon_text_feild .col-sm-6 .form-control{padding-left:20px;}
   </style>

   <div class="panel panel-default">
      <div class="panel-heading text-center"> Create Employee salary</div>
      <div class="panel-body">


         <div class="row">
            <div class="col-md-4">  
               <strong style="color:#007370;font-size:16px;"> Name :</strong> <?= $ModelEmp->empname ?> </div> <div class="col-md-4">  
               <strong style="color:#007370;font-size:16px;">ecode :</strong> <?= $ModelEmp->empcode ?></div> <div class="col-md-4">  
               <strong style="color:#007370;font-size:16px;">Salary Structure :</strong> <?= $remunerationmodel->salary_structure ?>
            </div></div>
      </div>   
      <div class="row">
         <div class="col-md-1">            
            <?= $form->field($model, 'absent')->hiddenInput(['value' => $absent])->label(false) ?> </div><div class="col-md-1">
            <?= $form->field($model, 'earnedgross')->hiddenInput(['value' => $grossamount])->label(false) ?> </div><div class="col-md-1">
            <?= $form->field($model, 'lop')->hiddenInput(['value' => $lop])->label(false) ?> </div><div class="col-md-1">
            <?= $form->field($model, 'allowance_paid')->hiddenInput(['value' => $allowance_paid])->label(false) ?> </div><div class="col-md-1">	 
            <?= $form->field($model, 'netsalary')->hiddenInput(['value' => $remunerationmodel->gross_salary])->label(false) ?> </div><div class="col-md-1">
            <?= $form->field($model, 'statutory_rate_esi')->hiddenInput(['value' => $max_statutory_rate])->label(false) ?></div> <div class="col-md-1">         
            <?= $form->field($model, 'esirestric')->hiddenInput(['value' => $remunerationmodel->esi_applicability])->label(false) ?> </div>
         <?= $form->field($model, 'statutoryrate')->hiddenInput(['value' => $statutory_rate])->label(false) ?> </div>
   </div>

   <div class="row">
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'month')->textInput(['value' => $month, 'readOnly' => true]) ?> 
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'paiddays')->textInput(['value' => $present_days, 'readOnly' => true]) ?>
      </div>
      <div class="form-group icon_text_feild col-lg-4 ">
         <?= $form->field($model, 'basic')->textInput(['value' => $basic, 'readOnly' => true]) ?>
      </div>
   </div>
   <div class="row">        
      <div class="form-group icon_text_feild col-lg-4 ">
         <?= $form->field($model, 'hra')->textInput(['value' => $hra, 'readOnly' => true]) ?>
      </div>
      <div class="form-group icon_text_feild col-lg-4 ">
         <?= $form->field($model, 'spl_allowance')->textInput(['value' => $spl_allowance, 'readOnly' => true]) ?>
      </div>

      <div class="form-group icon_text_feild col-lg-4 ">
         <?= $form->field($model, 'dearness_allowance')->textInput(['value' => $dearness_allowance, 'readOnly' => true]) ?>
      </div>
   </div>
   <div class="row">       
      <div class="form-group icon_text_feild col-lg-4 ">
         <?= $form->field($model, 'conveyance_allowance')->textInput(['value' => $conveyance_allowance, 'readOnly' => true]) ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'holiday_pay') ?>
      </div>

      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'over_time')->textInput() ?>
      </div>
   </div>
   <div class="row"> 
      <div class="form-group col-lg-4 " >
         <?= $form->field($model, 'arrear')->textInput() ?>
      </div>  
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'advance_arrear_tes')->textInput(['value' => $avance_tes, 'readOnly' => true]) ?>
      </div>

      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'lta_earning')->textInput(['value' => $lta_earning, 'readOnly' => true]) ?>
      </div>
   </div>     
   <div class="row">
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'medical_earning')->textInput(['value' => $medical_earning, 'readOnly' => true]) ?>
      </div>

      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'guaranted_benefit')->textInput()->textInput(['value' => $gb]) ?>
      </div> 

      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'washing_allowance')->textInput() ?>		
      </div>
   </div>
   <div class="row">

      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'dust_allowance')->textInput(['value' => $dust]) ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'performance_pay')->textInput(['value' => $perpay]) ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'other_allowance')->textInput(['value' => $other_allowance]) ?>
      </div>
   </div>

   <!----------------------------- Deductions---------------------------->
   <div class="row">
      <div class="col-lg-4 "></div>
      <div class="form-group col-lg-8 ">
         <h3><label class="form-group"  style="color:#007370"> Deductions</label></h3>
      </div>	
   </div>
   <div class="row">
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'pf')->textInput(['value' => $provident_fund, 'readOnly' => true]) ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'insurance')->textInput() ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'professional_tax')->textInput(['value' => $professional_tax]) ?>
      </div>
   </div>
   <div class="row">
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'esi')->textInput(['value' => $employee_state_insurance, 'readOnly' => true]) ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'advance')->textInput() ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'tes')->textInput(['value' => $tes, 'readOnly' => true]) ?>
      </div>
   </div>
   <?php /*
     <div class="row">
     <div class="form-group col-lg-4 ">
     <?= $form->field($model, 'pli_deduction')->textInput() ?>
     </div>
     <div class="form-group col-lg-4 ">
     <?= $form->field($model, 'lta_deduction')->textInput() ?>
     </div>
     <div class="form-group col-lg-4 ">
     <?= $form->field($model, 'medical_deduction')->textInput() ?>
     </div>
     </div> */ ?>
   <div class="row">
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'mobile')->textInput() ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'loan')->textInput() ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'rent')->textInput() ?>
      </div>
   </div>
   <div class="row">
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'tds')->textInput() ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'lwf')->textInput() ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'other_deduction')->textInput() ?>
      </div>
   </div>
   <div class="row">
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'total_earning')->textInput(['readOnly' => true]) ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'total_deduction')->textInput(['readOnly' => true]) ?>
      </div>
      <div class="form-group col-lg-4 ">
         <?= $form->field($model, 'net_amount')->textInput(['readOnly' => true]) ?>
      </div>	
   </div> 
   <div class="col-md-12 form-group">
      <?= Html::submitButton('Save', ['class' => 'btn-xs btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>
</div></div>
<?php
$script = <<< JS

      var basic = $('#empsalary-basic').val();
	var hra = $('#empsalary-hra').val();
	var spl_allowance = $('#empsalary-spl_allowance').val();
	var dearness_allowance = $('#empsalary-dearness_allowance').val();
	var conveyance_allowance = $('#empsalary-conveyance_allowance').val();
	var over_time = $('#empsalary-over_time').val();
	var arrear = $('#empsalary-arrear').val();
	var advance_arrear_tes = $('#empsalary-advance_arrear_tes').val();	
	var lta_earning = $('#empsalary-lta_earning').val();
	var medical_earning = $('#empsalary-medical_earning').val();
	var guaranted_benefit = $('#empsalary-guaranted_benefit').val();
	var holiday_pay = $('#empsalary-holiday_pay').val();
	var washing_allowance = $('#empsalary-washing_allowance').val();
	var dust_allowance = $('#empsalary-dust_allowance').val();
	var performance_pay = $('#empsalary-performance_pay').val();
	var other_allowance = $('#empsalary-other_allowance').val();
	
	var pf = $('#empsalary-pf').val();
	var insurance = $('#empsalary-insurance').val();
	var professional_tax = $('#empsalary-professional_tax').val();
	var esi = $('#empsalary-esi').val();
	var advance = $('#empsalary-advance').val();
	var tes = $('#empsalary-tes').val();	
	var lta = $('#empsalary-lta_deduction').val();
	var medical = $('#empsalary-medical_deduction').val();
	var mobile = $('#empsalary-mobile').val();
	var loan = $('#empsalary-loan').val();
	var rent = $('#empsalary-rent').val();
	var tds = $('#empsalary-tds').val();
	var lwf = $('#empsalary-lwf').val();
	var other_deduction = $('#empsalary-other_deduction').val();
	
	var totalearning = +basic + +hra + +spl_allowance + +dearness_allowance + +conveyance_allowance + +over_time + +arrear + +advance_arrear_tes + +lta_earning + +medical_earning + +guaranted_benefit + +holiday_pay + +washing_allowance + +dust_allowance + +performance_pay + +other_allowance;
	
	var totaldeduction = +pf + +insurance + +professional_tax + +esi + +advance + +tes +  +mobile + +loan + +rent + +tds + +lwf + +other_deduction;
	
	var netpayable = +totalearning - +totaldeduction;
	
	$('#empsalary-total_earning').val(totalearning);
	$('#empsalary-total_deduction').val(totaldeduction);
	$('#empsalary-net_amount').val(netpayable); 
   
     
	 $('#empsalary-over_time').keyup(function(event){
	 var overtime = $('#empsalary-over_time').val();
	 var statu_esi = $('#empsalary-statutory_rate_esi').val();	
	 var esirestric = $('#empsalary-esirestric').val();
	 var netsalary = $('#empsalary-netsalary').val();
	 var esivalue = +overtime + +statu_esi;
		if(esirestric == 'Yes'){
			if(netsalary <= 21000) {
				$('#empsalary-esi').val(Math.ceil(esivalue  * 0.0175));
			} else {
				$('#empsalary-esi').val(''); 
			}
		}
	});
	  
    $('#empsalary-basic,#empsalary-hra,#empsalary-spl_allowance,#empsalary-dearness_allowance,#empsalary-conveyance_allowance,#empsalary-over_time,#empsalary-arrear,#empsalary-advance_arrear_tes,#empsalary-pli_earning,#empsalary-lta_earning,#empsalary-medical_earning,#empsalary-guaranted_benefit,#empsalary-holiday_pay,#empsalary-washing_allowance,#empsalary-dust_allowance,#empsalary-performance_pay,#empsalary-other_allowance,#empsalary-pf,#empsalary-insurance,#empsalary-professional_tax,#empsalary-esi,#empsalary-advance,#empsalary-tes,#empsalary-pli_deduction,#empsalary-lta_deduction,#empsalary-medical_deduction,#empsalary-mobile,#empsalary-loan,#empsalary-rent,#empsalary-tds,#empsalary-lwf,#empsalary-other_deduction').keyup(function(event){
	
	var basic = $('#empsalary-basic').val();
	var hra = $('#empsalary-hra').val();
	var spl_allowance = $('#empsalary-spl_allowance').val();
	var dearness_allowance = $('#empsalary-dearness_allowance').val();
	var conveyance_allowance = $('#empsalary-conveyance_allowance').val();
	var over_time = $('#empsalary-over_time').val();
	var arrear = $('#empsalary-arrear').val();
	var advance_arrear_tes = $('#empsalary-advance_arrear_tes').val();	
	var lta_earning = $('#empsalary-lta_earning').val();
	var medical_earning = $('#empsalary-medical_earning').val();
	var guaranted_benefit = $('#empsalary-guaranted_benefit').val();
	var holiday_pay = $('#empsalary-holiday_pay').val();
	var washing_allowance = $('#empsalary-washing_allowance').val();
	var dust_allowance = $('#empsalary-dust_allowance').val();
	var performance_pay = $('#empsalary-performance_pay').val();
	var other_allowance = $('#empsalary-other_allowance').val();
	
	var pf = $('#empsalary-pf').val();
	var insurance = $('#empsalary-insurance').val();
	var professional_tax = $('#empsalary-professional_tax').val();
	var esi = $('#empsalary-esi').val();
	var advance = $('#empsalary-advance').val();
	var tes = $('#empsalary-tes').val();
	
	var mobile = $('#empsalary-mobile').val();
	var loan = $('#empsalary-loan').val();
	var rent = $('#empsalary-rent').val();
	var tds = $('#empsalary-tds').val();
	var lwf = $('#empsalary-lwf').val();
	var other_deduction = $('#empsalary-other_deduction').val();
	
	var totalearning = +basic + +hra + +spl_allowance + +dearness_allowance + +conveyance_allowance + +over_time + +arrear + +advance_arrear_tes + +lta_earning + +medical_earning + +guaranted_benefit + +holiday_pay + +washing_allowance + +dust_allowance + +performance_pay + +other_allowance;
	
	var totaldeduction = +pf + +insurance + +professional_tax + +esi + +advance + +tes + +mobile + +loan + +rent + +tds + +lwf + +other_deduction;
	
	var netpayable = +totalearning - +totaldeduction;
	
	 $('#empsalary-total_earning').val(totalearning);
	$('#empsalary-total_deduction').val(totaldeduction);
	$('#empsalary-net_amount').val(netpayable); 
	});
    
	/* $('#empsalary-attendancetype').change(function(event){ 
	   var workType = $('#empsalary-attendancetype').val();
	    if(workType == 'Consolidated pay'){ 
			$('#empsalary-basic').val('');
			$('#empsalary-hra').val('');
			$('#empsalary-spl_allowance').val('');
			$('#empsalary-dearness_allowance').val('');
		} 
	});	
	
	 $('#empsalary-paiddays').keyup(function(event){
	   var absentdays = $('#empsalary-paiddays').val(); 
	   var months = $('#empsalary-month').val();
	   var employee = $('#empsalary-empid').val();	 
	   var m = months.split('-')[0];
	   var y = months.split('-')[1];
	  
            $.ajax({
                type: "POST",
                url: 'ajax',
                data: {absent: absentdays, month: months, empid: employee},
                success: function (data) {
				
                },
                error: function (exception) {
                    alert(exception);
                }
            });
	 });	*/
	
JS;
$this->registerJs($script);
?>
      
