<?php
use yii\helpers\Url;
use app\models\EmpSalarystructure;
use common\models\EmpStaffPayScale;
use common\models\EmpLeave;
use common\models\EmpLeaveStaff;
use common\models\EmpDetails;
use common\models\EmpSalary;
use app\models\EmpStatutorydetails;
use app\models\MaxWorkingdays;


########################## Fetch Data From Other Mode ##################

$Salary = new EmpSalary();

$created_at = date('Y-m-d H:i:s');	

	$Emp  = EmpDetails::find()
	->where(['id' => $model->empid])
       ->one();
		if($Emp->etype=='Engineer') {
			$Leave = EmpLeave::find()
		   ->where(['empid' => $model->empid])
		   ->one();
		} else if($Emp->etype=='Staff') {
			$LeaveStaff = EmpLeaveStaff::find()
		   ->where(['empid' => $model->empid])
		   ->one(); 
		}
	   
	$Salstructure  = EmpSalarystructure::find()
       ->where(['worklevel' => $Emp->worklevel, 'grade' => $Emp->grade])
        ->one();
	
	$PayScale = EmpStaffPayScale::find()
				->where(['id' => $Emp->pay_scale])
				->one(); 	
	
	$Statutory = EmpStatutorydetails::find()
		->where(['empid' => $model->empid])
        ->one();
		
	$WorkDays  = MaxWorkingdays::find()
       ->where(['month' => $model->month])
       ->one();	
	
	
	########################## End Fetch Data ##################	
	
	$m = date("m",strtotime($model->month));
	$y = date("Y",strtotime($model->month));
	$maxDays=cal_days_in_month(CAL_GREGORIAN, $m, $y); // maximum days for month	

	$loss_of_pay_days = 0;
	$Earned_Allovance = 0;
	$avance_tes = 0;
	$tes = 0;	
	$saved =0;
	$transaction = \Yii::$app->db->beginTransaction();	   // Transaction begin
	try {	
		    $flag = 0;
			$provident_fund = 0;
			$employee_state_insurance = 0;
			$professional_tax = 0;
			$grossamount = 0;
			$present_days = 0;
			
			//***************************** salary processing begin *************************/
			
			  $Salary ->empid = $Emp->id;
			  $Salary ->date = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
			  $Salary ->attendancetype =$model->staff_type;
			  $Salary ->month = $model->month;			  
			
			  if($Emp->etype == 'Engineer' && $Emp->worktype == 'Permanent' && $model->staff_type == 'Permanent') {
			 
			  
			  /************************ Leave Update Engineer *********************************/
			 if($Leave)
			 $loss_of_pay_days = $model->LeaveUpdate($m,$model->leavedays,$Leave);
			 else
			 $loss_of_pay_days = $model->leavedays;	
			  
			 /*********************** statutory_rate calculation *******************************/
			$present_days = $maxDays - $loss_of_pay_days;
			$present_days_for_statutory = $WorkDays->days - $loss_of_pay_days;			
			$earned_statutory_rate = $model->statutory_rate * $present_days_for_statutory;			
			$earned_gross = ($Salstructure->netsalary / $maxDays) *($maxDays - $loss_of_pay_days);
			$statutory_rate_pf = max($earned_statutory_rate,$earned_gross);
			$statutory_rate_esi = max(($earned_statutory_rate + $model->over_time),($earned_gross + $model->over_time));
			
			
			
			if($Statutory->epfapplicability == 'yes') {
				$provident_fund = 15000 * 0.12;
				} else {
				$provident_fund = $statutory_rate_pf * 0.12;
				}
			if($Statutory->	esiapplicability == 'yes') {
			if($Salstructure->netsalary <= 21000) {
				$employee_state_insurance = $statutory_rate_esi  * 0.0175; 
			   }
			} 
			
			##################################  ///TES Calculation  ///#################################
			
			$Earned_Allovance = ($Salstructure ->dapermonth/30) * $present_days;   /// DA should be fixed as 30day per month;
			    $tes = $Earned_Allovance - $model->allowance_paid;             
				if($tes > 0)				
					$tes = $tes;
				else 				
					$avance_tes =  abs($tes);
							
			   ############################### Assign Engg Salary #############################
			  $Salary ->basic = round(($Salstructure ->basic/$maxDays) * $present_days);
			  $Salary ->hra = round(($Salstructure ->hra/$maxDays) * $present_days);
			  $Salary ->spl_allowance = round(($Salstructure ->splallowance/$maxDays) * $present_days);
			  $Salary ->dearness_allowance = $Earned_Allovance;
			  $Salary ->advance_arrear_tes = $avance_tes;
			  $Salary ->over_time = $model->over_time;
			  $Salary ->tes = $tes;
			  
			  $Salary ->work_level = $Emp->worklevel;
			  $Salary ->grade = $Emp->grade;
			  $Salary ->designation = $Emp->designation_id;
			  $flag = 1;
			  ######################## Actual for Engg ###########################################
			  
			  } if($Emp->etype == 'Staff' && $Emp->worktype == 'Permanent' && $model->staff_type == 'Staff') {          ///// For Staff
			    ######################## Leave Update Staff #####################################
				
			   if($LeaveStaff)
			   $loss_of_pay_days = $model->LeaveUpdateStaff($m,$model->absentdays,$LeaveStaff);
			   else
			   $loss_of_pay_days = $model->absentdays;	
		   
			    $present_days = $maxDays - $loss_of_pay_days;
			   
			    ################################ Staff  Salary ##################################
				
				 $grossamount = ($Emp->gross_salary/ $maxDays) *  $present_days;
			        $Salary ->basic =  round($grossamount * $PayScale->basic);
					$Salary ->hra =  round($grossamount * $PayScale->hra);
					$Salary ->dearness_allowance =  round($grossamount * $PayScale->dearness_allowance);
					$Salary ->spl_allowance =  round($grossamount * $PayScale->spl_allowance);
					$Salary ->conveyance_allowance =  round($PayScale->conveyance_allowance); 				
					$Salary ->pli_earning = round($Salary ->basic * $PayScale->pli);
					$Salary ->lta_earning = round($Salary ->basic * $PayScale->lta);
					$Salary ->medical_earning = round($Salary ->basic * $PayScale->medical);
					$Salary ->other_allowance = round($grossamount - ($Salary ->basic + $Salary ->hra + $Salary ->dearness_allowance + $Salary ->spl_allowance + $Salary ->conveyance_allowance
					+ $Salary ->pli_earning + $Salary ->lta_earning + $Salary ->medical_earning)); 
					
					$Salary ->work_level = $Emp->worklevel;
					$Salary ->grade = $Emp->grade;
					$Salary ->designation = $Emp->designation_id;
					$Salary ->gross = $Emp->gross_salary;
					$Salary ->payscale = $Emp->pay_scale;
					
					
				######################## Staff PF ,ESI ,PT calculations ##########################
				
					if (($Emp->gross_salary * 0.8) > 15000){
						$provident_fund = 1800;                                // fixed EPF Amount;
						} else {
						$provident_fund = round(($Emp->gross_salary * 0.8) * 0.12); 
						}
					if($Emp->gross_salary > 21000) {
						$employee_state_insurance = 0;
						} else {
						$employee_state_insurance = ceil($Emp->gross_salary * 0.0175);
						}
					if($model->gross >12500) {
						$professional_tax = 196;
						} else if($Emp->gross_salary <= 12500 && $Emp->gross_salary > 10000) {
						$professional_tax = 147;
						} else if($Emp->gross_salary <= 10000 && $Emp->gross_salarys > 7500) {
						$professional_tax = 98;
						} else if($Emp->gross_salary <= 7500 && $Emp->gross_salary > 5000) {
						$professional_tax = 49;
						} else if($Emp->gross_salary <= 5000 && $Emp->gross_salary > 3500) {
						$professional_tax = 20;
						} else {
						$professional_tax = 0;
						} 
						$flag = 1;
			   } 
			   
			    ############################### Assign Engg / Staff Salary #############################
			
			  $Salary ->paiddays = $maxDays - $loss_of_pay_days;
			  $Salary ->arrear = $model->arrear;			 
			  $Salary ->other_allowance = $model->other_allowance;
			  $Salary ->total_earning = ( $Salary ->basic + $Salary ->hra + $Salary ->dearness_allowance + $Salary ->spl_allowance + $Salary ->conveyance_allowance	+ $Salary ->pli_earning +
						$Salary ->lta_earning +$Salary ->medical_earning + $Salary ->other_allowance + $Salary ->arrear );
			 
			 ######### deduction ###########
			 
			  $Salary ->pf = $provident_fund;
			  $Salary ->insurance = $model->insurance;
			  $Salary ->professional_tax = $professional_tax;
			  $Salary ->mobile = $model->mobile;
			  $Salary ->esi = $employee_state_insurance;
			  $Salary ->advance = $model->advance;			
			  $Salary ->pli_deduction = $Salary ->pli_earning;
			  $Salary ->lta_deduction = $Salary ->lta_earning;
			  $Salary ->medical_deduction = $Salary ->medical_earning;
			  $Salary ->other_deduction = $model->others;			  
			  
			  $Salary ->total_deduction =($Salary ->pf + $Salary ->insurance + $Salary ->professional_tax + $Salary ->mobile +  $Salary ->esi + $Salary ->advance +  $Salary ->pli_deduction + $Salary ->lta_deduction + $Salary ->medical_deduction + $Salary ->other_deduction);
			  $Salary ->net_amount = $Salary ->total_earning - $Salary ->total_deduction;
			  if($Salary->save(false)){
					$lastID = Yii::$app->db->getLastInsertID();				
				    $model->status = 'salary Generated';
					$model->save(false);						// Save Model
					$transaction->commit();             // Transaction Commit
					$saved =1;
					$result_success[]='sucess';				  
				  }	 
				
				 	
	}  catch (\Exception $e) {					// Transaction Exception
		$transaction->rollBack();
		throw $e;
	} catch (\Throwable $e) {
		$transaction->rollBack();
		throw $e;
	}   
	
?>