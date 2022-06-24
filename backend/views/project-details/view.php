<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\models\CustomerContact;
use common\models\Customer;
use common\models\ProjectEmp;
use common\models\EmpDetails;

$projectEmp = ProjectEmp::find()->Where(['project_id'=>$_GET['id']])->all();

?>
<div class="project-details-view">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="row">
	<div class="col-md-5"> <h4>Project Details</h4> </div>
	
	<div class="pull-right">
			<?php
			yii\bootstrap\Modal::begin([
				'headerOptions' => ['id' => 'modalHeader'],
				'id' => 'formmodal',
				'size' => 'modal-md',
			]);
			echo "<div id='modalContent'></div>";
			yii\bootstrap\Modal::end();
			?>
			
		
	
			<?php
			yii\bootstrap\Modal::begin([
				'headerOptions' => ['id' => 'Action Header'],
				'id' => 'actionmodel',
				'size' => 'modal-md',
			]);
			echo "<div id='actionContent'></div>";
			yii\bootstrap\Modal::end();
			?>
    <p>
	  <?= Html::a('Add Emp', ['assign-emp', 'id' => $model->id], ['class' => 'btn btn-primary', 'id' => 'AddEmp']) ?>
      <?= Html::a('Template Att', ['template-att', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
      <?= Html::a('Template Sal', ['template-sal', 'id' => $model->id], [ 'class' => 'btn btn-danger'])  ?>
	   <a href="javascript:void(0);" onclick="popup('sal?id=<?=$model->id?>');"class="btn btn-success" > Upload Sal</a>
	   <a href="javascript:void(0);" onclick="popup('att?id=<?=$model->id?>');"class="btn btn-info" > Upload Att</a>
	   <?= Html::a('Sal Generate', ['salary', 'id' => $model->id], [ 'class' => 'btn btn-primary'])  ?>
    </p>
	</div>
	</div>
	
	

	<table>
		<tr>
			<th>Project Code</th> <td><?=$model->project_code?></td> 
			<th>Location Code</th><td><?=$model->location_code?></td> 
			<th>Location </th><td><?=$model->location?></td> 
			<th>State </th><td><?=$model->state?></td>
						
		</tr>	
		<tr>
			<th>Principal Employer</th> <td><?=$model->customer->customer_name?></td> 
			<th>Contact Employer</th><td colspan="5">
				<?php		
				if($model->employer_contact != NULL) {
				$project = CustomerContact::findOne($model->employer_contact);
				echo  $project->contact_person.', Mobile: '.$project->contact_mobile.', Email:'.	$project->contact_email;
				}
				?>
				</td> 
		</tr>	
		<tr>	
			<th>Customer</th> <td><?=$model->customer->customer_name?></td>
			<th>Customer Contact</th><td colspan="5">
				<?php	
				if($model->customer_contact != NULL) {
				$project = CustomerContact::findOne($model->customer_contact);
				echo  $project->contact_person.', Mobile: '.$project->contact_mobile.', Email:'.	$project->contact_email;
				}
				?>
				</td>
		</tr>	
		<tr>
			<th>Consultant</th> <td>
				<?php
				if($model->consultant_id != NULL) {
				$consultant = Customer::findOne($model->consultant_id);
				echo $consultant->customer_name;
				}
				?>				
				</td>
			<th>consultant Contact</th><td colspan="5">
				<?php	
				if($model->consultant_contact != NULL) {
				$project = CustomerContact::findOne($model->consultant_contact);
				echo  $project->contact_person.', Mobile: '.$project->contact_mobile.', Email:'.	$project->contact_email;
				}
				?>
				</td> 
		</tr>	
		<tr>
			
			<th>Compliance Required</th><td><?=$model->compliance_required?></td>
			<th>Unit </th><td></td>
			<th>Division</th><td ></td>
			<th>Project Status</th><td ><?=$model->project_status?></td>
		</tr>	
		<tr>
			<th>Job Details</th><td colspan="7"><?=$model->job_details?></td>
			
		</tr>	
		<tr>
			<th>Remark</th><td colspan="7"><?=$model->remark?></td>
		</tr>	
	</table>  
	
	<h4>Employee Details</h4>	
	<table>
	<tr><th>ECode</th><th>Name</th><th>Designation</th> <th>Month</th> <th>Category</th><th>Action</th> </tr>
	<?php 
	foreach ($projectEmp as $Employee){
		$Emp = EmpDetails::findOne($Employee->emp_id);
		?>
		<tr>
			<td><?=$Emp->empcode?></td><td><?=$Emp->empname?></td><td><?=$Emp->designation->designation?></td> <td><?=$Employee->month?></td><td><?=$Employee->category?></td>
			<td> 
			<?= Html::a('', ['emp-edit', 'id' => $Employee->id], [ 'class' => 'glyphicon glyphicon-pencil'])  ?>	
						
				<?= Html::a('', ['emp-delete', 'id' => $Employee->id], [ 'class' => 'glyphicon glyphicon-trash'])  ?>
				
			</td>
		</tr>
	<?php } ?>
	</table>
</div>

<?php
$script = <<< JS
$('#AddEmp').click(function(e){
    e.preventDefault();
    $('#formmodal').modal('show')
        .find('#modalContent')
        .load($(this).attr('href'));
   return false;
});
JS;
$this->registerJs($script);
?>
<script>
var popup;
popup = (urlval) => {
 LeftPosition = (screen.width) ? (screen.width-700)/2 : 0;
 TopPosition = (screen.height) ? (screen.height-400)/2 : 0;
 settings = 'height=300,width=500,top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,resizable';
 
 var n = urlval.match(/view/);
 var sal = urlval.match(/sal/);
  var d = urlval.match(/emp-delete/);

 if(n == 'view'){
	 window.open(urlval); 
 }else if(sal =='sal'){
	 window.open(urlval,'mypopup',settings);
 } else if(sal =='att'){
	 window.open(urlval,'mypopup',settings);
 } else {
	 window.open(urlval,'mypopup',settings);
 }

}
</script>
