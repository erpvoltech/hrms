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
use app\models\EmpLeaveCounter;
use app\models\EmpRemunerationDetails;

########################## Fetch Data From Other Mode ##################

$Salary = new EmpSalary();
$leavecount = new EmpLeaveCounter();

$created_at = date('Y-m-d H:i:s');	

	$Emp  = EmpDetails::find()->where(['id' => $model->empid])->one();	
	$remunerationmodel = EmpRemunerationDetails::find()->where(['empid'=>$Emp->id])->one();
	
		if($Emp->etype=='Engineer') {
			$Leave = EmpLeave::find()
		   ->where(['empid' => $model->empid])
		   ->one();
		} else if($Emp->etype=='Staff') {
			$LeaveStaff = EmpLeaveStaff::find()
		   ->where(['empid' => $model->empid])
		   ->one(); 
		}
		if($remunerationmodel->salary_structure == 'Consolidated pay') { 
		Yii::$app->session->addFlash("error", 'Check Employee Salary Structure');
		} else if($remunerationmodel->salary_structure == 'Contract'){
		Yii::$app->session->addFlash("error", 'Check Employee Salary Structure');
		} else {
	/*$Salstructure  = EmpSalarystructure::find()
       ->where(['worklevel' => $Emp->worklevel, 'grade' => $Emp->grade])
       ->one();*/
	
	$PayScale = EmpStaffPayScale::find()
				->where(['id' => $Emp->staff_pay_scale_id])
				->one(); 	
	
	$Statutory = EmpStatutorydetails::find()
		->where(['empid' => $model->empid])
        ->one();
		
	$WorkDays  = MaxWorkingdays::find()
       ->where(['month' => $model->month])
       ->one();	
	
	$workstatus = 0;
	
	########################## End Fetch Data ##################	
	
	$m = date("m",strtotime($model->month));
	$y = date("Y",strtotime($model->month));	
	$maxDays = cal_days_in_month(CAL_GREGORIAN, $m, $y); // maximum days for month		
	$relievemonth = date("m",strtotime($Emp->dateofleaving)); 		
		if($Emp->status == 'Paid and Relieved'  && $m == $relievemonth) {		
			$relievedate = strtotime($Emp->dateofleaving); 
			$your_date = strtotime($model->month);
			$datediff = $relievedate - $your_date;			
			$workingDays = round($datediff / (60 * 60 * 24)) +1; // maximum days for month	
			$workstatus = 1;
		} else if($Emp->status == 'Relieved') {
			$workingDays = 0;
			$workstatus = 1;
		}	
	
	$loss_of_pay_days = 0;
	$Earned_Allovance = 0;
	$avance_tes = 0;
	$tes = 0;


	$transaction = \Yii::$app->db->beginTransaction();	   // Transaction begin
	try {	
			
			$provident_fund = 0;
			$employee_state_insurance = 0;
			$professional_tax = 0;
			$grossamount = 0;
			$present_days = 0;
			
			//***************************** salary processing begin *************************//
			
			  $Salary ->empid = $Emp->id;
			  $Salary ->date = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
			  $Salary ->attendancetype =$model->staff_type;
			  $Salary ->month = $model->month;			  
			
			  
			  if($model->staff_type == 'Engineer') {             //// For permanent engg 
			  
			  /************************ Leave Update Engineer *********************************/
			 if($Leave)
			 $loss_of_pay_days = $model->LeaveUpdate($m,$model->leavedays,$Leave);
			 else
			 $loss_of_pay_days = $model->leavedays;
			  
			 /*********************** statutory_rate calculation *******************************/
			
			if($workstatus == 1){
				$present_days = $workingDays - ($loss_of_pay_days + $model->lop_days);
				} else {
				$present_days = $maxDays - ($loss_of_pay_days + $model->lop_days);
				}
			
			
			$present_days_for_statutory = $WorkDays->days - ($loss_of_pay_days + $model->lop_days);;			
			$earned_statutory_rate = $model->statutory_rate * $present_days_for_statutory;			
			$earned_gross = ($remunerationmodel->gross_salary / $maxDays) *($maxDays - ($loss_of_pay_days + $model->lop_days));
			$statutory_rate_pf = max($earned_statutory_rate,$earned_gross);
			$statutory_rate_esi = max(($earned_statutory_rate + $model->over_time),($earned_gross + $model->over_time));
			
			
			if($remunerationmodel->pf_applicablity == 'yes') {
				if($remunerationmodel->restrict_pf == 'yes') {
				$provident_fund = 15000 * 0.12;
				} else {
				$provident_fund = $statutory_rate_pf * 0.12;
				}
			}
			if($remunerationmodel->esi_applicability == 'yes') {
			if($statutory_rate_esi <= 21000) {
				$employee_state_insurance = ceil($statutory_rate_esi  * 0.0175); 
			   } else {
			   $employee_state_insurance = 0;
			   }
			} 			
			
			##################################  ///TES Calculation  ///#################################
			$Earned_Allovance =  round(($remunerationmodel ->dearness_allowance/30) * $dadays); /// DA should be fixed as 30day per month;			   
			    $tes = $Earned_Allovance - $model->allowance_paid;             
				if($tes > 0){
					$tes = $tes;
					$avance_tes = 0;
				}	else {
					$avance_tes =  abs($tes);
					$tes = 0; 					
				}	
				
			  ############################### Assign Engg Salary #############################
			  
			    
			  $Salary ->basic = round(($remunerationmodel->basic/$maxDays) * $present_days);			   
			  $Salary ->hra = round(($remunerationmodel ->hra/$maxDays) * $present_days);
			  $Salary ->spl_allowance = round(($remunerationmodel->splallowance/$maxDays) * $present_days);
			  $Salary ->dearness_allowance = $Earned_Allovance;
			  $Salary ->advance_arrear_tes = $avance_tes;
			  $Salary ->over_time = $model->over_time;
			  $Salary ->tes = $tes;
			  
			  $Salary ->work_level = $remunerationmodel->work_level;
			  $Salary ->grade = $remunerationmodel->grade;
			  $Salary ->designation = $Emp->designation_id;
			  
			  
			    } if($Emp->etype == 'Staff' && $model->staff_type == 'Staff')  {   ///// For Staff
			         
			    ######################## Leave Update Staff #####################################
			   if($LeaveStaff)
			   $loss_of_pay_days = $model->LeaveUpdateStaff($m,$model->leavedays,$LeaveStaff);
			   else
			   $loss_of_pay_days = $model->leavedays;
		   
		 		   
			if($workstatus == 1){
				$present_days = $workingDays - ($loss_of_pay_days + $model->lop_days);
				} else {
				$present_days = $maxDays - ($loss_of_pay_days + $model->lop_days);
				}
			   			   
			    ################################ Staff  Salary ##################################
				
				 $grossamount = ($remunerationmodel->gross_salary/ $maxDays) *  $present_days;
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
					
					$Salary ->work_level = $remunerationmodel->work_level;
					$Salary ->grade = $remunerationmodel->grade;
					$Salary ->designation = $Emp->designation_id;
					$Salary ->gross = $remunerationmodel->gross_salary;
					$Salary ->payscale = $remunerationmodel->staff_pay_scale_id;
					
					######################## Staff PF ,ESI ,PT calculations ##########################
				
					if (($remunerationmodel->gross_salary * 0.8) > 15000){
						$provident_fund = 1800;                                // fixed EPF Amount;
						} else {
						$provident_fund = round(($remunerationmodel->gross_salary * 0.8) * 0.12); 
						}
					if($remunerationmodel->gross_salary > 21000) {
						$employee_state_insurance = 0;
						} else {
						$employee_state_insurance = ceil($remunerationmodel->gross_salary * 0.0175);
						}
					if($remunerationmodel->gross_salary >12500) {
						$professional_tax = 196;
						} else if($remunerationmodel->gross_salary <= 12500 && $remunerationmodel->gross_salary > 10000) {
						$professional_tax = 147;
						} else if($remunerationmodel->gross_salary <= 10000 && $remunerationmodel->gross_salary > 7500) {
						$professional_tax = 98;
						} else if($remunerationmodel->gross_salary <= 7500 && $remunerationmodel->gross_salary > 5000) {
						$professional_tax = 49;
						} else if($remunerationmodel->gross_salary <= 5000 && $remunerationmodel->gross_salary > 3500) {
						$professional_tax = 20;
						} else {
						$professional_tax = 0;
						} 
					
			   } 
			   
			    ############################### Assign Engg / Staff Salary #############################
			  if($workstatus == 1){
					$Salary ->paiddays = $workingDays - ($loss_of_pay_days + $model->lop_days);
				} else {
					$Salary ->paiddays = $maxDays - ($loss_of_pay_days + $model->lop_days);
				}
			 
			  $Salary ->arrear = $model->arrear;
			  $Salary ->holiday_pay = $model->holiday_pay;
			  $Salary ->other_allowance = $model->other_allowance;
			  $Salary ->total_earning = ( $Salary ->basic + $Salary ->hra + $Salary ->dearness_allowance + $Salary ->spl_allowance + $Salary ->conveyance_allowance	+ $Salary ->pli_earning +
						$Salary ->lta_earning +$Salary ->medical_earning + $Salary ->other_allowance + $Salary ->arrear + $Salary ->holiday_pay + $Salary ->advance_arrear_tes + $Salary ->over_time);
			 
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
			  
			  $Salary ->total_deduction =($Salary ->pf + $Salary ->insurance + $Salary ->professional_tax + $Salary ->mobile +  $Salary ->esi + $Salary ->advance +  $Salary ->pli_deduction + $Salary ->lta_deduction + $Salary ->medical_deduction + $Salary ->other_deduction + $Salary ->tes);
			  $Salary ->net_amount = $Salary ->total_earning - $Salary ->total_deduction;
			 
			  if($Salary->save(false)){
					$lastID = Yii::$app->db->getLastInsertID();					
				    $model->status = 'Salary Generated';
					$model->save(false);	
					if($Emp->status == 'Paid and Relieved'  && $m == $relievemonth){
					$EmpModel  = EmpDetails::find()->where(['id' => $model->empid])->one();
					$EmpModel->status = 'Relieved';
					$EmpModel->save(false);					
					}
					echo $model->empid;
					$leavecount->empid = $model->empid;
					//$leavecount->type = $model->staff_type;
					$leavecount->month = $model->month;
					$leavecount->leave_days = ($model->leavedays + $model->lop_days);
					$leavecount->save();
					$transaction->commit();             // Transaction Commit				  
				  }		     
	Yii::$app->response->redirect(Url::to(['view', 'id' =>$lastID ])); 
	 
	}  catch (\Exception $e) {					// Transaction Exception
		$transaction->rollBack();
		throw $e;
	} catch (\Throwable $e) {
		$transaction->rollBack();
		throw $e;
	}  
	}

?> 