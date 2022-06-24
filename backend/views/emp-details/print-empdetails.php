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
use common\models\PreviousEmployment;
use app\models\AppointmentLetter;

$PersonalModel = EmpPersonaldetails::find()->where(['empid' => $model->id])->one();
$AddressModel = EmpAddress::find()->where(['empid' => $model->id])->one();
$EducationModel = EmpEducationdetails::find()->where(['empid' => $model->id])->all();
$certificateModel = EmpCertificates::find()->where(['empid' => $model->id])->all();
$bankModel = EmpBankdetails::find()->where(['empid' => $model->id])->all();
$Sibiling = EmpFamilydetails::find()->where(['empid' => $model->id])->all();
$statutoryModel = EmpStatutorydetails::find()->where(['empid' => $model->id])->one();
$PreviousEmployment = PreviousEmployment::find()->where(['empid' => $model->id])->one();
$orderempid = AppointmentLetter::find()->where(['empid' => $model->id])->one();

?>
<style>
body {
  background: rgb(204,204,204); 
}
page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
page[size="A4"] {  
  width: 21cm;
  height: 29.7cm; 
}
page[size="A4"][layout="landscape"] {
  width: 29.7cm;
  height: 21cm;  
}
page[size="A3"] {
  width: 29.7cm;
  height: 42cm;
}
page[size="A3"][layout="landscape"] {
  width: 42cm;
  height: 29.7cm;  
}
page[size="A5"] {
  width: 14.8cm;
  height: 21cm;
}
page[size="A5"][layout="landscape"] {
  width: 21cm;
  height: 14.8cm;  
}
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}
</style>
<body>
<page size="A4">
	<table >
           
		   
		   
                <tr class="" ><th colspan="5">  <div class="addrline"><span class="text" > General</span></div></th></tr>
				
				
				
               
				<tr >	<th style ="text-align : right;width:200px" >Name</th><td style ="text-align : left;width:400px" ><?= $model->empname ?></td><th style ="text-align : right;width:200px">Employment Code</th><td style ="text-align : left;width:400px"><?= $model->empcode ?></td><td style ="text-align : left;width:400px;background-color: #80005f17;" rowspan=6><?php echo Html::img('@web/emp_photo/' . $model->photo, ['class' => 'pull-right img-responsive','style'=>'width:100%;']); ?></td></tr>	
                
               <tr><th style ="text-align : right">Date of Joining</th><td><?php if($model->doj =='1970-01-01' ||$model->doj ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->doj));}?></td> <th style ="text-align : right left;width:400px">Date of Birth (as per document)</th><td colspan=2> <?php if($PersonalModel->dob == '1970-01-01' ||$PersonalModel->dob ==NULL ){ echo ' ';} else { echo date('d.m.Y', strtotime($PersonalModel->dob));}?></td></tr>
				  <tr><th style ="text-align : right">Designation</th><td><?= $model->designation->designation ?></td> <th style ="text-align : right">Department</th><td colspan=2><?= $model->department->name ?></td></tr>              
                <tr><th style ="text-align : right">Division</th><td><?= $model->division->division_name ?></td><th style ="text-align : right">Unit</th><td colspan=2><?= $model->units->name ?></td></tr>                         
			   <tr><th style ="text-align : right">Email(Official)</th><td><?= $model->email ?></td> <th style ="text-align : right">Mobile No(Official)</th><td colspan=2><?= $model->mobileno ?></td></tr>
                 <tr><th style ="text-align : right">Email(Personal)</th><td><?= $PersonalModel->email ?></td> <th style ="text-align : right">Mobile No(Personal)</th><td colspan=2><?= $PersonalModel->mobile_no ?></td></tr>               
				<tr> <th style ="text-align : right">Probation Period</th><td><?= $model->probation ?></td> <th style ="text-align : right">Confirmation Date</th><td colspan=2> <?php if($model->confirmation_date =='1970-01-01' ||$model->confirmation_date ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->confirmation_date));}?></td> </tr>
                <tr><th style ="text-align : right">Appraisal Month</th><td><?= $model->appraisalmonth ?></td> <th style ="text-align : right">Latest Promotion Date</th><td colspan=2> <?php if($model->recentdop =='1970-01-01' ||$model->recentdop ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->recentdop));}?> </td></tr>	
                <tr><th style ="text-align : right">Date of Leaving</th><td> <?php if($model->dateofleaving =='1970-01-01' ||$model->dateofleaving ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->dateofleaving));}?> <th style ="text-align : right">Latest Working Date</th><td colspan=2> <?php if($model->last_working_date =='1970-01-01' ||$model->last_working_date ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($model->last_working_date));}?> </td></tr>              
				<tr> <th style ="text-align : right">Reason for Leaving</th><td><?= $model->reasonforleaving ?></td><th style ="text-align : right">Referred by</th><td colspan=2><?= $model->referedby ?></td> 
				<tr> <th style ="text-align : right">Joining Status</th><td><?= $model->joining_status ?></td> <th style ="text-align : right">Status</th><td colspan=2><?= $model->status ?></td></tr> 
			<tr class=" "><th colspan="5">  <div class="addrline"><span class="text"> Remuneration Details</span></div></th></tr>
			
			<tr> <th style ="text-align : right">Salary Structure </th><td><?= $model->remuneration->salary_structure ?></td> <th style ="text-align : right">attendance_type</th><td colspan=2><?= $model->remuneration->attendance_type ?></td></tr> 
			<tr> <th style ="text-align : right">Work Level </th><td><?= $model->remuneration->work_level ?></td> <th style ="text-align : right"> Grade</th><td colspan=2><?= $model->remuneration->grade ?></td></tr> 
			<tr> <th style ="text-align : right">ESI Applicability </th><td><?= $model->remuneration->esi_applicability ?></td> <th style ="text-align : right"> PF Applicability</th><td colspan=2><?= $model->remuneration->pf_applicablity ?></td></tr> 
			<tr> <th style ="text-align : right">Restrict PF </th><td><?= $model->remuneration->restrict_pf ?></td><th style ="text-align : right"> Zero Pension(if Applicable)</th><td colspan=2> <?= $statutoryModel->zeropension ?> </td></tr> 
			<tr> <th style ="text-align : right">Basic </th><td><?= $model->remuneration->basic ?></td> <th style ="text-align : right"> HRA</th><td colspan=2><?= $model->remuneration->hra ?></td></tr> 
			<tr> <th style ="text-align : right">Spl. allowance </th><td><?= $model->remuneration->splallowance ?></td> <th style ="text-align : right"> Dearness Allowance(DA)</th><td colspan=2><?= $model->remuneration->dearness_allowance ?></td></tr> 
			<tr> <th style ="text-align : right">Medical </th><td><?= $model->remuneration->medical ?></td> <th style ="text-align : right"> LTA</th><td colspan=2><?= $model->remuneration->lta ?></td></tr> 
			<tr> <th style ="text-align : right">Personpay </th><td><?= $model->remuneration->personpay ?></td> <th style ="text-align : right"> PLI</th><td colspan=2><?= round($model->remuneration->basic * ($model->remuneration->pli/100))  ?></td></tr> 
           	<tr> <th style ="text-align : right">Conveyance </th><td><?= $model->remuneration->conveyance ?></td> <th style ="text-align : right"> Food Allowance</th><td colspan=2><?= $model->remuneration->food_allowance ?></td></tr>
			<tr> <th style ="text-align : right">Guaranteed Benefit </th><td><?= $model->remuneration->guaranteed_benefit ?></td> <th style ="text-align : right"> Other Allowance</th><td colspan=2><?= $model->remuneration->other_allowance ?></td></tr> 
			<tr> <th style ="text-align : right">Gross Salary </th><td><?= $model->remuneration->gross_salary ?></td> <th style ="text-align : right">CTC </th><td colspan=2><?=($model->remuneration->ctc + $food_allowance + $gpa_amt +$gmc_amt)?></td> </tr> 
			
				<tr class=" "><th colspan="5">  <div class="addrline"><span class="text"> Personal Details</span></div></th></tr>
                <tr><th style ="text-align : right"> Date of Birth (Birthday)</th> <td> <?php if($PersonalModel->birthday =='1970-01-01' ||$PersonalModel->birthday ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($PersonalModel->birthday));}?></td> <th style ="text-align : right">Gender</th><td colspan=2><?= $PersonalModel->gender ?></td> </tr>
                <tr><th style ="text-align : right"> Caste </th><td><?= $PersonalModel->caste ?></td> <th style ="text-align : right">Community</th><td colspan=2><?= $PersonalModel->community ?></td></tr>
                <tr><th style ="text-align : right"> Marital Status </th><td><?= $PersonalModel->martialstatus ?></td> <th style ="text-align : right"> Aadhaar #</th><td colspan=2><?= $PersonalModel->aadhaarno ?></td></tr>
				<tr><th style ="text-align : right"> PAN # </th><td><?= $PersonalModel->panno ?></td> <th style ="text-align : right"> Voter ID </th><td colspan=2><?= $PersonalModel->voteridno ?></td></tr>
                <tr><th style ="text-align : right"> Passport # </th><td><?= $PersonalModel->passportno ?></td> <th style ="text-align : right"> Passport Remarks</th><td colspan=2><?= $PersonalModel->passport_remark?></td></tr>               
                <tr><th style ="text-align : right"> Driving License # </th><td><?= $PersonalModel->drivinglicenceno ?></td><th style ="text-align : right"> Driving License Remarks </th><td colspan=2><?= $PersonalModel->licence_remark ?></td></tr>	
				
				
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
                       
                    </td> <th style ="text-align : right"> Temporary Address</th> <td colspan=2> 
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
					
               	<tr class=" "><th colspan="5">  <div class="addrline"><span class="text"> Family Details</span></div></th></tr>
				<?php foreach ($Sibiling as $family): ?>
			   <tr><th style ="text-align : right"> Relationship Name </th><td><?= $family->relationship ?></td>  <th style ="text-align : right"> Member Name</th><td colspan=2><?= $family->name ?></td></tr>
                <tr><th style ="text-align : right">Member DoB </th> <td><?php if($family->birthdate =='1970-01-01' ||$family->birthdate ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($family->birthdate));}?></td>  <th style ="text-align : right"> Member Aadhaar #</th><td colspan=2><?= $family->aadhaarno ?></td></tr>
                <tr><th style ="text-align : right">Member Mobile # </th> <td><?= $family->mobileno ?></td>    <th style ="text-align : right"> Nominee</th><td colspan=2><?= $family->nominee ?></td></tr>
                <?php endforeach; ?>
                <tr class=" "><th colspan="5">  <div class="addrline"><span class="text"> Education Details</span></div></th></tr>

                <?php foreach ($EducationModel as $education): 
					$degree = Qualification::find()->where(['id' => $education->qualification])->one();
					$course = Course::find()->where(['id' => $education->course])->one();
					$institute = College::find()->where(['id' => $education->institute])->one();
					?>
                    <tr><th style ="text-align : right"> Qualification </th><td> <?= $degree->qualification_name ?> </td><th style ="text-align : right"> Institute</th><td colspan=2> <?= $institute->collegename ?></td></tr>
                    <tr><th style ="text-align : right"> Course </th><td> <?= $course->coursename ?> </td><th style ="text-align : right">Year of Passing </th><td colspan=2> <?= $education->yop ?></td></tr>
                <?php endforeach; ?>
                     <?php foreach ($certificateModel as $certificate): ?>
                    <tr><th style ="text-align : right"> Certificates Submitted</th><td colspan="4"> <?= $certificate->certificatesname ?> </td></tr>
                <?php endforeach; ?>
                    <tr class=" "><th colspan="5">  <div class="addrline"><span class="text"> Bank Account Details</span></div></th></tr>
					<?php foreach ($bankModel as $bank): ?>
                    <tr><th style ="text-align : right"> Bank Name </th><td> <?= $bank->bankname ?> </td><th style= "text-align : right"> Account No</th><td colspan=2> <?= $bank->acnumber ?></td></tr>
                    <tr><th style ="text-align : right"> Branch Name </th><td> <?= $bank->branch ?> </td><th style= "text-align : right"> IFSC Code</th><td colspan=2> <?= $bank->ifsc ?></td></tr>
                <?php endforeach; ?>
                
            <tr class=" "><th colspan="5">  <div class="addrline"><span class="text"> Statutory Details</span></div></th></tr>
             
                <tr><th style= "text-align : right">ESI No</th><td> <?= $statutoryModel->esino ?></td> <th style ="text-align : right"> ESI Dispensary </th><td colspan=2> <?= $statutoryModel->esidispensary ?> </td></tr>
                <tr><th style ="text-align : right">EPF No</th><td> <?= $statutoryModel->epfno ?> </td><th style= "text-align : right">UAN No</th><td colspan=2> <?= $statutoryModel->epfuanno ?></td></tr>
                <tr><th style ="text-align : right"> Zero Pension(if Applicable)</th><td> <?= $statutoryModel->zeropension ?> </td><th style= "text-align : right"> Professional Tax</th><td colspan=2> <?= $statutoryModel->professionaltax ?></td></tr>
                <tr><th style ="text-align : right">PMRPY Beneficiary</th><td><?= $statutoryModel->pmrpybeneficiary ?></td><th style ="text-align : right"> LIN #</th><td colspan=2></td></tr>
            
			 <tr class=" "><th colspan="5">  <div class="addrline"><span class="text"> Insurance Details</span></div></th></tr>
				<tr><th style ="text-align : right"> GPA No.</th><td><?= $statutoryModel->gpa_no ?></td>  <th style ="text-align : right"> Sum Insured</th><td colspan=2><?= $statutoryModel->gpa_sum_insured ?></td></tr>				  
				<tr><th style ="text-align : right"> GMC No.</th><td><?= $statutoryModel->gmc_no ?></td>  <th style ="text-align : right"> Sum Insured</th><td colspan=2><?= $statutoryModel->gmc_sum_insured ?></td></tr>
				<tr><th style ="text-align : right"> GMC Age Group</th><td><?= $statutoryModel->age_group ?></td>  <th style ="text-align : right"></th><td colspan=2></td></tr>
				  
			  <tr class=" "><th colspan="5">  Family Insurance Details</th></tr>
				<?php foreach ($Sibiling as $family): ?>
				  <tr><th style ="text-align : right"> GMC No.</th><td><?= $family->gmc_no ?></td>  <th style ="text-align : right"> Sum Insured</th><td colspan=2><?= $family->sum_insured ?></td></tr>
				  <tr><th style ="text-align : right"> Name/Relationship </th><td><?= $family->name.'/'.$family->relationship ?></td>  <th style ="text-align : right"> Age Group</th><td colspan=2><?= $family->age_group ?></td></tr>				
				 <?php endforeach; ?>
			 <tr class=" "><th colspan="5">  <div class="addrline"><span class="text"> Employment Timeline</span></div></th></tr>
				  <tr><th style= "text-align : right">Organisation</th><td> <?= $PreviousEmployment->company ?></td> <th style ="text-align : right"> Place of work (city) </th><td colspan=2> <?= $PreviousEmployment->company_address ?> </td></tr>
				  <tr><th style= "text-align : right">Designation</th><td> <?= $PreviousEmployment->designation ?></td> <th style ="text-align : right"> Department </th><td colspan=2> <?= $PreviousEmployment->job_type ?> </td></tr>
				  <tr><th style= "text-align : right">Work From</th><td><?php if($PreviousEmployment->work_from =='1970-01-01' || $PreviousEmployment->work_from ==NULL ){ echo ' ';} else { echo date('d.m.Y', strtotime($PreviousEmployment->work_from));}?> </td> <th style ="text-align : right"> Work To </th><td colspan=2> <?php if($PreviousEmployment->work_to =='1970-01-01' ||$PreviousEmployment->work_to ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($PreviousEmployment->work_to));}?>  </td></tr>               
			     <tr><th style= "text-align : right">Last Drawn Salary</th><td> <?= $PreviousEmployment->last_drawn_salary ?></td> <th style ="text-align : right"> Reason For Leaving </th><td colspan=2> <?= $PreviousEmployment->reason_for_leaving ?> </td></tr>
                              
                </table>
	
</page>
</body>
<script type="text/javascript">
 window.onload = function() { window.print(); }
</script>