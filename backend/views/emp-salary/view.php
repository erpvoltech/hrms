<?php

use yii\helpers\Html;
use yii\bootstrap\DetailView;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use app\models\EmpStaffPayScale;
use common\models\EmpSalaryActual;
use app\models\VgGpaPolicy;
use app\models\VgGpaHierarchy;
use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementHierarchy;
use app\models\VgGmcPolicy;
use app\models\VgGmcHierarchy;
use app\models\VgGmcEndorsement;
use app\models\VgGmcEndorsementHierarchy;
use common\models\EmpSalary;
use common\models\EmpStatutorydetails;

error_reporting(0);

	/*$gpa_amt = 0;
	$gmc_amt = 0;*/
	
	$payscale = EmpRemunerationDetails::find()->where(['empid' => $model->empid])->one();
	$totalactual = $payscale->basic + $payscale->hra + $payscale->splallowance +$payscale->dearness_allowance +$payscale->conveyance +$payscale->lta +$payscale->medical +$payscale->guaranteed_benefit + $payscale->dust_allowance +$payscale->personpay + $payscale->other_allowance + $payscale->misc;
    $actual = EmpSalaryActual::find()->where(['empid' => $model->empid,'month'=>$model->month])->one();
	
	$statutory = EmpStatutorydetails::find()->where(['empid' =>$model->empid])->one();
	
	
	/*if($model->statutory->gpa_no){
		$gpa = VgGpaPolicy::find()->where(['policy_no'=>$model->statutory->gpa_no])->one();
		$gpahierarch = VgGpaHierarchy::find()->where(['sum_insured' =>$model->statutory->gpa_sum_insured,'gpa_policy_id'=>$gpa->id])->one();
		if ($gpahierarch) {
		 $date1 = new DateTime($gpa->from_date);
		 $date2 = new DateTime($gpa->to_date);
		 $diff =  $date1->diff($date2);
		 $months = round($diff->y * 12 + $diff->m + $diff->d / 30);	
		
		$monthdate =  date('Y-m', strtotime($model->month));
		$gpadatefr =  date('Y-m', strtotime($gpa->from_date));
		$gpadateto =  date('Y-m', strtotime($gpa->to_date));
		if($monthdate >= $gpadatefr && $monthdate <= $gpadateto)
		 $gpa_amt = round($gpahierarch->fellow_share / $months);	 
		} else{
			$gpaendo = VgGpaEndorsement::find()->where(['endorsement_no'=>$model->statutory->gpa_no])->one();
			$gpaendohierarch = VgGpaEndorsementHierarchy::find()->where(['endorsement_sum_insured' =>$model->statutory->gpa_sum_insured,'gpa_endorsement_id'=>$gpaendo->id])->one();
			$date1 = new DateTime($gpaendo->start_date);
			 $date2 = new DateTime($gpaendo->end_date);
			 
			 $diff =  $date1->diff($date2);
			 $months = round($diff->y * 12 + $diff->m + $diff->d / 30);	
			 $monthdate =  date('Y-m', strtotime($model->month));
				$gpadatefr =  date('Y-m', strtotime($gpaendo->start_date));
				$gpadateto =  date('Y-m', strtotime($gpaendo->end_date));
				if($monthdate >= $gpadatefr && $monthdate <= $gpadateto)
					$gpa_amt = round($gpaendohierarch->endorsement_fellow_share / $months);
			
		}	
	}	
	
	if($model->statutory->gmc_no){
		$gmc = VgGmcPolicy::find()->where(['policy_no'=>$model->statutory->gmc_no])->one();
		$gmchierarch = VgGmcHierarchy::find()->where(['sum_insured' =>$model->statutory->gmc_sum_insured,'gmc_policy_id'=>$gmc->id,'age_group'=>$model->statutory->age_group])->one();
		if ($gmchierarch) {
		 $date1 = new DateTime($gmc->from_date);
		 $date2 = new DateTime($gmc->to_date);
		 
		 $diff =  $date1->diff($date2);
		 $months = round($diff->y * 12 + $diff->m + $diff->d / 30);	 
		  $monthdate =  date('Y-m', strtotime($model->month));
		$gpadatefr =  date('Y-m', strtotime($gmc->from_date));
		$gpadateto =  date('Y-m', strtotime($gmc->to_date));
		if($monthdate >= $gpadatefr && $monthdate <= $gpadateto)
		 $gmc_amt = round($gmchierarch->fellow_share / ($months * 2));	 
		} else{
			$gmcendo = VgGmcEndorsement::find()->where(['endorsement_no'=>$model->statutory->gmc_no])->one();
			$gmcendohierarch = VgGmcEndorsementHierarchy::find()->where(['endorsement_sum_insured' =>$model->statutory->gmc_sum_insured,'gmc_endorsement_id'=>$gmcendo->id,'endorsement_age_group'=>$model->statutory->age_group])->one();
			$date1 = new DateTime($gmcendo->start_date);
			 $date2 = new DateTime($gmcendo->end_date);
			 
			 $diff =  $date1->diff($date2);
			 $months = round($diff->y * 12 + $diff->m + $diff->d / 30);	 
			 $monthdate =  date('Y-m', strtotime($model->month));
				$gpadatefr =  date('Y-m', strtotime($gmcendo->start_date));
				$gpadateto =  date('Y-m', strtotime($gmcendo->end_date));
				if($monthdate >= $gpadatefr && $monthdate <= $gpadateto)
			 $gmc_amt = round($gmcendohierarch->endorsement_fellow_share / ($months * 2));
			
		}	
	}*/
	
	
	
?>
<!doctype html> 
<html lang="en">
<head>
 
    <title>Pay Slip</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
		.Table
		{
			display: table;
			width:100%;
		}
		.Title
		{
			display: table-caption;
			text-align: right;
			font-weight: bold;
			font-size: larger;
		}
		.Heading
		{
			display: table-row;
			font-weight: bold;
			text-align: center;
		}
		.Row
		{
			display: table-row;
		}
		.Cell
		{
			display: table-cell;
			border: solid;
			border-width: thin;
			padding-left: 5px;
			padding-right: 5px;
		}
		
		.left-panel1 {
		/*border-right: 1px solid #ccc;*/
		min-width: 200px;
		/*padding: 20px 16px 0 0;*/
		float:left;
	}

	.right-panel1 {
		
		/*padding: 10px 0  0 16px;*/
		float:right;
	}
	#scope1 {
		/*border-top: 1px solid #ccc;
		border-bottom: 1px solid #ccc;*/
		padding: 7px 0 4px 0;
		display: flex;
		justify-content: space-around;
	}
	.contribution .title{
		font-size: 15px;
		font-weight: 700;
		border-bottom: 1px solid #ccc;
		padding-bottom: 4px;
		margin-bottom: 6px;
		}

	</style>

</head>
<body><br>
	<?= Html::a('<span class="btn btn-xs btn-danger">Download</span>', ['salarypdf','id'=>$model->email_hash]) ?>
  <div id="payslip">
	<div id="scope1">
		
		<div class="left-panel1">
			<div class="title"> <img src="<?= \Yii::$app->homeUrl ?>img/logo.jpg" /></div>
			
		</div>
		<div class="right-panel1">
			<div class="Heading" >Voltech Engineers Private Limited</div>
			<div class="value">Voltech Eco Tower,</div>
			<div class="value">#2/429,Mount Poonamallee Road</div>
			<div class="value">Ayyappanthangal, Chennai-600056</div>
			<div class="value">Ph.:+91-44-43978000, Fax:044-42867746</div>
			<div class="value">Web:www.voltechgroup.com</div>
		</div>
	
	</div>
	</br>
	<div id="scope">
		
		<div class="scope-entry">
			<div class="value">Payslip for the month of <?= Yii::$app->formatter->asDate($model->month, "php:F , Y") ?></div>
			
		</div>
	</div>
	<div class="contentpay">
		<div class="left-panel">
			<div id="employee">
				<div id="name"><?= $model->employee->empname ?></div>				
			</div>
			<div class="ytd">
				<div class="title">Employee Details</div>
				<div class="entry">
					<div >Emp ID</div>
					<div class="value"><?= $model->employee->empcode ?></div>
				</div>
				<div class="entry">
					<div >Designation</div>
					<div class="value"><?= $model->designations->designation ?></div>
				</div>
				<div class="entry">
					<div >Unit</div>
					<div class="value"><?= $model->units->name ?></div>
				</div>
				<div class="entry">
					<div >Division</div>
					<div class="value"><?= $model->division->division_name ?></div>
				</div>
				<div class="entry">
					<div >Department</div>
					<div class="value"><?= $model->department->name ?></div>
				</div>
				
				<div class="entry">
					<div >Category</div>
					<div class="value"><?= $model->employee->category ?></div>
				</div>
				<div class="entry">
					<div >Work Level</div>
					<div class="value"><?=$model->work_level?></div>
				</div>
				<div class="entry">
					<div >Grade</div>
					<div class="value"><?=$model->grade?></div>
				</div>
				<div class="entry">
					<div >PF No.</div>
					<div class="value"><?= $model->statutory->epfno ?></div>
				</div>
				<div class="entry">
					<div >ESI No.</div>
					<div class="value"><?= $model->statutory->esino ?></div>
				</div>
				<div class="entry">
					<div >UAN</div>
					<div class="value"><?= $model->statutory->epfuanno ?></div>
				</div>
				<div class="entry">
					<div >Doj</div>
					<div class="value"><?= Yii::$app->formatter->asDate($model->employee->doj, "php:d/m/Y") ?></div>
				</div>
				<div class="entry">
					<div >Paid days</div>
					<div class="value"><?=$model->paiddays?></div>
				</div>
				
			</div>
			
			<div class="contributions">
				<div class="title">Employer Contribution</div>
				<?php if($model->pf_employer_contribution) {?>
				<div class="entry">
					<div >PF</div>
					<div class="value"><?=$model->pf_employer_contribution?></div>
				</div>
				<?php } if($model->esi_employer_contribution) {?>
				<div class="entry">
					<div >ESI</div>
					<div class="value"><?=$model->esi_employer_contribution?></div>
				</div>
				<?php } if($model->pli_employer_contribution) {?>
				<div class="entry">
					<div >Bonus</div>
					<div class="value"><?=$model->pli_employer_contribution?></div>
				</div>
				<?php } if($model->lta_employer_contribution) {?>
				<div class="entry">
					<div >LTA</div>
					<div class="value"><?=$model->lta_employer_contribution?></div>
				</div>
				<?php } if($model->med_employer_contribution) {?>
				<div class="entry">
					<div >Medical</div>
					<div class="value"><?=$model->med_employer_contribution?></div>
				</div>
				
				<?php } if($statutory->gpa_applicability == 'Yes') { ?>
				<div class="entry">
					<div >GPA</div>
					<div class="value"><?=round($statutory->gpa_premium/12)?></div>
				</div>	
				<?php } if($statutory->gmc_applicability =='Yes') { ?>
				<div class="entry">
					<div >GMC</div>
					<div class="value"><?=round($statutory->gmc_premium/24)?></div>
				</div>				
				<?php } if($model->food_allowance) { ?>				
					<div class="entry">
					<div >Food Allowance</div>
					<div class="value"><?=$model->food_allowance?></div>
				</div>
				<?php }  ?>
				
				<br>				
				<div class="entry" style="padding: 5px 0 5px 0; background: rgba(0, 0, 0, 0.04);font-weight: 700;">
					<div >CTC</div>
					<div class="value"><?=round($model->earned_ctc + round($statutory->gpa_premium/12) + round($statutory->gmc_premium/24)) ?></div>
				</div>
				
			</div>
			
		</div>
		<div class="right-panel">
			<div class="details">
				<div class="contribution">
					<div class="title">Components &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;Actual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Earnings</div>
				</div>
				<div class="salary">
				<?php if($model->basic) {?>
					<div class="entry">
						<div  style="width:100px;">Base Pay</div>
						
						<div class="rate"><?=$actual->basic?>	</div>
						<div class="amount"><?=$model->basic?></div>
					</div>
				<?php } if($model->hra) {?>
					<div class="entry">
						<div style="width:100px;">HRA</div>
						
						<div class="rate"><?=$actual->hra?>	</div>
						<div class="amount"><?=$model->hra?></div>
					</div>
					<?php } if($model->spl_allowance) {?>
					<div class="entry">
						<div style="width:100px;">Spl. allowance</div>
						
						<div class="rate"><?=$actual->spl_allowance?></div>
						<div class="amount"><?=$model->spl_allowance?></div>
					</div>
					<?php } if($model->dearness_allowance) {?>
					<div class="entry">
						<div style="width:100px;">DA</div>
						
						<div class="rate"><?=$actual->dearness_allowance?></div>
						<div class="amount"><?=$model->dearness_allowance?></div>
					</div>
					<?php } if($model->conveyance_allowance) {?>
					<div class="entry">
						<div style="width:100px;">Conveyance</div>
						
						<div class="rate"><?=$actual->conveyance_allowance?></div>
						<div class="amount"><?=$model->conveyance_allowance?></div>
					</div>
					<?php } if($model->over_time) {?>
					<div class="entry">
						<div style="width:100px;">Over Time</div>
						
						<div class="rate"></div>
						<div class="amount"><?=$model->over_time?></div>
					</div>
					<?php } if($model->arrear) {?>
					<div class="entry">
						<div style="width:100px;">Arrears</div>
						
						<div class="rate"></div>
						<div class="amount"><?=$model->arrear?></div>
					</div>
					<?php } if($model->advance_arrear_tes) {?>
					<div class="entry">
						<div style="width:100px;">Advance/Arrear TES</div>
						
						<div class="rate"></div>
						<div class="amount"><?=$model->advance_arrear_tes?></div>
					</div>
					<?php } if($model->lta_earning) {?>
					<div class="entry">
						<div style="width:100px;">LTA</div>
						
						<div class="rate"><?=$actual->lta_earning?></div>
						<div class="amount"><?=$model->lta_earning?></div>
					</div>
					<?php } if($model->medical_earning) {?>
					<div class="entry">
						<div style="width:100px;">Medical</div>
						
						<div class="rate"><?=$actual->medical_earning?></div>
						<div class="amount"><?=$model->medical_earning?></div>
					</div>
					<?php } if($model->guaranted_benefit) {?>
					<div class="entry">
						<div style="width:100px;">Guaranteed benefit</div>
						
						<div class="rate"><?=$actual->guaranted_benefit?></div>
						<div class="amount"><?=$model->guaranted_benefit?></div>
					</div>
					<?php } if($model->holiday_pay) {?>
					<div class="entry">
						<div style="width:100px;">Holiday pay</div>
						
						<div class="rate"></div>
						<div class="amount"><?=$model->holiday_pay?></div>
					</div>
					<?php } if($model->washing_allowance) {?>
					<div class="entry">
						<div style="width:100px;">Washing allowance</div>
						
						<div class="rate"><?=$actual->washing_allowance?></div>
						<div class="amount"><?=$model->washing_allowance?></div>
					</div>
					<?php } if($model->dust_allowance) {?>
					<div class="entry">
						<div style="width:100px;">Dust allowance</div>
						
						<div class="rate"><?=$actual->dust_allowance?></div>
						<div class="amount"><?=$model->dust_allowance?></div>
					</div>
					<?php } if($model->performance_pay) {?>
					<div class="entry">
						<div style="width:100px;">Person pay</div>
						<div class="rate"><?=$actual->performance_pay?></div>
						<div class="amount"><?=$model->performance_pay?></div>
					</div>
					<?php } if($model->other_allowance) {?>
					<div class="entry">
						<div style="width:100px;">Other allowance</div>
						
						<div class="rate"><?=$actual->other_allowance?></div>
						<div class="amount"><?=$model->other_allowance?></div>
					</div>
					<?php } if($model->misc) {?>
					<div class="entry">
						<div style="width:100px;">Miscellaneous</div>
						
						<div class="rate"><?=$actual->misc?></div>
						<div class="amount"><?=$model->misc?></div>
					</div>
					<?php }?>					
				</div>
				
				<div class="net_pay">
					<div class="entry">
						<div >Gross Earnings</div>
						<div class="detail"></div>
						<div > <?=$actual->gross?></div>
						<div class="amount"><?=	$model->total_earning?></div>
					</div>
				</div>
				
				<div class="contribution">
					<div class="title" style="text-align:right">Deductions</div>
				</div>
				<div class="salary">
				<?php if($model->pf) { ?>
					<div class="entry">
						<div >EPF</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->pf?></div>
					</div>
					<?php } if($model->insurance) {?>
					<div class="entry">
						<div >Insurance</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->insurance?></div>
					</div>
					<?php } if($model->professional_tax) {?>
					<div class="entry">
						<div >Professional tax</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->professional_tax?></div>
					</div>
					<?php } if($model->esi) {?>
					<div class="entry">
						<div >ESI</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->esi?></div>
					</div>
					<?php } if($model->advance) {?>
					<div class="entry">
						<div >Advance</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->advance?></div>
					</div>
					<?php } if($model->tes) {?>
					<div class="entry">
						<div >TES</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->tes?></div>
					</div>
					<?php } if($model->caution_deposit) {?>
					<div class="entry">
						<div >Caution Deposit</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->caution_deposit?></div>
					</div>
					<?php } if($model->mobile) {?>
					<div class="entry">
						<div >Mobile</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->mobile?></div>
					</div>
					<?php } if($model->loan) {?>
					<div class="entry">
						<div >Loan</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->loan?></div>
					</div>
					<?php } if($model->rent) {?>
					<div class="entry">
						<div >Rent</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->rent?></div>
					</div>
					<?php } if($model->tds) {?>
					<div class="entry">
						<div >TDS</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->tds?></div>
					</div>
					<?php } if($model->lwf) {?>
					<div class="entry">
						<div >LWF</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->lwf?></div>
					</div>
					<?php } if($model->other_deduction) {?>
					<div class="entry">
						<div >Other deductions</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->other_deduction?></div>
					</div>
					<?php } ?>														
				</div>
				
				<div class="net_pay">
					<div class="entry">
						<div >Total Deduction</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->total_deduction?></div>
					</div>
				</div>

				
				<div class="net_pay">
					<div class="entry">
						<div >NET PAY</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?=$model->net_amount?></div>
					</div></br>
                  <div class="entry">
						<div >In words:</div>											
						<div><?= $model->employee->getIndianCurrency($model->net_amount) ?> Only</div>
					</div>
				</div><p></p>
				
			</div>
		</div>
		</br>
	</div>
	<div id="scope">
		<div class="scope-entry">
			<div class="title">This is a system generated payslip. Hence signature not required.</div>
		</div>		
	</div>
	
</div>
 
</body>
</html>
