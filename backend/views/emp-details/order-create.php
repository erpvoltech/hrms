<?php
use yii\helpers\Html;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use app\models\AppointmentLetter;
use common\models\Department;
use common\models\Designation;
use common\models\EmpRemunerationDetails;
use common\models\EmpStatutorydetails;
use app\models\VgGpaHierarchy;
use app\models\VgGmcHierarchy;
use common\models\StatutoryRates;
use yii\widgets\ActiveForm;

$this->title ='Appointment Order';
$this->params['breadcrumbs'][] = ['label' => 'Emp Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

 $id = $_GET['id']; // style='padding-bottom: 10px';

      $emp = EmpDetails::findOne($id);
      $remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $id])->one();
      $empadd = EmpAddress::find()->where(['empid' => $id])->one();
	  
	$pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
	
         $Designation = Designation::find()
                 ->where(['id' => $emp->designation_id])
                 ->one(); 
				 
		$statutory = EmpStatutorydetails::find()->where(['empid' => $emp->id])->one();
		
		  $gpa_fellow_share = VgGpaHierarchy::find()->where(['sum_insured' =>$statutory->gpa_sum_insured])->one();
		  $gmc_fellow_share = VgGmcHierarchy::find()->where(['sum_insured' =>$statutory->gmc_sum_insured,'age_group'=>$statutory->age_group])->one();

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
			
		if($remunerationmodel->food_allowance == 'Yes'){
		$variable_allowance = 1500;		
		} else {	
		$variable_allowance = 0;		
		}
		
	 $statutory_rate_pf_esi = $remunerationmodel->gross_salary - $remunerationmodel->hra;
		
	/*if ($remunerationmodel->pf_applicablity == 'Yes') {
    if ($remunerationmodel->restrict_pf == 'Yes') {
        if ($statutory_rate_pf_esi > 15000) {     
            $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
			$provident_fund_er = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));				
	
        } else {
            $provident_fund = round($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_ee / 100));
			$provident_fund_er = round(($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_21_er / 100)));				
			
        }
    } else {
        $provident_fund = round($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_ee / 100));
		$provident_fund_er = round(($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_21_er / 100)));				
	
    }
	} else {
		$provident_fund = 0;
	}*/
	
	if ($remunerationmodel->pf_applicablity == 'Yes') {
    if ($remunerationmodel->restrict_pf == 'Yes') {
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

$pliAmt = round($remunerationmodel->basic * ($remunerationmodel->pli / 100));
		
		if ($emp->category == 'HO Staff' || $emp->category == 'BO Staff' ){
		
		//$ctc = ($remunerationmodel->ctc - $remunerationmodel->employer_pf_contribution) + $gpa + $gmc + $variable_allowance + $provident_fund_er;		
		
		 $totalactual = $remunerationmodel->basic + $remunerationmodel->dearness_allowance + $remunerationmodel->hra + $remunerationmodel->conveyance + $remunerationmodel->lta + $remunerationmodel->medical + $remunerationmodel->other_allowance;
		 $subtotalc =  round($provident_fund_er + $remunerationmodel->employer_esi_contribution + $pliAmt + $variable_allowance + ($statutory->gpa_premium/12) + ($statutory->gmc_premium/24));
		
		$ctc = $totalactual + $subtotalc;
		
		} else {
		
		/*$ctc = ($remunerationmodel->ctc - $remunerationmodel->employer_pf_contribution - $remunerationmodel->employer_esi_contribution)+ $statutory->gpa_premium/12 + $statutory->gmc_premium/24 + $variable_allowance + 1950;*/		
		
		$totalactual = $remunerationmodel->basic + $remunerationmodel->dearness_allowance + $remunerationmodel->hra + $remunerationmodel->conveyance + $remunerationmodel->lta + $remunerationmodel->medical + $remunerationmodel->other_allowance;
		
		$subtotalc =  round(1950 + $remunerationmodel->employer_esi_contribution + $pliAmt + $variable_allowance + ($statutory->gpa_premium/12) + ($statutory->gmc_premium/24));
		
		$ctc = $totalactual + $subtotalc;
	
		}
			
		$familymodel = EmpFamilydetails::find()->where(['relationship'=>'father','empid'=>$id])->one();
		$persional = EmpPersonaldetails::find()->where(['empid'=>$id])->one();
		if($familymodel) {
			if($persional->gender == 'Male'){$add_title  = 'S/o Mr.'.$familymodel->name;} 
			else if($persional->gender == 'Female'){$add_title  = 'D/o Ms.'.$familymodel->name;} 
			else {$add_title  = NULL;}
		} else {
			if($persional->gender == 'Female'){
				$familymodelFemale = EmpFamilydetails::find()->where(['relationship'=>'husband','empid'=>$id])->one();
					if($familymodelFemale) {$add_title  = 'W/o Ms.'.$familymodelFemale->name;}
					else {
					$familymodelFemaleTwo = EmpFamilydetails::find()->where(['relationship'=>'spouse','empid'=>$id])->one();
						if($familymodelFemaleTwo) {$add_title  = 'W/o Ms.'.$familymodelFemaleTwo->name;}
						else {$add_title  = NULL;}				
					}
			} else {$add_title  = NULL;}		
		}
		
	if($persional->gender == 'Male') {
			$salutation ='Mr. ';
			} elseif($persional->gender == 'Female') {
			$salutation ='Ms. ';
			} else {
			$salutation = 'Dear ';
		 }

		if( $remunerationmodel->salary_structure =='Contract') {
         $letter = '<div style="font-family:Century Gothic;font-size:14px">
		<p><strong><em>Ref: VEPL/HR/2021-22/APP/' . $emp->empcode . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Date: ' . Yii::$app->formatter->asDate($emp->doj, "dd-MM-yyyy") . '</em></strong></p>

		<p>&nbsp;</p>

		<p><strong>' . $salutation . $emp->empname . ',</strong><br />';
		if($add_title)
			$letter .= '<strong>' . $add_title . ',</strong><br />';		
         if ($empadd->addfield1 != '')
            $letter .= '<strong>' . $empadd->addfield1 . ',</strong><br />';
         if ($empadd->addfield2 != '')
            $letter .='<strong>' . $empadd->addfield2 . ',</strong><br />';
         if ($empadd->addfield3 != '')
            $letter .='<strong>' . $empadd->addfield3 . ',</strong><br />';
         if ($empadd->addfield4 != '')
            $letter .='<strong>' . $empadd->addfield4 . ',</strong> ';
         if ($empadd->addfield5 != '')
            $letter .='<strong>' . $empadd->addfield5 . ',</strong> ';
		
	

         $letter .='<strong>' . $empadd->district . ',</strong> <strong>' . $empadd->state .' - '. $empadd->pincode . '.</strong></p>

		

		<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Sub: Appointment Letter</strong></p>

		<p>Dear <strong>' . $salutation . $emp->empname . ', </strong></p>

		<p>We are pleased to appoint you as “<strong>'. $Designation->designation .'</strong>” on contractual basis in our organization on the following terms and conditions.</p>
<ol>
    <li style="text-align:justify">
	You’re appointed for a fixed period of <strong>'. $emp->probation .'</strong>, which is beginning from <strong>'.Yii::$app->formatter->asDate($emp->doj, "dd-MM-yyyy").'</strong> under Employee Code <strong>'.$emp->empcode.'</strong>
	</li>
	
    <li style="text-align:justify">
	You shall be entitled to a CTC of <strong>Rs. '.$ctc.'</strong> per month which includes your gross salary <strong>Rs. '. $remunerationmodel->gross_salary.'</strong>, EPF, ESI, Insurance and Bonus employer contributions.
	</li>
	
	<li style="text-align:justify">
	You will be entitled to take leave as per the rules operational in the company and which is subjected to change.
	</li>
	
	<li style="text-align:justify">
	Be it clearly understood and agreed that the vacancy for fixed period employment has arisen due to unusual pressure of seasonal work and as such your appointment is being made on contractual basis for a fixed period as stated above in accordance you’re the provisions of certified standing orders of this industrial undertaking. Your contractual appointment will automatically come to an end on the expiry of the specified period and no notice pay or retrenchment compensation will be payable to you by the management. Since your appointment is being made for a specified period, you will neither have any right nor a lien on the job held by you. Also you will not claim regular employment even if there is such a vacancy for the post held by you or otherwise. Except one month’s notice or salary in lieu of one month’s notice  no compensation or remaining wages for unexpired period of contractual and fixed period of appointment will be payable by the management if your service are terminated before the aforesaid specified and fixed period of your service.
	</li>
	
	<li style="text-align:justify">
	Your duties will include efficient, satisfactory and economical operation in the area of responsibility that may be assigned to you from time to time. As an employee of this company, you will maintain a high standard of loyalty, integrity and will liaison with employees/ workers in the factory.
	</li>
	
	<li style="text-align:justify">
	You will devote your whole time and attention to the interest of the company and will not engage yourself in any other work either paid or in honorary capacity.
	</li>
	
	<li style="text-align:justify">
	The management will be with its rights to transfer you for work or loan your service to any other unit/division/department where the company has an office or branch or unit or site for work at any time in future.
	</li>
	
	<li style="text-align:justify">
	Your appointment is being made on the basis of your particulars such as qualification etc., as given by you in your application for employment and in case any information as given by you is found false or incorrect, your appointment will be deemed void ab initio and liable for termination without any notice or salary in lieu of notice.
	</li>
	
	<li style="text-align:justify">
	Your address as indicated in your application for appointment shall be deemed to be correct for sending any communication to you every communication addressed to you at the given address shall be deemed to have been served upon you.
	</li>
	
	<li style="text-align:justify">
	You will be bound by the certified standing orders, rules, regulations and office orders in force and framed by the company from time to time in relation to your service conditions, which will form part of your terms of employment.
	</li>
	
	<li style="text-align:justify">
	In case there is any change in your residential address, you will intimate the same in writing to the personnel Department/Manager within three days from the date of such change and get such change of address recorded.
	</li>
	
	<li style="text-align:justify">
	You will be responsible for safekeeping and return in good condition and order of all Company property, which may be in your use or custody.
	</li> 
	</ol>
	<p>
	If the above terms and conditions are acceptable by you, please sign the carbon copy in token of its acceptance and return the same for our record. We welcome you to the VOLTECH group and look forward to a fruitful collaboration.
	</p><br>
	<p>With Best Wishes,</p>
	
	<p><strong>For VOLTECH Engineers Private Limited,</strong></p>';
	if($emp->unit_id == 1) {
		$letter .= Html::img("@web/img/icd1.png").'
		 <p><strong>A.Balamurugan</strong><br /><strong>Sr. Vice President (IC D1)</strong></p>';
	} else if($emp->unit_id == 2) {
		$letter .= Html::img("@web/img/icd2.png").' 
		<p><strong>A.Rajarajan</strong><br /><strong>Sr. General Manager (IC D2)</strong></p>';
	} else if($emp->unit_id == 4) {
	 $letter .= Html::img("@web/img/icc&i.png").' 
		<p><strong>S.M.Chandra Mohan</strong><br /><strong>Unit Head (IC C&I) </strong></p>';
	} else if($emp->unit_id == 19) {
	 $letter .= Html::img("@web/img/ics.png").' 
		<p><strong>K.Ramesh</strong><br /><strong>Asst. Vice President (IC CS) </strong></p>';
	}
	
	} else {
		
		  $letter = '<div style="font-family:Century Gothic;font-size:14px">
		<p><strong><em>Ref: VEPL/HR/2021-22/APP/' . $emp->empcode . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Date: ' . Yii::$app->formatter->asDate($emp->doj, "dd-MM-yyyy") . '</em></strong></p>

		<br>

		<p><strong>' .$salutation.$emp->empname . ',</strong><br />';
		
		 if($add_title)
			$letter .= '<strong>' . $add_title . ',</strong><br />';
         if ($empadd->addfield1 != '')
            $letter .= '<strong>' . $empadd->addfield1 . ',</strong><br />';
         if ($empadd->addfield2 != '')
            $letter .='<strong>' . $empadd->addfield2 . ',</strong><br />';
         if ($empadd->addfield3 != '')
            $letter .='<strong>' . $empadd->addfield3 . ',</strong><br />';
         if ($empadd->addfield4 != '')
            $letter .='<strong>' . $empadd->addfield4 . ',</strong> ';
         if ($empadd->addfield5 != '')
            $letter .='<strong>' . $empadd->addfield5 . ',</strong> ';
		
	

         $letter .='<strong>' . $empadd->district . ',</strong> <strong>' . $empadd->state .' - '. $empadd->pincode . '.</strong></p>

		

		<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Sub: Appointment Letter</strong></p>

		<p>Dear <strong>' . $salutation . $emp->empname . ', </strong></p>

		<p>We are pleased to appoint you in the position of<strong> &ldquo;' . $Designation->designation . '&rdquo;</strong> under the following terms and conditions.</p>
		       <ol>
			<li style="padding-bottom: 10px"><strong>EFFECTIVE DATE OF APPOINTMENT: ' . Yii::$app->formatter->asDate($emp->doj, "dd-MM-yyyy") . '</strong></li>
			<li style="padding-bottom: 10px"><strong>EMPLOYEE NUMBER</strong><strong>:' . $emp->empcode . '</strong> &amp; <strong>Work Level</strong> : <strong>' . $remunerationmodel->work_level .' '.$remunerationmodel->grade. '</strong></li>
			<li style="padding-bottom: 10px"><strong>SALARY &amp; ALLOWANCE</strong><strong>:</strong> You shall be entitled to an annual CTC of <strong>Rs.' . $ctc * 12 . '/- </strong>(' . $emp->getIndianCurrency($ctc * 12) . 'Only) Payable per annum as per Annexure.</li>';
				
				if(!empty($emp->probation)){
					if ($emp->joining_status == 'Experienced'){
					$letter .='<li style="padding-bottom: 10px"><strong>PROGRESSION:</strong> You shall work under the terms of this letter for a period of <strong>'.$emp->probation.'</strong>. Further Progression will be subjected to your satisfactory performance.</li>';
					} else {
					 $letter .='<li style="padding-bottom: 10px"><strong>PROBATION</strong><strong>:</strong> You will be on probation for a period of <strong>'.$emp->probation.'</strong>. Your Confirmation will be subjected to satisfactory performance during the probation period.</li>';			
					}				
				}
				
				
			$letter .='<li style="padding-bottom: 10px"><strong>FULL TIME EMPLOYMENT:</strong> This is a full time employment, and therefore you shall devote full time to the work of the company and will not undertake any direct / indirect business or work, honorary or remuneratory, except with prior written permission of the management, in each case.</li>
			<li style="padding-bottom: 10px"><strong>TRANSFER</strong> : You will be liable to be transferred from one department to another, one section to another, one branch to another, one establishment to another&nbsp; or to any of its associate companies, in India or abroad, either existing today or to be started at any time subsequent to your employment.</li>
			<li style="padding-bottom: 10px"><strong>DOCUMENTS:</strong> Your appointment is valid subjected to submission of these documents on the joining date.
					<ul>
						<li>Latest Degree Certificate and Police Verification Certificate (Original).</li>
						<li>Photocopies of your ID / Address Proofs, All Educational Certificates.</li>
						<li>Three passport size Photographs, One Family photo (visiting card size).</li>
					</ul>
			</li>
			<li style="padding-bottom: 10px"><strong>MEDICAL FITNESS</strong><strong>:</strong> This appointment and its continuance are subjected to your being found & remaining in sound physical and mental health. As and when required you shall report for any medical examination to a qualified doctor as rectified by the Govt. / appointed by the company.</li>
			<li style="padding-bottom: 10px"><strong>LEAVE</strong><strong>:</strong> On Completion of your probation (if any), you will be entitled to earned leave and casual leave as per the rules operational in the company and which is subjected to change.</li>
			<li style="padding-bottom: 10px"><strong>COMMUNICATION ADDRESSES:</strong> Your mailing addresses as given in the application will be deemed to be correct for the purpose of sending any communication to you. In case of any change in the same, you will inform the management in writing.</li>';			
			
			if ($emp->category == 'HO Staff' || $emp->category == 'BO Staff' ){
			$letter .='<li style="padding-bottom: 10px"><strong>BENEFITS:</strong> Your official tour travel expenses shall be met by the company subjected to the work level eligibility. 
						You shall be covered under Personal Accident and Medical Insurances on welfare basis as per work level. On separation, your coverage under the policies will be ceased immediately without prior notice. 
						If lodging facilities are not provided at any project, respective allowances shall be claimed at actual not higher than the Work Level eligibility.
						You shall be made as a member of our company’s CUG Mobile network and the bills of the SIM shall be claimed at actual.</li>';
			} else {
			$letter .='<li style="padding-bottom: 10px"><strong>BENEFITS:</strong> Your official tour travel expenses shall be met by the company subjected to the work level eligibility. 
						You shall be covered under Personal Accident and Medical Insurances on welfare basis as per work level. On separation, your coverage under the policies will be ceased immediately without prior notice. 
						If lodging facilities are not provided at any project, respective allowances shall be claimed at actual not higher than the Work Level eligibility.
						</li>';
			}						
			$letter .='<li style="padding-bottom: 10px"><strong>SECRECY:</strong> During the term of your appointment and for two (2) year after its termination, you shall not disclose, divulge to anyone by word of mouth or otherwise the content of this appointment letter, particulars or details of products, developing process, technical knowhow, administrative or organizational matters, client data and information, proprietary information pertaining to the company either directly or indirectly, which may be your personal privilege to know by virtue of being in employment of the company.</li>';
			if ($emp->category == 'HO Staff' || $emp->category == 'BO Staff' ){
			$letter .='<li style="padding-bottom: 10px"><strong>TERMINATION:</strong> This agreement can be terminated by either party by giving Thirty (30) days written notice or two (2) months&rsquo; salary. Upon termination of employment, all the company documents, information and property, business cards, office keys must be returned to the office prior to leaving.</li>';
			} else {
			$letter .='<li style="padding-bottom: 10px"><strong>TERMINATION:</strong> This agreement can be terminated by either party by giving Ninety (90) days written notice or Six (6) months&rsquo; salary. Upon termination of employment, all the company documents, information and property, business cards, office keys must be returned to the office prior to leaving.</li>		
			<li style="padding-bottom: 10px"><strong>BUSINESS LOSS COMPENSATION:</strong> You are liable to work minimum 5 years in our organization. In case of your resignation before completing 5 years of service (from the date of joining), you will have to pay a sum of Rs.1,00,000/-(Rupees One Lakh) towards business loss, On-the-Job training cost and administrative expenses. You shall not avail Experience Certificate, Conduct Certificate etc.</li>';			
			 }			
			$letter .='<li style="padding-bottom: 10px">
			<strong>CODE OF CONDUCT:</strong> You shall conduct all activities under this appointment in accordance with sound business practices and ethics and in a manner which reflects favorably upon the company and its products and the goodwill associated herewith. We comply with The Sexual Harassment committee under Section 4(1)a.</li>
			<li style="padding-bottom: 10px">
			Please ensure that all the document submitted by you and the details provided in the company application form are authentic and accurate. In the event the said particulars are found to be incorrect or that you have withheld some other relevant facts your appointment in the company shall stand cancelled without any notice. Your appointment and continuance in employment is also subjected to our receiving a satisfactory independent reference check.
			</li>
		</ol>

		<p>You shall conduct all activities under this appointment in accordance with sound business practices and ethics and in a manner which reflects favorably upon the company and its products and the goodwill associated herewith.</p>

		<p>The appointment will be governed by the Indian laws and be subjected to the jurisdiction of Chennai court.</p>

		<p>Please submit to us the written acceptance of this offer by signing the second copy of this letter.</p>

		<p>We welcome you to VOLTECH Group of Companies, and look forward to your continued growth with us. We are sure you will enjoy being part of the team.</p>
		
			<p>Yours Sincerely.</p>

		<p><strong>For VOLTECH Engineers Private Limited,</strong></p>

		'.Html::img("@web/img/signature.png").' 

		<br><p><strong>M.UMAPATHI</strong><br /><strong>Managing Director</strong></p>

		<p>&nbsp;</p>

		<p><strong>Declaration:</strong></p>

		<p>I have carefully read this appointment letter and I willingly and unconditionally accept to abide the terms and the conditions prescribed therein.</p>

		<p>Place &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature&nbsp;&nbsp;&nbsp; :</p>

		<p>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</p></div>';

		}
$model->letter = $letter;
?>

<div class="order-create">
    <?= $this->render('editor-app', [
        'model' => $model,
		]) ?>

</div>