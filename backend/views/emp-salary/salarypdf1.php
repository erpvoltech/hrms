<?php

use yii\helpers\Html;
use Mpdf\Mpdf;
use common\models\EmpRemunerationDetails;
use common\models\EmpSalary;
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
ini_set('memory_limit', '1024M');

	$gpa_amt = 0;
	$gmc_amt = 0;


$actual = EmpSalaryActual::find()->where(['empid' => $model->empid,'month'=>$model->month])->one();

$payscale = EmpRemunerationDetails::find()->where(['empid' => $model->empid])->one();



	if($model->statutory->gpa_no){
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
			 $gmc_amt = round($gmcendohierarch->endorsement_fellow_share /($months * 2));
			
		}	
	}


$employercontribution=NULL;
if($model->pf_employer_contribution) {				
$employercontribution .= '<tr><td width="30%">PF</td><td width="70%" style="text-align:right">'. $model->pf_employer_contribution.'</td></tr>';
}
if($model->esi_employer_contribution) {				
$employercontribution .= '<tr><td width="30%">ESI</td><td width="70%" align="right">'. $model->esi_employer_contribution.'</td></tr>';
}
if($model->pli_employer_contribution) {				
$employercontribution .= '<tr><td width="30%">Bonus</td><td width="70%" align="right">'. $model->pli_employer_contribution.'</td></tr>';
}
if($model->lta_employer_contribution) {				
$employercontribution .= '<tr><td width="30%">LTA</td><td width="70%" align="right">'. $model->lta_employer_contribution.'</td></tr>';
}
if($model->med_employer_contribution) {				
$employercontribution .= '<tr><td width="30%">Medical</td><td width="70%" align="right">'. $model->med_employer_contribution.'</td></tr>';
}

if($gpa_amt != 0) {				
$employercontribution .= '<tr><td width="30%">GPA</td><td width="70%" align="right">'. $gpa_amt.'</td></tr>';
}
if($gmc_amt != 0) {				
$employercontribution .= '<tr><td width="30%">GMC</td><td width="70%" align="right">'. $gmc_amt.'</td></tr>';
} 

if($model->food_allowance) {				
$employercontribution .= '<tr><td width="30%">Food Allowance</td><td width="70%" align="right">'. $model->food_allowance.'</td></tr>';
} 

$earnings=NULL;

$totalactual = $payscale->basic + $payscale->hra + $payscale->splallowance +$payscale->dearness_allowance +$payscale->conveyance +$payscale->lta +$payscale->medical +$payscale->guaranteed_benefit + $payscale->dust_allowance +$payscale->personpay + $payscale->other_allowance + $payscale->misc;

if($model->hra) { 
$earnings .='<tr><td >HRA</td><td align="right">'.$actual->hra.'</td><td align="right">'.$model->hra.'</td></tr>';
}
if($model->spl_allowance) { 
$earnings .='<tr><td>Spl. Allowance</td><td align="right">'.$actual->spl_allowance.'</td><td align="right">'.$model->spl_allowance.'</td></tr>';
}
if($model->dearness_allowance) { 
$earnings .='<tr><td>DA</td><td align="right">'.$actual->dearness_allowance.'</td><td align="right">'.$model->dearness_allowance.'</td></tr>';
}
if($model->conveyance_allowance) { 
$earnings .='<tr><td>Conveyance</td><td align="right">'.$actual->conveyance_allowance.'</td><td align="right">'.$model->conveyance_allowance.'</td></tr>';
}
if($model->over_time) { 
$earnings .='<tr><td>Over Time</td><td></td><td align="right">'.$model->over_time.'</td></tr>';
}
if($model->arrear) { 
$earnings .='<tr><td>Arrear</td><td></td><td align="right">'.$model->arrear.'</td></tr>';
}
if($model->advance_arrear_tes) { 
$earnings .='<tr><td>Advance/Arrear TES</td><td></td><td align="right">'.$model->advance_arrear_tes.'</td></tr>';
}
if($model->lta_earning) { 
$earnings .='<tr><td>LTA</td><td align="right">'.$actual->lta_earning.'</td><td align="right">'.$model->lta_earning.'</td></tr>';
}
if($model->medical_earning) { 
$earnings .='<tr><td>Medical</td><td align="right">'.$actual->medical_earning.'</td><td align="right">'.$model->medical_earning.'</td></tr>';
}
if($model->guaranted_benefit) { 
$earnings .='<tr><td>Guaranteed benefit</td><td align="right">'.$actual->guaranted_benefit.'</td><td align="right">'.$model->guaranted_benefit.'</td></tr>';
}
if($model->holiday_pay) { 
$earnings .='<tr><td>Holiday pay</td><td align="right"></td><td align="right">'.$model->holiday_pay.'</td></tr>';
}
if($model->washing_allowance) { 
$earnings .='<tr><td>Washing Allowance</td><td align="right">'.$actual->washing_allowance.'</td><td align="right">'.$model->washing_allowance.'</td></tr>';
}
if($model->dust_allowance) { 
$earnings .='<tr><td>Dust Allowance</td><td align="right">'.$actual->dust_allowance.'</td><td align="right">'.$model->dust_allowance.'</td></tr>';
}
if($model->performance_pay) { 
$earnings .='<tr><td>Person pay</td><td align="right">'.$actual->performance_pay.'</td><td align="right">'.$model->performance_pay.'</td></tr>';
}
if($model->misc) { 
$earnings .='<tr><td>Miscellaneous</td><td align="right">'.$actual->misc.'</td><td align="right">'.$model->misc.'</td></tr>';
}
if($model->other_allowance) { 
$earnings .='<tr><td>Other Allowance </td><td align="right">'.$actual->other_allowance.'</td><td align="right">'.$model->other_allowance.'</td></tr>';
}			
		
$deductions=NULL;	
		
if($model->pf) {
$deductions .='<tr><td>PF</td><td align="right"></td><td align="right">'.$model->pf.'</td></tr>';
}
if($model->insurance) {
$deductions .='<tr><td>Insurance</td><td align="right"></td><td align="right">'.$model->insurance.'</td></tr>';
}
if($model->professional_tax) {
$deductions .='<tr><td>Professional tax</td><td align="right"></td><td align="right">'.$model->professional_tax.'</td></tr>';
}
if($model->esi) {
$deductions .='<tr><td>ESI</td><td align="right"></td><td align="right">'.$model->esi.'</td></tr>';
}
if($model->advance) {
$deductions .='<tr><td>Advance</td><td align="right"></td><td align="right">'.$model->advance.'</td></tr>';
}
if($model->tes) {
$deductions .='<tr><td>TES</td><td align="right"></td><td align="right">'.$model->tes.'</td></tr>';
}

if($model->caution_deposit) {
$deductions .='<tr><td>Caution Deposit</td><td align="right"></td><td align="right">'.$model->caution_deposit.'</td></tr>';
}
if($model->mobile) {
$deductions .='<tr><td>Mobile</td><td align="right"></td><td align="right">'.$model->mobile.'</td></tr>';
}
if($model->loan) {
$deductions .='<tr><td>Loan</td><td align="right"></td><td align="right">'.$model->loan.'</td></tr>';
}
if($model->rent) {
$deductions .='<tr><td>Rent</td><td align="right"></td><td align="right">'.$model->rent.'</td></tr>';
}
if($model->tds) {
$deductions .='<tr><td>TDS</td><td align="right"></td><td align="right">'.$model->tds.'</td></tr>';
}
if($model->lwf) {
$deductions .='<tr><td>LWF</td><td align="right"></td><td align="right">'.$model->lwf.'</td></tr>';
}
if($model->other_deduction) {
$deductions .='<tr><td>Other Deduction</td><td align="right"></td><td align="right">'.$model->other_deduction.'</td></tr>';
}

	

	
$html = '<div style="padding:10px 0 5px 0">
<div style="float: left; width: 50%; margin-bottom: 0pt; ">
<div class="title">'.Html::img("@web/img/logo.jpg").'</div> 
</div>
<div style="float: right; width: 50%; margin-bottom: 0pt;  ">
<div class="Heading" >Voltech Engineers Private Limited</div>
			<div class="value">Voltech Eco Tower,</div>
			<div class="value">#2/429,Mount Poonamallee Road</div>
			<div class="value">Ayyappanthangal, Chennai-600056</div>
			<div class="value">Ph.:+91-44-43978000, Fax:044-42867746</div>
			<div class="value">Web:www.voltechgroup.com</div>
</div>
</div>
	
	</br>
	
<div  style="text-align: center;border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 7px 0 4px 0; display: flex;justify-content: space-around; ">
Payslip for the month of: '. Yii::$app->formatter->asDate($model->month, "php:F , Y").'</div>

<div style="padding:10px 0 5px 0">
<div style="float: left; width: 40%; margin-bottom: 0pt; border-right:1px solid #ccc;">
<div style="text-align:left;border-bottom: 1px solid #ccc;font-weight: 700;">Employee Details</div>	
<table>
<tr><td width="30%">Emp Name</td><td width="70%" align="right">'.$model->employee->empname.'</td></tr>
<tr><td width="30%">Emp ID</td><td width="70%" align="right">'. $model->employee->empcode.'</td></tr>
<tr><td >Designation</td><td  align="right">'. $model->designations->designation.'</td></tr>
<tr><td >Unit</td><td  align="right">'. $model->units->name.'</td></tr>
<tr><td >Division</td><td  align="right">'. $model->division->division_name.'</td></tr>
<tr><td >Department</td><td  align="right">'. $model->department->name.'</td></tr>
<tr><td >Category</td><td  align="right">'. $model->employee->category.'</td></tr>
<tr><td >Work Level</td><td  align="right">'. $model->work_level.'</td></tr>
<tr><td >Grade</td><td  align="right">'. $model->grade.'</td></tr>
<tr><td >PF No.</td><td  align="right">'. $model->statutory->epfno.'</td></tr>
<tr><td >ESI No.</td><td  align="right">'. $model->statutory->esino.'</td></tr>
<tr><td >UAN</td><td  align="right">'. $model->statutory->epfuanno.'</td></tr>
<tr><td >DOJ</td><td  align="right">'. Yii::$app->formatter->asDate($model->employee->doj, "php:d/m/Y").'</td></tr>
<tr><td >Paid days</td><td  align="right">'. $model->paiddays.'</td></tr>
<tr><td colspan="2" style="text-align:left;border-bottom: 1px solid #ccc;font-weight: 700;"> <br>Employer Contribution</td>
'.$employercontribution.'
<tr><td colspan="2" > <br></td>
<tr><td width="30%">CTC</td><td  width="70%" align="right">'. ($model->earned_ctc + $gpa_amt + $gmc_amt) .'</td></tr>
</table>
</div>
	<div style="float: right; width: 55%; margin-bottom: 0pt;padding-left:5px; ">
<table>
<tr ><td width="60%" style="border-bottom: 1px solid #ccc;font-weight: 700;">Components</td><td width="30%" align="right" style="border-bottom: 1px solid #ccc;font-weight: 700;">Actual</td><td width="30%" align="right" style="border-bottom: 1px solid #ccc;font-weight: 700;">Earnings</td></tr>
<tr><td>Base Pay</td><td align="right">'.$actual->basic.'</td><td align="right">'.$model->basic.'</td></tr>'.$earnings.'
<tr><td colspan="3" > <br></td>
<tr><td>Gross Earnings</td><td align="right">'.$actual->gross.'</td><td align="right">'.$model->total_earning.'</td></tr>	
<tr><td colspan="3" style="text-align:right;border-bottom: 1px solid #ccc;font-weight: 700;"> <br>Deductions</td>'.$deductions.'
<tr><td colspan="3" > <br></td>
<tr><td>Total Deduction</td><td align="right"></td><td align="right">'.$model->total_deduction.'</td></tr>	
<tr><td colspan="3" > <br></td>
<tr><td>NET PAY:</td><td align="right"></td><td align="right">'.$model->net_amount.'</td></tr>
<tr><td colspan="3"><b>In Words:</b> '.$model->employee->getIndianCurrency($model->net_amount).' Only</td></tr>	
</table>
</div>
</div>
<div  style="text-align: center;border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 7px 0 4px 0; display: flex;justify-content: space-around; ">
This is a system generated payslip. Hence signature not required.</div>';
 //$html .= "<pagebreak />";
//}
	 $mpdf=new mPDF();
		$mpdf->SetDisplayMode('fullpage');
		//ini_set("pcre.backtrack_limit", "5000000");
			$mpdf->useSubstitutions=false; 
			$mpdf->simpleTables = true;
		$mpdf->WriteHTML($html); // Separate Paragraphs defined by font
		$mpdf->Output();
		exit; 
/*<div style="text-align:left;border-bottom: 1px solid #ccc;font-weight: 700;">Employer Contribution</div> */
?>
