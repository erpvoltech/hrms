<?php

use yii\helpers\Html;
use Mpdf\Mpdf;
use common\models\EmpRemunerationDetails;
use common\models\EmpSalary;
use app\models\EmpStaffPayScale;
use common\models\EmpDetails;
use common\models\EmpStatutorydetails;
use common\models\StatutoryRates;
use app\models\EmpSalarystructure;
use common\models\EmpBenefits; 
use app\models\VgGpaHierarchy;
use app\models\VgGmcHierarchy;
use common\models\EmpGpaBenifits; 

$remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $model->empid])->one();
$pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
$Emp = EmpDetails::find()->where(['id' => $model->empid])->one();
$statutory = EmpStatutorydetails::find()->where(['empid' => $Emp->id])->one();
$totalactual = $model->basic + $model->dearness_allowance + $model->hra + $model->conveyance + $model->lta + $model->medical + $model->other_allowance;

$professional_tax = 0;
$provident_fund_er=0;

	if ($statutory->professionaltax == 'Yes') {
	 if ($model->gross_salary > 12500) {
		  $professional_tax = 209;
	   } else if ($model->gross_salary <= 12500 && $model->gross_salary > 10000) {
		  $professional_tax = 171;
	   } else if ($model->gross_salary <= 10000 && $model->gross_salary > 7500) {
		  $professional_tax = 115;
	   } else if ($model->gross_salary <= 7500 && $model->gross_salary > 5000) {
		  $professional_tax = 53;
	   } else if ($model->gross_salary <= 5000 && $model->gross_salary > 3500) {
		  $professional_tax = 23;
	   } else {
		  $professional_tax = 0;
	   } 			  
	}

 $statutory_rate_pf_esi = $model->gross_salary - $model->hra;

  
if ($model->pf_applicablity == 'Yes') {
    if ($model->restrict_pf == 'Yes') {
        if ($statutory_rate_pf_esi > 15000) {     
            $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
			$provident_fund_er = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100))+ (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));				
	
        } else {
            $provident_fund = round($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_ee / 100));
			$provident_fund_er = round(($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_2_er / 100))+ ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_21_er / 100)));			
			
        }
    } else {
        $provident_fund = round($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_ee / 100));
		$provident_fund_er = round(($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_2_er / 100))+ ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_21_er / 100)));			
	
    }
} else {
    $provident_fund = 0;
}



if ($model->esi_applicability == 'Yes') {
    if ($model->gross_salary <= 21000) {
        $employee_state_insurance = ceil(number_format(( $model->gross_salary * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
         } else {
        $employee_state_insurance = 0;      
    }
} else {
    $employee_state_insurance = 0;   
}

$pliAmt = round($model->basic * ($model->pli / 100));
$subtotalb = $provident_fund + $employee_state_insurance + $professional_tax;


	if($model->work_level == 'WL4A' || $model->work_level == 'WL4B' || $model->work_level == 'WL4C'){
		$worklevel = 'WL4';
	} else if($model->work_level == 'WL3A' || $model->work_level == 'WL3B' || $model->work_level == 'WL3C'){
		$worklevel = 'WL3';
	} else {
		$worklevel = $model->work_level;
	}

	/*if($model->work_level == 'WL5'){
		$benefits = EmpBenefits::find()->where(['wl' => $worklevel])->one();	
	} else {
		$benefits = EmpBenefits::find()->where(['wl' => $worklevel,'grade'=>$model->grade])->one();
	}*/
	
	if($model->work_level == 'WL2' || $model->work_level == 'WL4') {			
		$benefits = EmpBenefits::find()->where(['wl' => $model->work_level,'grade'=>$model->grade])->one();
	} else {
		$benefits = EmpBenefits::find()->where(['wl' => $model->work_level])->one();
	}
	
	
	if($model->work_level == 'WL5' || $model->work_level == 'WL6' || $model->work_level == 'WL3A' || $model->work_level == 'WL3B' || $model->work_level == 'WL4A' || $model->work_level == 'WL4B' || $model->work_level == 'WL4C'){		
		$benefits_gpa = EmpGpaBenifits::find()->where(['wl' => $model->work_level])->one();		
	} else {
		$benefits_gpa = EmpGpaBenifits::find()->where(['wl' => $model->work_level,'grade'=>$model->grade])->one();
	}
	
	    if($Emp->category == 'International Engineer'|| $Emp->category == 'Domestic Engineer'|| $Emp->category == 'BO Staff'){		
		$gpa_benefit = $benefits_gpa->engg;
		} else if($Emp->category == 'HO Staff'){
		$gpa_benefit = $benefits_gpa->staff;		
		} 
		
		if($Emp->designation->designation =='Driver' || $Emp->designation->designation =='Sr.Driver') {
			$gpa_benefit = $benefits_gpa->driver_security;
		}
		
		if($Emp->designation->designation =='Guard' || $Emp->designation->designation =='Security Guard') {
			$gpa_benefit = $benefits_gpa->driver_security;
		}		
		if($Emp->designation->designation =='Consultant') {
			$gpa_benefit = $benefits_gpa->consultant;
		}
		
  $gpa_fellow_share = VgGpaHierarchy::find()->where(['sum_insured' =>$statutory->gpa_sum_insured])->one();
  $gmc_fellow_share = VgGmcHierarchy::find()->where(['sum_insured' =>$statutory->gmc_sum_insured,'age_group'=>$statutory->age_group])->one();
	//print_r($gmc_fellow_share-);
	//exit;
	if($gpa_fellow_share->fellow_share){
			$gpa = round($gpa_fellow_share->fellow_share / 12);
	} else {
			$gpa = 125;
	}
	
	if($gmc_fellow_share->fellow_share){
			$gmc = round($gmc_fellow_share->fellow_share / 24);
	} else {
			if($totalactual >21000){
				$gmc = 150;
			} else {
				$gmc = 0;
			}
			
	}
	if($model->food_allowance == 'Yes'){
		$variable_allowance = 1500;		
		} else {	
		$variable_allowance = 0;		
		}
	$subtotalc = $provident_fund_er + $model->employer_esi_contribution + $pliAmt + $gpa + $gmc + $variable_allowance;

?>

<div style="padding:30px 0 5px 0">
<!--<div class="title"> <img src="<?=\Yii::$app->homeUrl?>img/logo.jpg" /></div> -->

</div> 
<br><br><br><br><br>
<table border="1" style="border-collapse: collapse; ">
<tr><td colspan="4" align="center" style="font-weight: bold;">Remuneration Description</td></tr>
<tr><td colspan="4" align="center" style="font-weight: bold;">Employment Details</td></tr>
<tr>
<td colspan="2">Name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?=$Emp->empname?></td>
<td colspan="2">Employee Code &nbsp; &nbsp; : <?=$Emp->empcode ?></td>
</tr>
<tr>
<td colspan="2">Designation &nbsp; &nbsp;&nbsp;  : <?=$Emp->designation->designation?></td>
<td colspan="2">Cardre &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: <?=$model->work_level.' '.$model->grade?></td>
</tr>
<tr>
<td colspan="2">Date of joining &nbsp;: <?=date('d.m.Y', strtotime($Emp->doj))?></td>
<td colspan="2">Date of Appraisal &nbsp; &nbsp;: <?=$Emp->appraisalmonth?></td>
</tr>
<tr>
<td colspan="2">Unit / Division &nbsp;  : <?=$Emp->units->name?> / <?=$Emp->division->division_name?></td>
<td colspan="2">Department &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?=$Emp->department->name?></td>
</tr>

<tr><td colspan="4" align="center" style="font-weight: bold;">SALARY COMPONENTS</td></tr>

<tr><td align="center"> Title </td><td align="center"> Per Month </td><td align="center"> Per Annum </td><td align="center"> Frequency of Payment </td></tr>
<tr><td> Basic </td><td style="text-align: right;"><?= number_format($model->basic,2,'.', '') ?></td><td  style="text-align: right;"><?= number_format($model->basic * 12,2,'.', '') ?></td><td align="center" rowspan="7">Monthly</td></tr>	
<tr><td> House Rent Allowance(HRA) </td><td style="text-align: right;"><?= number_format($model->hra,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($model->hra * 12,2,'.', '') ?></td></tr>
<tr><td> Dearness Allowance(DA) </td><td style="text-align: right;"><?= number_format($model->dearness_allowance,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($model->dearness_allowance * 12,2,'.', '') ?></td></tr>
<tr><td> Conveyance Allowance </td><td style="text-align: right;"><?= number_format($model->conveyance,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($model->conveyance * 12,2,'.', '') ?></td></tr>
<tr><td> Leave Travel Allowance(LTA) </td><td style="text-align: right;"><?= number_format($model->lta,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($model->lta * 12,2,'.', '') ?></td></tr>
<tr><td> Medical Allowance(MA) </td><td style="text-align: right;"><?= number_format($model->medical,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($model->medical * 12,2,'.', '') ?></td></tr>
<tr><td> Personal Pay </td><td style="text-align: right;"><?= number_format($model->other_allowance,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($model->other_allowance * 12,2,'.', '') ?></td></tr>
<tr><td> <b>Gross Earnings(A)</b><sup><b>**</b></sup> </td><td style="text-align: right; font-weight: bold;"> <?= number_format($totalactual,2,'.', '') ?></td><td style="text-align: right; font-weight: bold;"> <?= number_format($totalactual * 12,2,'.', '') ?></td><td align="center">**TDS Applicable</td></tr>
    
<tr></td><td colspan="4" align="center" style="font-weight: bold;">Deductions</td></tr>

<tr><td> EPF Contribution (Employee) </td><td style="text-align: right;"><?= number_format($provident_fund,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($provident_fund * 12,2,'.', '') ?></td><td align="center" rowspan="6">Monthly Contributions remitted / Accumulated under Appropriate authorities; shall be claimed on relevant periods.</td></tr>	
<tr><td> ESIC Contribution (Employee) </td><td style="text-align: right;"><?= number_format($employee_state_insurance,2,'.', '')?></td><td style="text-align: right;"><?= number_format($employee_state_insurance * 12,2,'.', '') ?></td></tr>
<tr><td> Professional Tax </td><td style="text-align: right;"><?= number_format($professional_tax,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($professional_tax * 12,2,'.', '') ?></td></tr>
<tr><td> Others </td><td style="text-align: right;">0.00</td><td style="text-align: right;">0.00</td></tr>
<tr><td style="font-weight: bold;"> Sub Total(B) </td><td style="text-align: right;font-weight: bold;"><?= number_format($subtotalb,2,'.', '')?></td><td style="text-align: right; font-weight: bold;"><?= number_format($subtotalb * 12,2,'.', '') ?></td></tr>
<tr><td style="font-weight: bold;"> Net Salary (A-B) </td><td style="text-align: right; font-weight: bold;"><?= number_format(($totalactual) - ($subtotalb),2,'.', '')?></td><td style="text-align: right; font-weight: bold;"><?= number_format(($totalactual * 12) - ($subtotalb * 12),2,'.', '') ?></td></tr>

<tr><td colspan="4" align="center" style="font-weight: bold;">Employer Contribution</td></tr>

<tr><td> EPF Contribution  </td><td style="text-align: right;"><?=  number_format($provident_fund_er,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($provident_fund_er * 12,2,'.', '') ?></td><td align="center" rowspan="7">Monthly Contributions remitted / Accumulated under Appropriate authorities; shall be claimed on relevant periods. <br><br> Variable Admin Cost includes Food & Transport Expenses even if not utilized, It can't be refunded.</td></tr>		
<tr><td> ESIC Contribution  </td><td style="text-align: right;"><?=  number_format($model->employer_esi_contribution,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($model->employer_esi_contribution * 12,2,'.', '') ?></td></tr>
<tr><td> Personal Accident Insurance </td><td style="text-align: right;"><?= number_format($gpa,2,'.', '')?></td><td style="text-align: right;"><?= number_format(($gpa*12),2,'.', '') ?></td></tr>
<tr><td> Medical Insurance </td><td style="text-align: right;"><?= number_format($gmc,2,'.', '') ?></td><td style="text-align: right;"><?= number_format(($gmc*12),2,'.', '') ?></td></tr>
<tr><td> Bonus </td><td style="text-align: right;"><?=  number_format($model->employer_pli_contribution,2,'.', '')?></td><td style="text-align: right;"><?= number_format($model->employer_pli_contribution * 12,2,'.', '') ?></td></tr>
<tr><td> Variable Admin Cost </td><td style="text-align: right;"><?=number_format($variable_allowance,2,'.', '')?></td><td style="text-align: right;"><?=number_format($variable_allowance * 12,2,'.', '')?></td></tr>
<tr><td align="center"><b> Sub total(C) </b></td><td style="text-align: right;"><?=number_format($subtotalc,2,'.', '') ?></td><td style="text-align: right;"><?= number_format($subtotalc * 12,2,'.', '') ?></td></tr>
<tr><td align="center"><b>COST TO THE COMPANY(A+C) </b></td><td style="text-align: right; font-weight: bold;"> <?= number_format($totalactual + $subtotalc,2, '.','')?></td><td style="text-align: right; font-weight: bold;"> <?= number_format(($totalactual + $subtotalc) * 12,2,'.', '') ?></td><td></td></tr>


<tr><td colspan="4" align="center" style="font-weight: bold;">Other Benefits / Eligibility </td></tr>

<tr><td> Travel mode Eligibility </td><td colspan="2"><?=$benefits->travelmode_ts?></td> <td align="center" rowspan="5">The Eligibility values depends on work level, which is subjected to change by Management Discretion. Insurance Premium value shall differ based upon the offer by Insurer.</td></tr>
<tr><td> Insurance Coverage / Annum</td><td>GPA-<?=$gpa_benefit?> Lakhs </td><td><?php if($model->esi_applicability == 'No'){ ?>GMC - <?=$benefits->gmc?> Lakhs <?php } ?></td></tr>
<tr><td> Lodging Allowance</td><td><?=$benefits->lodging_metro?>(Metro)</td><td><?=$benefits->lodging_nonmetro?>(Non Metro)</td></tr>
<tr><td> Boarding Allowance </td><td><?=$benefits->boarding_metro?>(Metro)</td><td><?=$benefits->boarding_nonmetro?>(Non Metro)</td></tr>
<tr><td> Others </td><td align="center">-</td><td align="center">-</td></tr>

<tr><td colspan="2" style="border-right: 0px solid #ccc;border-bottom: 0px solid #ccc">For VOLTECH Engineers Private Limited,</td> <td colspan="2" style="border-left: 0px solid #ccc;border-bottom: 0px solid #ccc"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Received and Accepted</td></tr>

<tr><td colspan="4" style="border-top: 0px solid #ccc;"> <?php /*Html::img("@web/img/signature.png")*/?> <br> <br> <br> <br>
<b>M.UMAPATHI </b>&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;
&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;
&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;
<?=$Emp->empname?><br>
<b>Managing Director</b>&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;
&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;
&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; Date:</td></tr>

</table>