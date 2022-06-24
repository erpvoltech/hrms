<?php
error_reporting(0);

use yii\helpers\Html;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use common\models\EmpEducationdetails;
use common\models\EmpCertificates;
use common\models\EmpBankdetails;
use common\models\EmpDetails;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use common\models\EmpStatutorydetails;
use common\models\PreviousEmployment;
use app\models\AppointmentLetter;
$emp = EmpDetails::find()->where(['id'=>$model])->one();
//print_r($emp);
$PersonalModel = EmpPersonaldetails::find()->where(['empid' => $model])->one();
$AddressModel = EmpAddress::find()->where(['empid' => $model])->one();
$EducationModel = EmpEducationdetails::find()->where(['empid' => $model])->all();
$certificateModel = EmpCertificates::find()->where(['empid' => $model])->all();
$bankModel = EmpBankdetails::find()->where(['empid' => $model])->all();
$Sibiling = EmpFamilydetails::find()->where(['empid' => $model])->all();
$statutoryModel = EmpStatutorydetails::find()->where(['empid' => $model])->one();
$PreviousEmployment = PreviousEmployment::find()->where(['empid' => $model])->one();
$orderempid = AppointmentLetter::find()->where(['empid' => $model])->one();

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
           
		   
		   
                <tr class="" ><th colspan="4">  <div class="addrline"><span class="text" > General</span></div></th></tr>
				
				
				
               <tr><th style ="text-align : left;width:200px">Employment Code</th><td style ="text-align : left;width:280px"><?= $emp->empcode ?></td>	<th style ="text-align : left;width:200px">Name</th><td style ="text-align : left;width:350px"><?= $emp->empname ?></td></tr>	
                <tr><th style ="text-align : left">Date of Joining</th><td><?php if($emp->doj =='1970-01-01' ||$emp->doj ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($emp->doj));}?></td> <th style ="text-align : left">Date of Birth (Record)</th><td> <?php if($PersonalModel->dob == '1970-01-01' ||$PersonalModel->dob ==NULL ){ echo ' ';} else { echo date('d.m.Y', strtotime($PersonalModel->dob));}?></td></tr>
				  <tr><th style ="text-align : left">Designation</th><td><?= $emp->designation->designation ?></td> <th style ="text-align : left">Department</th><td><?= $emp->department->name ?></td></tr>              
                <tr><th style ="text-align : left">Division</th><td><?= $emp->division->division_name ?></td><th style ="text-align : left">Unit</th><td><?= $emp->units->name ?></td></tr>                         
			   <tr><th style ="text-align : left">Email</th><td><?= $emp->email ?></td> <th style ="text-align : left">Mobile No</th><td><?= $emp->mobileno ?></td></tr>
                <tr> <th style ="text-align : left">Probation Period</th><td><?= $emp->probation ?></td> <th style ="text-align : left">Confirmation Date</th><td> <?php if($emp->confirmation_date =='1970-01-01' ||$emp->confirmation_date ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($emp->confirmation_date));}?></td> </tr>
                <tr><th style ="text-align : left">Appraisal Month</th><td><?= $emp->appraisalmonth ?></td> <th style ="text-align : left">Latest Promotion Date</th><td> <?php if($emp->recentdop =='1970-01-01' ||$emp->recentdop ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($emp->recentdop));}?> </td></tr>	
                <tr><th style ="text-align : left">Date of Leaving</th><td> <?php if($emp->dateofleaving =='1970-01-01' ||$emp->dateofleaving ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($emp->dateofleaving));}?> <th style ="text-align : left">Reason for Leaving</th><td><?= $emp->reasonforleaving ?></td> </tr>              
				<tr> <th style ="text-align : left">Referred by</th><td><?= $emp->referedby ?></td><th style ="text-align : left">Joining Status</th><td><?= $emp->joining_status ?></td></tr> 
  
			<tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Remuneration Details</span></div></th></tr>
			
			<tr> <th style ="text-align : left">Salary Structure </th><td><?= $emp->remuneration->salary_structure ?></td> <th style ="text-align : left">attendance_type</th><td><?= $emp->remuneration->attendance_type ?></td></tr> 
			<tr> <th style ="text-align : left">Work Level </th><td><?= $emp->remuneration->work_level ?></td> <th style ="text-align : left"> Grade</th><td><?= $emp->remuneration->grade ?></td></tr> 
			<tr> <th style ="text-align : left">ESI Applicability </th><td><?= $emp->remuneration->esi_applicability ?></td> <th style ="text-align : left"> PF Applicability</th><td><?= $emp->remuneration->pf_applicablity ?></td></tr> 
			<tr> <th style ="text-align : left">Restrict PF </th><td><?= $emp->remuneration->restrict_pf ?></td><th style ="text-align : left"> Zero Pension(if Applicable)</th><td> <?= $statutoryModel->zeropension ?> </td></tr> 
			<tr> <th style ="text-align : left">Basic </th><td><?= $emp->remuneration->basic ?></td> <th style ="text-align : left"> HRA</th><td><?= $emp->remuneration->hra ?></td></tr> 
			<tr> <th style ="text-align : left">Spl. allowance </th><td><?= $emp->remuneration->splallowance ?></td> <th style ="text-align : left"> Dearness Allowance(DA)</th><td><?= $emp->remuneration->dearness_allowance ?></td></tr> 
			<tr> <th style ="text-align : left">Medical </th><td><?= $emp->remuneration->medical ?></td> <th style ="text-align : left"> LTA</th><td><?= $emp->remuneration->lta ?></td></tr> 
			<tr> <th style ="text-align : left">Personpay </th><td><?= $emp->remuneration->personpay ?></td> <th style ="text-align : left"> PLI</th><td><?= round($emp->remuneration->basic * ($emp->remuneration->pli/100))  ?></td></tr> 
           	<tr> <th style ="text-align : left">Conveyance </th><td><?= $emp->remuneration->conveyance ?></td> <th style ="text-align : left"> Dust Allowance</th><td><?= $emp->remuneration->dust_allowance ?></td></tr>
			<tr> <th style ="text-align : left">Guaranteed Benefit </th><td><?= $emp->remuneration->guaranteed_benefit ?></td> <th style ="text-align : left"> Other Allowance</th><td><?= $emp->remuneration->other_allowance ?></td></tr> 
			<tr> <th style ="text-align : left">Gross Salary </th><td><?= $emp->remuneration->gross_salary ?></td> <th style ="text-align : left">CTC </th><td><?=$emp->remuneration->ctc ?></td> </tr> 
			
			
				<tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Personal Details</span></div></th></tr>
                <tr><th style ="text-align : left"> Date of Birth (Birthday)</th> <td> <?php if($PersonalModel->birthday =='1970-01-01' ||$PersonalModel->birthday ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($PersonalModel->birthday));}?></td> <th style ="text-align : left">Gender</th><td><?= $PersonalModel->gender ?></td> </tr>
                <tr><th style ="text-align : left"> Caste </th><td><?= $PersonalModel->caste ?></td> <th style ="text-align : left">Community</th><td><?= $PersonalModel->community ?></td></tr>
                <tr><th style ="text-align : left"> Marital Status </th><td><?= $PersonalModel->martialstatus ?></td> <th style ="text-align : left"> Aadhaar #</th><td><?= $PersonalModel->aadhaarno ?></td></tr>
				<tr><th style ="text-align : left"> PAN # </th><td><?= $PersonalModel->panno ?></td> <th style ="text-align : left"> Voter ID </th><td><?= $PersonalModel->voteridno ?></td></tr>
                <tr><th style ="text-align : left"> Passport # </th><td><?= $PersonalModel->passportno ?></td> <th style ="text-align : left"> Passport Remarks</th><td><?= $PersonalModel->passport_remark?></td></tr>               
                <tr><th style ="text-align : left"> Driving License # </th><td><?= $PersonalModel->drivinglicenceno ?></td><th style ="text-align : left"> Driving License Remarks </th><td><?= $PersonalModel->licence_remark ?></td></tr>	
				
				
				  <tr><th style ="text-align : left"> Permanent Address</th> <td> 
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
                       
                    </td> <th style ="text-align : left"> Temporary Address</th> <td> 
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
			   <tr><th style ="text-align : left"> Relationship Name </th><td><?= $family->relationship ?></td>  <th style ="text-align : left"> Member Name</th><td><?= $family->name ?></td></tr>
                <tr><th style ="text-align : left">Member DoB </th> <td><?php if($family->birthdate =='1970-01-01' ||$family->birthdate ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($family->birthdate));}?></td>  <th style ="text-align : left"> Member Aadhaar #</th><td><?= $family->aadhaarno ?></td></tr>
                <tr><th style ="text-align : left">Member Mobile # </th> <td><?= $family->aadhaarno ?></td>    <th style ="text-align : left"> Nominee</th><td><?= $family->nominee ?></td></tr>
                <?php endforeach; ?>
                <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Education Details</span></div></th></tr>

                <?php foreach ($EducationModel as $education): ?>
                    <tr><th style ="text-align : left"> Qualification </th><td> <?= $education->qualification ?> </td><th style ="text-align : left"> Institute</th><td> <?= $education->institute ?></td></tr>
                    <tr><th style ="text-align : left"> Course </th><td> <?= $education->course ?> </td><th style ="text-align : left">Year of Passing </th><td> <?= $education->yop ?></td></tr>
                <?php endforeach; ?>
                     <?php foreach ($certificateModel as $certificate): ?>
                    <tr><th style ="text-align : left"> Certificates Submitted</th><td colspan="3"> <?= $certificate->certificatesname ?> </td></tr>
                <?php endforeach; ?>
                    <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Bank Account Details</span></div></th></tr>
					<?php foreach ($bankModel as $bank): ?>
                    <tr><th style ="text-align : left"> Bank Name </th><td> <?= $bank->bankname ?> </td><th style= "text-align : left"> Account No</th><td> <?= $bank->acnumber ?></td></tr>
                    <tr><th style ="text-align : left"> Branch Name </th><td> <?= $bank->branch ?> </td><th style= "text-align : left"> IFSC Code</th><td> <?= $bank->ifsc ?></td></tr>
                <?php endforeach; ?>
                
            <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Statutory Details</span></div></th></tr>
             
                <tr><th style= "text-align : left">ESI No</th><td> <?= $statutoryModel->esino ?></td> <th style ="text-align : left"> ESI Dispensary </th><td> <?= $statutoryModel->esidispensary ?> </td></tr>
                <tr><th style ="text-align : left">EPF No</th><td> <?= $statutoryModel->epfno ?> </td><th style= "text-align : left">UAN No</th><td> <?= $statutoryModel->epfuanno ?></td></tr>
                <tr><th style ="text-align : left"> Zero Pension(if Applicable)</th><td> <?= $statutoryModel->zeropension ?> </td><th style= "text-align : left"> Professional Tax</th><td> <?= $statutoryModel->professionaltax ?></td></tr>
                <tr><th style ="text-align : left">PMRPY Beneficiary</th><td><?= $statutoryModel->pmrpybeneficiary ?></td><th style ="text-align : left"> LIN #</th><td></td></tr>
            
			 <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Employment Timeline</span></div></th></tr>
				  <tr><th style= "text-align : left">Organisation</th><td> <?= $PreviousEmployment->company ?></td> <th style ="text-align : left"> Place of work (city) </th><td> <?= $PreviousEmployment->company_address ?> </td></tr>
				  <tr><th style= "text-align : left">Designation</th><td> <?= $PreviousEmployment->designation ?></td> <th style ="text-align : left"> Department </th><td> <?= $PreviousEmployment->job_type ?> </td></tr>
				  <tr><th style= "text-align : left">Work From</th><td><?php if($PreviousEmployment->work_from =='1970-01-01' || $PreviousEmployment->work_from ==NULL ){ echo ' ';} else { echo date('d.m.Y', strtotime($PreviousEmployment->work_from));}?> </td> <th style ="text-align : left"> Work To </th><td> <?php if($PreviousEmployment->work_to =='1970-01-01' ||$PreviousEmployment->work_to ==NULL ){ echo '';} else { echo date('d.m.Y', strtotime($PreviousEmployment->work_to));}?>  </td></tr>               
			     <tr><th style= "text-align : left">Last Drawn Salary</th><td> <?= $PreviousEmployment->last_drawn_salary ?></td> <th style ="text-align : left"> Reason For Leaving </th><td> <?= $PreviousEmployment->reason_for_leaving ?> </td></tr>               
                </table>
	
</page>
</body>
<script type="text/javascript">
 window.onload = function() { window.print(); }
</script>