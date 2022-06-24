<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\EmpDetails;
use common\models\AttendanceAccessRule;
use common\models\Division;
use common\models\Unit;
use common\models\UnitGroup;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use common\models\EmpEducationdetails;
use common\models\EmpCertificates;
use common\models\EmpBankdetails;
use common\models\Department;
use common\models\Qualification;
use common\models\Course;
use common\models\College;
use common\models\EmpStatutorydetails;
use common\models\PreviousEmployment;
use common\models\EmpRemunerationDetails;
use yii\db\Query;
$sel_unit = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
$options = array();
$i=0;
$query = new Query;

		foreach($sel_unit as $unit){
			$options[$i]=$unit->unit;
	$dataProvider = new ActiveDataProvider([
                    'query' =>EmpDetails::find()->joinWith('remuneration')->joinWith('employeePersonalDetail')->joinWith('designation')->joinWith('department')->joinWith('division')->joinWith('units')->joinWith('employeeStatutoryDetail')->joinWith('employeeAddress')->joinWith('family')->joinWith('employeeEducationDetail')->joinWith('certificate')->joinWith('employeeBankDetail')->joinWith('employeeStatutoryDetail')->joinWith('employment')->where(['unit_id'=>$options])->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']]),
                    //'pagination' => [
                     //   'pageSize' => 50, 
                   // ],
                ]);
				
			
			

		
	$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],							
							/*[
								'header' => 'Emp. Code',
								'value' => 'employee.empcode',
							],
							[
								'header' => 'Emp. Name',
								'value' => 'employee.empname',
							],
							[							
								'header' => 'Unit',
								'value' => 'employee.units.name'
							],
							[
								'header' => 'Department',
								'value' => 'employee.department.name',
							],*/
							//'employment_type',
								'empcode',
									//'emp_password',
									'empname',
									'doj',
									[
								 'attribute' => 'Date of Birth',
								'value' => 'employeePersonalDetail.dob',
							],
							[
								 'attribute' => 'Designation',
								'value' => 'designation.designation',
							],
							[
								 'attribute' => 'Department',
								'value' => 'department.name',
							],
							[
								 'attribute' => 'Division',
								'value' => 'division.division_name',
							],
							[
								 'attribute' => 'Unit',
								'value' => 'units.name',
							],
							'email',
							'mobileno',
							[
								 'attribute' => 'Email(Personal)',
								'value' => 'employeePersonalDetail.email',
							],
							[
								 'attribute' => 'Mobile(Personel)',
								'value' => 'employeePersonalDetail.mobile_no',
							],
							'probation',
							'confirmation_date',
							'appraisalmonth',
							'recentdop',
							'dateofleaving',
							'last_working_date',
							'reasonforleaving',
							'referedby',
							'joining_status',
							'status',
							[
								 'attribute' => 'Salary Structure',
								'value' => 'remuneration.salary_structure',
							],
							[
								 'attribute' => 'Attendance Type',
								'value' => 'remuneration.attendance_type',
							],
							[
								 'attribute' => 'Work Level',
								'value' => 'remuneration.work_level',
							],
							[
								 'attribute' => 'Grade',
								'value' => 'remuneration.grade',
							],
							[
								 'attribute' => 'ESI Applicability',
								'value' => 'remuneration.esi_applicability',
							],
							[
								 'attribute' => 'PF Applicability',
								'value' => 'remuneration.pf_applicablity',
							],
							[
								 'attribute' => 'Restrict PF',
								'value' => 'remuneration.restrict_pf',
							],
							[
								 'attribute' => 'Zero Pension(If Aplicable)',
								'value' => 'employeeStatutoryDetail.zeropension',
							],
							[
								 'attribute' => 'Basic',
								'value' => 'remuneration.basic',
							],
							[
								 'attribute' => 'HRA',
								'value' => 'remuneration.hra',
							],
							[
								 'attribute' => 'Spl.Allowance',
								'value' => 'remuneration.splallowance',
							],
							[
								 'attribute' => 'Dearness Allowance(DA)',
								'value' => 'remuneration.dearness_allowance',
							],
							[
								 'attribute' => 'Medical',
								'value' => 'remuneration.medical',
							],
							[
								 'attribute' => 'LTA',
								'value' => 'remuneration.lta',
							],
							[
								 'attribute' => 'Personpay',
								'value' => 'remuneration.personpay',
							],
							[
								 'attribute' => 'PLI',
								'value' => 'remuneration.pli',
							],
							[
								 'attribute' => 'Conveyance',
								'value' => 'remuneration.conveyance',
							],
							[
								 'attribute' => 'Food Allowance',
								'value' => 'remuneration.food_allowance',
							],
							[
								 'attribute' => 'Guaranteed Benefit',
								'value' => 'remuneration.guaranteed_benefit',
							],
							[
								 'attribute' => 'Other Allowance',
								'value' => 'remuneration.other_allowance',
							],
							[
								 'attribute' => 'Gross Salary',
								'value' => 'remuneration.gross_salary',
							],
							[
								 'attribute' => 'CTC',
								'value' => 'remuneration.ctc',
							],
							[
								 'attribute' => 'Gender',
								'value' => 'employeePersonalDetail.gender',
							],
							[
								 'attribute' => 'Caste',
								'value' => 'employeePersonalDetail.caste',
							],
							[
								 'attribute' => 'Community',
								'value' => 'employeePersonalDetail.community',
							],
							[
								 'attribute' => 'Marital Status',
								'value' => 'employeePersonalDetail.martialstatus',
							],
							[
								 'attribute' => 'Aadhaar',
								'value' => 'employeePersonalDetail.aadhaarno',
							],
							[
								 'attribute' => 'PAN',
								'value' => 'employeePersonalDetail.panno',
							],
							[
								 'attribute' => 'Voter ID',
								'value' => 'employeePersonalDetail.voteridno',
							],
							[
								 'attribute' => 'Passport',
								'value' => 'employeePersonalDetail.passportno',
							],
							[
								 'attribute' => 'Passport Remark',
								'value' => 'employeePersonalDetail.passport_remark',
							],
							[
								 'attribute' => 'Driving License',
								'value' => 'employeePersonalDetail.drivinglicenceno',
							],
							[
								 'attribute' => 'Driving License Remarks',
								'value' => 'employeePersonalDetail.licence_remark',
							],
							[
								 'attribute' => 'Permanent Address',
								'value' => 'employeeAddress.addfield1',
								
							],
							[
								 'attribute' => 'Permanent Address',
								'value' => 'employeeAddress.addfield2',
								
							],
							[
								 'attribute' => 'Permanent Address',
								'value' => 'employeeAddress.addfield3',
								
							],
							[
								 'attribute' => 'Permanent Address',
								'value' => 'employeeAddress.addfield4',
								
							],
							[
								 'attribute' => 'Permanent Address',
								'value' => 'employeeAddress.addfield5',
							],
							[
								 'attribute' => 'Permanent Address',
								
								'value' => 'employeeAddress.district',
								
							],
							[
								 'attribute' => 'Permanent Address',
								'value' => 'employeeAddress.state',
							],
							[
								 'attribute' => 'Permanent Address',
								'value' => 'employeeAddress.pincode',
							],
							[
								 'attribute' => 'Temporary Address',
								'value' => 'employeeAddress.addfieldtwo1',
								'value' => 'employeeAddress.addfieldtwo2',
								'value' => 'employeeAddress.addfieldtwo3',
								'value' => 'employeeAddress.addfieldtwo4',
								'value' => 'employeeAddress.addfieldtwo5',
								'value' => 'employeeAddress.districttwo',
								'value' => 'employeeAddress.statetwo',
								'value' => 'employeeAddress.pincodetwo',
							],
							[
								 'attribute' => 'Temporary Address',
								'value' => 'employeeAddress.addfieldtwo1',
								
							],
							[
								 'attribute' => 'Temporary Address',
								
								'value' => 'employeeAddress.addfieldtwo2',
								
							],
							[
								 'attribute' => 'Temporary Address',
								
								'value' => 'employeeAddress.addfieldtwo3',
								
							],
							[
								 'attribute' => 'Temporary Address',
								
								'value' => 'employeeAddress.addfieldtwo4',
								
							],
							[
								 'attribute' => 'Temporary Address',
								
								'value' => 'employeeAddress.addfieldtwo5',
								
							],
							[
								 'attribute' => 'Temporary Address',
								
								'value' => 'employeeAddress.districttwo',
								
							],
							[
								 'attribute' => 'Temporary Address',
								'value' => 'employeeAddress.statetwo',
								
							],
							[
								 'attribute' => 'Temporary Address',
								'value' => 'employeeAddress.pincodetwo',
							],
							[
								 'attribute' => 'Relationship Name',
								'value' => 'family.relationship',
								
							],
							[
								 'attribute' => 'Member Name',
								'value' => 'family.name',
								
							],
							[
								 'attribute' => 'Member DOB',
								'value' => 'family.birthdate',
								
							],
							[
								 'attribute' => 'Member Aadhaar',
								'value' => 'family.aadhaarno',
								
							],
							[
								 'attribute' => 'Member Mobile',
								'value' => 'family.mobileno',
								
							],
							[
								 'attribute' => 'Nominee',
								'value' => 'family.nominee',
								
							],
							[
								 'attribute' => 'Qualification',
								'value' => 'employeeEducationDetail.qualification',
								
							],
							[
								 'attribute' => 'Institute',
								'value' => 'employeeEducationDetail.institute',
								
							],
							[
								 'attribute' => 'Course',
								'value' => 'employeeEducationDetail.course',
								
							],
							[
								 'attribute' => 'Year Of Passing',
								'value' => 'employeeEducationDetail.yop',
								
							],
							[
								 'attribute' => 'Certificate Submitted',
								'value' => 'certificate.certificatesname',
								
							],
							[
								 'attribute' => 'Bank Name',
								'value' => 'employeeBankDetail.bankname',
								
							],
							[
								 'attribute' => 'Account No',
								'value' => 'employeeBankDetail.acnumber',
								
							],
							[
								 'attribute' => 'Branch Name',
								'value' => 'employeeBankDetail.branch',
								
							],
							[
								 'attribute' => 'IFSC Code',
								'value' => 'employeeBankDetail.ifsc',
								
							],
							[
								 'attribute' => 'ESI No',
								'value' => 'employeeStatutoryDetail.esino',
								
							],
							[
								 'attribute' => 'ESI Dispensary',
								'value' => 'employeeStatutoryDetail.esidispensary',
								
							],
							[
								 'attribute' => 'EPF No',
								'value' => 'employeeStatutoryDetail.epfno',
								
							],
							[
								 'attribute' => 'UAN No',
								'value' => 'employeeStatutoryDetail.epfuanno',
								
							],
							[
								 'attribute' => 'Zero Pension(if Applicable)',
								'value' => 'employeeStatutoryDetail.zeropension',
								
							],
							[
								 'attribute' => 'Professional Tax',
								'value' => 'employeeStatutoryDetail.professionaltax',
								
							],
							[
								 'attribute' => 'PMRPY Beneficiary',
								'value' => 'employeeStatutoryDetail.pmrpybeneficiary',
								
							],
							[
								 'attribute' => 'LIN',
								'value' => 'employeeStatutoryDetail.lin_no',
								
							],
							[
								 'attribute' => 'GPA No',
								'value' => 'employeeStatutoryDetail.gpa_no',
								
							],
							[
								 'attribute' => 'Sum Insured',
								'value' => 'employeeStatutoryDetail.gpa_sum_insured',
								
							],
							[
								 'attribute' => 'GMC No',
								'value' => 'employeeStatutoryDetail.gmc_no',
								
							],
							[
								 'attribute' => 'Sum Insured',
								'value' => 'employeeStatutoryDetail.gmc_sum_insured',
								
							],
							[
								 'attribute' => 'GMC No',
								'value' => 'family.gmc_no',
								
							],
							[
								 'attribute' => 'Sum Insured',
								'value' => 'family.sum_insured',
								
							],
							[
								 'attribute' => 'Insured Name',
								'value' => 'family.name',
								
								
							],
							[
								 'attribute' => 'Relationship',
								
								'value' => 'family.relationship'
								
							],
							[
								 'attribute' => 'Age Group',
								'value' => 'family.age_group',
								
							],
							[
								 'attribute' => 'Organisation',
								'value' => 'employment.company',
								
							],
							[
								 'attribute' => 'Place of work (city)',
								'value' => 'employment.company_address',
								
							],
							[
								 'attribute' => 'Designation',
								'value' => 'employment.designation',
								
							],
							[
								 'attribute' => 'Department',
								'value' => 'employment.job_type',
								
							],
							[
								 'attribute' => 'Work From',
								'value' => 'employment.work_from',
								
							],
							[
								 'attribute' => 'Work To',
								'value' => 'employment.work_to',
								
							],
							[
								 'attribute' => 'Last Drawn Salary',
								'value' => 'employment.last_drawn_salary',
								
							],
							[
								 'attribute' => 'Reason For Leaving',
								'value' => 'employment.reason_for_leaving',
								
							],
						
							 
						];
						$i++;
	
}
if(Yii::$app->user->identity->role=='project admin'){
echo $fullexport =  ExportMenu::widget([
    'dataProvider' => $dataProvider,
   'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-secondary'
		]
]);
}

$slno =1;
$ecode = $_GET['ec'];

?>
<style>
	.btn-group, .btn-group-vertical {
    position: relative;
    left: 201px;
    bottom: -14px;
    /* display: inline-block; */
    vertical-align: middle;
}
	</style>

<div class="project-details-employee-list">

    <?php $form = ActiveForm::begin(); 
    $model->empcode = $ecode;
    ?>
    <div class="container">
	<div class="rwo">
	<div class="col-md-3">
		 <?= $form->field($model, 'empcode')->label('ECode')?>
		 </div>
		 <div class="col-md-3"> <?= Html::Button('Search', ['class' => 'btn-xs btn-primary','id'=>'submitbutton']) ?></div>
		 </div>
		 </div>
	<h2>Employee List</h2>
      <div class="container">
	  <div class="row">
	  <table>
	  <tr><th style="width:1px;">Sl.No</th><th style="width:1px;">Empcode</th><th>EmpName</th><?php if(Yii::$app->user->identity->role=='project admin'){?><th>Status</th><?php }?><th>View</th></tr>
	  <?php 
	 /* foreach ($model as $att) {
		//$unit = unit::findOne($att->unit);
		$division = division::findOne($id);
	  $slno =1;
	  //$emp_list = EmpDetails::find()->where(['status'=>'active'])->all();
	  $emp_list = EmpDetails::find()->where(['division_id' => $division->id, 'status' => 'Active'])
		->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->all();
		 echo '<tr>
		 <td colspan="5">'.$division->division_name.'</td></tr>';
	  foreach($emp_list as $list){
		 echo '<tr>
		 <td>'.$slno.'</td>
		 <td>'.$list->empcode.'</td>
		 <td>'.$list->empname.'</td>
		 <td><a href="index.php?r=project-details/engineer-transfer&id='.$list->id.'">Transfer</a></td>
		 <td><a href="index.php?r=project-details/engineer-view&id='.$list->id.'" class="fa fa-eye"></a></td>
		 </tr>';
		 $slno++;
	  }*/
	  
	  foreach ($unitlist as $att) {
		$unit = unit::findOne($att->unit);
		$Unitgroup = UnitGroup::find()->where(['unit_id' => $att->unit])->all();

		foreach ($Unitgroup as $group) {
			$unit_one = unit::find()->where(['id' => $group->unit_id])->one();

			$div_one = Division::find()->where(['id' => $group->division_id])->one();

			if($ecode ==""){
			$emp_list = EmpDetails::find()->where(['division_id' => $group->division_id, 'unit_id' => $unit->id])
			->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->all();
		}else{

			$emp_list = EmpDetails::find()->where(['division_id' => $group->division_id, 'unit_id' => $unit->id,'empcode'=>$ecode])
			->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->all();

		}
			

		
		foreach($emp_list as $list){
		 echo '<tr>
		 <td>'.$slno.'</td>
		 <td>'.$list->empcode.'</td>
		 <td>'.$list->empname.'</td>';
		if(Yii::$app->user->identity->role=='project admin'){
		 echo '<td><a href="index.php?r=project-details/status-change&id='.$list->id.'">Status</a></td>';
		}
		echo'<td><a href="index.php?r=project-details/engineer-view&id='.$list->id.'" class="fa fa-eye"></a></td>';
		 
		 echo '</tr>';
		 $slno++;
	  }
	
}
}
	  
	  ?>
	  </table>
	  </div>
	  </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-attendance-menu -->

<?php
$script = <<< JS
$(document).ready(function(){
	var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
     if (!confirm('Are you sure you want to delete this item?.')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
	
	$('#submitbutton').click(function(event){
		//var dt = $('#engineerattendance-date').val();
		var ec = $('#empdetails-empcode').val();
		//var pid = $('#engineerattendance-project_id').val();
		//var att = $('#engineerattendance-attendance').val();
		window.location.href ="index.php?r=project-details/mis-view&ec="+ec
	});
	
	$("#export").click(function(){
	$("#tblexp").table2excel({					
					name: "Attendance",
					filename: "attendance",
					fileext: ".xls",					
	});
});
});
JS;
$this->registerJs($script);

   ?>
