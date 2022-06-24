<?php
error_reporting(0);

use yii\helpers\Html;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use common\models\EmpEducationdetails;
use common\models\EmpCertificates;
use common\models\EmpBankdetails;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use common\models\Qualification;
use common\models\Course;
use common\models\College;
use common\models\EmpStatutorydetails;
use common\models\PreviousEmployment;/*
use app\models\AppointmentLetter;
use app\models\VgGpaPolicy;
use app\models\VgGpaHierarchy;
use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementHierarchy;
use app\models\VgGmcPolicy;
use app\models\VgGmcHierarchy;
use app\models\VgGmcEndorsement;
use app\models\VgGmcEndorsementHierarchy;*/
use common\models\EmpGpaBenifits; 

$PersonalModel = EmpPersonaldetails::find()->where(['empid' => $model->id])->one();
$AddressModel = EmpAddress::find()->where(['empid' => $model->id])->one();
$EducationModel = EmpEducationdetails::find()->where(['empid' => $model->id])->all();
$certificateModel = EmpCertificates::find()->where(['empid' => $model->id])->all();
$bankModel = EmpBankdetails::find()->where(['empid' => $model->id])->all();
$Sibiling = EmpFamilydetails::find()->where(['empid' => $model->id])->all();
$statutoryModel = EmpStatutorydetails::find()->where(['empid' => $model->id])->one();
$PreviousEmployment = PreviousEmployment::find()->where(['empid' => $model->id])->one();
//$orderempid = AppointmentLetter::find()->where(['empid' => $model->id])->one();

/*
	if($statutoryModel->gpa_no){
		$gpa = VgGpaPolicy::find()->where(['policy_no'=>$statutoryModel->gpa_no])->one();
		$gpahierarch = VgGpaHierarchy::find()->where(['sum_insured' =>$statutoryModel->gpa_sum_insured,'gpa_policy_id'=>$gpa->id])->one();
		if ($gpahierarch) {		
		 $gpa_amt = round($gpahierarch->fellow_share/12);	 
		} else{
			$gpaendo = VgGpaEndorsement::find()->where(['endorsement_no'=>$statutoryModel->gpa_no])->one();
			$gpaendohierarch = VgGpaEndorsementHierarchy::find()->where(['endorsement_sum_insured' =>$statutoryModel->gpa_sum_insured,'gpa_endorsement_id'=>$gpaendo->id])->one();
			
			$gpa_amt = round($gpaendohierarch->endorsement_fellow_share /12 );
			
		}	
	} else if($statutoryModel->gpa_applicability == 'Yes') {	
		$gpa_amt = 125;
	} else {
	   $gpa_amt = 0;
	}	
	
	if($statutoryModel->gmc_no){
		$gmc = VgGmcPolicy::find()->where(['policy_no'=>$statutoryModel->gmc_no])->one();
		$gmchierarch = VgGmcHierarchy::find()->where(['sum_insured' =>$statutoryModel->gmc_sum_insured,'gmc_policy_id'=>$gmc->id,'age_group'=>$statutoryModel->age_group])->one();
		if ($gmchierarch) {		
		 $gmc_amt = round($gmchierarch->fellow_share/24);	 
		} else{
			$gmcendo = VgGmcEndorsement::find()->where(['endorsement_no'=>$statutoryModel->gmc_no])->one();
			$gmcendohierarch = VgGmcEndorsementHierarchy::find()->where(['endorsement_sum_insured' =>$statutoryModel->gmc_sum_insured,'gmc_endorsement_id'=>$gmcendo->id,'endorsement_age_group'=>$statutoryModel->age_group])->one();
			
			 $gmc_amt = round($gmcendohierarch->endorsement_fellow_share /24 );
			
		}	
	} else if($statutoryModel->gmc_applicability == 'Yes') {	
		$gmc_amt = 150;
	} else {
	   $gmc_amt = 0;
	}	
	*/
		
if($model->remuneration->food_allowance == 'Yes'){
	$food_allowance = 1500;		
	} else {	
	$food_allowance = 0;		
	}


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Emp Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
 <style>
   .b{
     color:#fff;
     visibility: hidden
   }
   .text{
     color: #009933 ;
     font-weight:bold;
     font-size:16px;

   }   
   .addrline {
     border-bottom: 1px solid;
     color: #942509;
     font-weight: normal;
     font-size: 14px;
     margin-bottom: 1em;
     padding-bottom: 2px;
   }
      .col-md-10,.col-md-2 {
    position: relative;
    min-height: 1px;
     padding-right: 5px; 
     padding-left: 5px; 
}

 </style>
<div class="emp-details-view">
	<div class="row">
	
<div class="col-md-10">
    <div class="panel panel-info">
        <div class="panel-heading">          
                <div class="pull-right" style="padding-right:10px"> 
				        <a href="index.php?r=project-details/print-empdetails&id=<?=$model->id?>" title="Print" target="_blank"><i class='glyphicon glyphicon-print' style="padding-right:10px"></i></a>
						  <!--<a href="update?id=<?=$model->id?>" title="Edit"><i class='glyphicon glyphicon-edit' style="padding-right:10px"></i></a>-->
                </div>
                <h3 class="panel-title">Employee ID: <?= $model->empcode ?></h3>          
        </div>
        <div class="panel-body" style="padding: 5px"> 
              <table class="table  table-condense" style="font-size:12px;" >
           
		   
		   
                <tr class="" ><th colspan="4">  <div class="addrline"><span class="text" > General</span></div></th></tr>
				
				
				
               <tr><th style ="text-align : right;width:200px">Employment Code</th><td style ="text-align : left;width:400px"><?= $model->empcode ?> ( PASS - <?= $model->emp_password ?>)</td>	<th style ="text-align : right;width:200px">Name</th><td style ="text-align : left;width:400px"><?= $model->empname ?></td></tr>	
                
               <tr><th style ="text-align : right">Date of Joining</th><td><?php if($model->doj =='1970-01-01' ||$model->doj ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->doj));}?></td> <th style ="text-align : right">Date of Birth (as per document)</th><td> <?php if($PersonalModel->dob == '1970-01-01' ||$PersonalModel->dob ==NULL ){ echo ' ';} else { echo date('d.m.Y', strtotime($PersonalModel->dob));}?></td></tr>
				  <tr><th style ="text-align : right">Designation</th><td><?= $model->designation->designation ?></td> <th style ="text-align : right">Department</th><td><?= $model->department->name ?></td></tr>              
                <tr><th style ="text-align : right">Division</th><td><?= $model->division->division_name ?></td><th style ="text-align : right">Unit</th><td><?= $model->units->name ?></td></tr>                         
			   <tr><th style ="text-align : right">Email(Official)</th><td><?= $model->email ?></td> <th style ="text-align : right">Mobile No(Official)</th><td><?= $model->mobileno ?></td></tr>
                 <tr><th style ="text-align : right">Email(Personal)</th><td><?= $PersonalModel->email ?></td> <th style ="text-align : right">Mobile No(Personal)</th><td><?= $PersonalModel->mobile_no ?></td></tr>               
				<tr> <th style ="text-align : right">Probation Period</th><td><?= $model->probation ?></td> <th style ="text-align : right">Confirmation Date</th><td> <?php if($model->confirmation_date =='1970-01-01' ||$model->confirmation_date ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->confirmation_date));}?></td> </tr>
                <tr><th style ="text-align : right">Appraisal Month</th><td><?= $model->appraisalmonth ?></td> <th style ="text-align : right">Latest Promotion Date</th><td> <?php if($model->recentdop =='1970-01-01' ||$model->recentdop ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->recentdop));}?> </td></tr>	
                <tr><th style ="text-align : right">Date of Leaving</th><td> <?php if($model->dateofleaving =='1970-01-01' ||$model->dateofleaving ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->dateofleaving));}?> <th style ="text-align : right">Latest Working Date</th><td> <?php if($model->last_working_date =='1970-01-01' ||$model->last_working_date ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->last_working_date));}?> </td></tr>              
				<tr> <th style ="text-align : right">Reason for Leaving</th><td><?= $model->reasonforleaving ?></td><th style ="text-align : right">Referred by</th><td><?= $model->referedby ?></td> 
				<tr> <th style ="text-align : right">Joining Status</th><td><?= $model->joining_status ?></td> <th style ="text-align : right">Status</th><td><?= $model->status ?></td></tr> 
			<tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Remuneration Details</span></div></th></tr>
			
			<tr> <th style ="text-align : right">Salary Structure </th><td><?= $model->remuneration->salary_structure ?></td> <th style ="text-align : right">attendance_type</th><td><?= $model->remuneration->attendance_type ?></td></tr> 
			<tr> <th style ="text-align : right">Work Level </th><td><?= $model->remuneration->work_level ?></td> <th style ="text-align : right"> Grade</th><td><?= $model->remuneration->grade ?></td></tr> 
			<tr> <th style ="text-align : right">ESI Applicability </th><td><?= $model->remuneration->esi_applicability ?></td> <th style ="text-align : right"> PF Applicability</th><td><?= $model->remuneration->pf_applicablity ?></td></tr> 
			<tr> <th style ="text-align : right">Restrict PF </th><td><?= $model->remuneration->restrict_pf ?></td><th style ="text-align : right"> Zero Pension(if Applicable)</th><td> <?= $statutoryModel->zeropension ?> </td></tr> 
			<tr> <th style ="text-align : right">Basic </th><td><?= $model->remuneration->basic ?></td> <th style ="text-align : right"> HRA</th><td><?= $model->remuneration->hra ?></td></tr> 
			<tr> <th style ="text-align : right">Spl. allowance </th><td><?= $model->remuneration->splallowance ?></td> <th style ="text-align : right"> Dearness Allowance(DA)</th><td><?= $model->remuneration->dearness_allowance ?></td></tr> 
			<tr> <th style ="text-align : right">Medical </th><td><?= $model->remuneration->medical ?></td> <th style ="text-align : right"> LTA</th><td><?= $model->remuneration->lta ?></td></tr> 
			<tr> <th style ="text-align : right">Personpay </th><td><?= $model->remuneration->personpay ?></td> <th style ="text-align : right"> PLI</th><td><?= round($model->remuneration->basic * ($model->remuneration->pli/100))  ?></td></tr> 
           	<tr> <th style ="text-align : right">Conveyance </th><td><?= $model->remuneration->conveyance ?></td> <th style ="text-align : right"> Food Allowance</th><td><?= $model->remuneration->food_allowance ?></td></tr>
			<tr> <th style ="text-align : right">Guaranteed Benefit </th><td><?= $model->remuneration->guaranteed_benefit ?></td> <th style ="text-align : right"> Other Allowance</th><td><?= $model->remuneration->other_allowance ?></td></tr> 
			<tr> <th style ="text-align : right">Gross Salary </th><td><?= $model->remuneration->gross_salary ?></td> <th style ="text-align : right">CTC </th><td><?=($model->remuneration->ctc + $food_allowance + $gpa_amt +$gmc_amt)?></td> </tr> 
			
				<tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Personal Details</span></div></th></tr>
                <tr><th style ="text-align : right"> Date of Birth (Birthday)</th> <td> <?php if($PersonalModel->birthday =='1970-01-01' ||$PersonalModel->birthday ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($PersonalModel->birthday));}?></td> <th style ="text-align : right">Gender</th><td><?= $PersonalModel->gender ?></td> </tr>
                <tr><th style ="text-align : right"> Caste </th><td><?= $PersonalModel->caste ?></td> <th style ="text-align : right">Community</th><td><?= $PersonalModel->community ?></td></tr>
                <tr><th style ="text-align : right"> Marital Status </th><td><?= $PersonalModel->martialstatus ?></td> <th style ="text-align : right"> Aadhaar #</th><td><?= $PersonalModel->aadhaarno ?></td></tr>
				<tr><th style ="text-align : right"> PAN # </th><td><?= $PersonalModel->panno ?></td> <th style ="text-align : right"> Voter ID </th><td><?= $PersonalModel->voteridno ?></td></tr>
                <tr><th style ="text-align : right"> Passport # </th><td><?= $PersonalModel->passportno ?></td> <th style ="text-align : right"> Passport Remarks</th><td><?= $PersonalModel->passport_remark?></td></tr>               
                <tr><th style ="text-align : right"> Driving License # </th><td><?= $PersonalModel->drivinglicenceno ?></td><th style ="text-align : right"> Driving License Remarks </th><td><?= $PersonalModel->licence_remark ?></td></tr>	
				
				
				  <tr><th style ="text-align : right"> Permanent Address</th> <td> 
                        <?php
                        if (!empty($AddressModel->addfield1)) {
                            echo $AddressModel->addfield1 . '<br>';
                        }
                        if (!empty($AddressModel->addfield2)) {
                            echo $AddressModel->addfield2 . '<br>';
                        }
                        if (!empty($AddressModel->addfield3)) {
                            echo $AddressModel->addfield3 . '<br>';
                        }
                        if (!empty($AddressModel->addfield4)) {
                            echo $AddressModel->addfield4 . '<br>';
                        }
                        if (!empty($AddressModel->addfield5)) {
                            echo $AddressModel->addfield5 . '<br>';
                        }
						if (!empty($AddressModel->district)) {
                            echo $AddressModel->district . '<br>';
                        }
						if (!empty($AddressModel->state)) {
                            echo $AddressModel->state . '<br>';
                        }
						if (!empty($AddressModel->pincode)) {
                            echo 'Pincode : '.$AddressModel->pincode . '<br>';
                        }
                        ?>           
                       
                    </td> <th style ="text-align : right"> Temporary Address</th> <td> 
                        <?php
                        if (!empty($AddressModel->addfieldtwo1)) {
                            echo $AddressModel->addfieldtwo1 . '<br>';
                        }
                        if (!empty($AddressModel->addfieldtwo2)) {
                            echo $AddressModel->addfieldtwo2 . '<br>';
                        }
                        if (!empty($AddressModel->addfieldtwo3)) {
                            echo $AddressModel->addfieldtwo3 . '<br>';
                        }
                        if (!empty($AddressModel->addfieldtwo4)) {
                            echo $AddressModel->addfieldtwo4 . '<br>';
                        }
                        if (!empty($AddressModel->addfieldtwo5)) {
                            echo $AddressModel->addfieldtwo5 . '<br>';
                        }
						 if (!empty($AddressModel->districttwo)) {
                            echo $AddressModel->districttwo . '<br>';
                        }						
						 if (!empty($AddressModel->statetwo)) {
                            echo $AddressModel->statetwo . '<br>';
                        }
						 if (!empty($AddressModel->pincodetwo)) {
                            echo 'Pincode : '.$AddressModel->pincodetwo . '<br>';
                        }
                        ?>                      
                    </td></tr>
					
               	<tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Family Details</span></div></th></tr>
				<?php foreach ($Sibiling as $family): ?>
			   <tr><th style ="text-align : right"> Relationship Name </th><td><?= $family->relationship ?></td>  <th style ="text-align : right"> Member Name</th><td><?= $family->name ?></td></tr>
                <tr><th style ="text-align : right">Member DoB </th> <td><?php if($family->birthdate =='1970-01-01' ||$family->birthdate ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($family->birthdate));}?></td>  <th style ="text-align : right"> Member Aadhaar #</th><td><?= $family->aadhaarno ?></td></tr>
                <tr><th style ="text-align : right">Member Mobile # </th> <td><?= $family->aadhaarno ?></td>    <th style ="text-align : right"> Nominee</th><td><?= $family->nominee ?></td></tr>
                <?php endforeach; ?>
                <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Education Details</span></div></th></tr>

                <?php foreach ($EducationModel as $education): 
					$degree = Qualification::find()->where(['id' => $education->qualification])->one();
					$course = Course::find()->where(['id' => $education->course])->one();
					$institute = College::find()->where(['id' => $education->institute])->one();
					?>
                    <tr><th style ="text-align : right"> Qualification </th><td> <?= $degree->qualification_name ?> </td><th style ="text-align : right"> Institute</th><td> <?= $institute->collegename ?></td></tr>
                    <tr><th style ="text-align : right"> Course </th><td> <?= $course->coursename ?> </td><th style ="text-align : right">Year of Passing </th><td> <?= $education->yop ?></td></tr>
                <?php endforeach; ?>
                     <?php foreach ($certificateModel as $certificate): ?>
                    <tr><th style ="text-align : right"> Certificates Submitted</th><td colspan="3"> <?= $certificate->certificatesname ?> </td></tr>
                <?php endforeach; ?>
                    <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Bank Account Details</span></div></th></tr>
					<?php foreach ($bankModel as $bank): ?>
                    <tr><th style ="text-align : right"> Bank Name </th><td> <?= $bank->bankname ?> </td><th style= "text-align : right"> Account No</th><td> <?= $bank->acnumber ?></td></tr>
                    <tr><th style ="text-align : right"> Branch Name </th><td> <?= $bank->branch ?> </td><th style= "text-align : right"> IFSC Code</th><td> <?= $bank->ifsc ?></td></tr>
                <?php endforeach; ?>
                
            <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Statutory Details</span></div></th></tr>
             
                <tr><th style= "text-align : right">ESI No</th><td> <?= $statutoryModel->esino ?></td> <th style ="text-align : right"> ESI Dispensary </th><td> <?= $statutoryModel->esidispensary ?> </td></tr>
                <tr><th style ="text-align : right">EPF No</th><td> <?= $statutoryModel->epfno ?> </td><th style= "text-align : right">UAN No</th><td> <?= $statutoryModel->epfuanno ?></td></tr>
                <tr><th style ="text-align : right"> Zero Pension(if Applicable)</th><td> <?= $statutoryModel->zeropension ?> </td><th style= "text-align : right"> Professional Tax</th><td> <?= $statutoryModel->professionaltax ?></td></tr>
                <tr><th style ="text-align : right">PMRPY Beneficiary</th><td><?= $statutoryModel->pmrpybeneficiary ?></td><th style ="text-align : right"> LIN #</th><td></td></tr>
            
			 <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Insurance Details</span></div></th></tr>
				<tr><th style ="text-align : right"> GPA No.</th><td><?= $statutoryModel->gpa_no ?></td>  <th style ="text-align : right"> Sum Insured</th><td><?= $statutoryModel->gpa_sum_insured ?></td></tr>				  
				<tr><th style ="text-align : right"> GMC No.</th><td><?= $statutoryModel->gmc_no ?></td>  <th style ="text-align : right"> Sum Insured</th><td><?= $statutoryModel->gmc_sum_insured ?></td></tr>
				<tr><th style ="text-align : right"> GMC Age Group</th><td><?= $statutoryModel->age_group ?></td>  <th style ="text-align : right"></th><td></td></tr>
				  
			  <tr class=" "><th colspan="4">  Family Insurance Details</th></tr>
				<?php foreach ($Sibiling as $family): ?>
				  <tr><th style ="text-align : right"> GMC No.</th><td><?= $family->gmc_no ?></td>  <th style ="text-align : right"> Sum Insured</th><td><?= $family->sum_insured ?></td></tr>
				  <tr><th style ="text-align : right"> Name/Relationship </th><td><?= $family->name.'/'.$family->relationship ?></td>  <th style ="text-align : right"> Age Group</th><td><?= $family->age_group ?></td></tr>				
				 <?php endforeach; ?>
			 <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Employment Timeline</span></div></th></tr>
				  <tr><th style= "text-align : right">Organisation</th><td> <?= $PreviousEmployment->company ?></td> <th style ="text-align : right"> Place of work (city) </th><td> <?= $PreviousEmployment->company_address ?> </td></tr>
				  <tr><th style= "text-align : right">Designation</th><td> <?= $PreviousEmployment->designation ?></td> <th style ="text-align : right"> Department </th><td> <?= $PreviousEmployment->job_type ?> </td></tr>
				  <tr><th style= "text-align : right">Work From</th><td><?php if($PreviousEmployment->work_from =='1970-01-01' || $PreviousEmployment->work_from ==NULL ){ echo ' ';} else { echo date('d.m.Y', strtotime($PreviousEmployment->work_from));}?> </td> <th style ="text-align : right"> Work To </th><td> <?php if($PreviousEmployment->work_to =='1970-01-01' ||$PreviousEmployment->work_to ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($PreviousEmployment->work_to));}?>  </td></tr>               
			     <tr><th style= "text-align : right">Last Drawn Salary</th><td> <?= $PreviousEmployment->last_drawn_salary ?></td> <th style ="text-align : right"> Reason For Leaving </th><td> <?= $PreviousEmployment->reason_for_leaving ?> </td></tr>
               
                </table>
          </div>
              <!-- <div class="col-lg-2 b" style="width:10%">r</div>-->
          </div>
        </div>
   
<div class="col-md-2">	
  <a href="#" class="list-group-item active">
    Documents
  </a>

  <a href="index.php?r=project-details/staffsalaryannexure&id=<?=$model->id?>" class="list-group-item">Annexure</a>  
  <a href="index.php?r=project-details/emp-log&id=<?=$model->id?>" class="list-group-item" target="_blank">Employee Tracking</a>
</div>
</div>
</div>
