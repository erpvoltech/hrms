<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Unit;
use common\models\Division;
use common\models\ProjectDetails;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\EngineerAttendance;
use common\models\EmpDetails;
use common\models\AttendanceAccessRule;
use common\models\UnitGroup;
use kartik\select2\Select2;
use common\models\EngineerTransfer;
use common\models\EngineertransferProject;
use dosamigos\multiselect\MultiSelect;

error_reporting(0);
$project=$_GET['pro'];


?>

<div class="row">
	
	<div class="col-md-2">
		<?php echo MultiSelect::widget([
    'id'=>"project",
    "options" => ['multiple'=>"multiple"], // for the actual multiselect
    'data' => ['EPF'=>'EPF','ESI'=>'ESI','WC'=>'WC','CLRA(S)'=>'CLRA(S)','CLRA(C)'=>'CLRA(C)','ISMW'=>'ISMW','Factories Act'=>'Factories Act','GPA'=>'GPA','SALARY'=>'SALARY','S&E'=>'S&E'], // data as array
    'value' =>$project, // if preselected
    'name' => 'multti', // name for the form
    "clientOptions" => 
        [
            "includeSelectAllOption" => true,
           // 'numberDisplayed' => 2
        ], 
]);?>
		
		</div>
		
	<div class="col-md-1"> <b><?php echo $project ?></b></div>
		
    <div class="col-md-2"><button class=" btn btn-primary btn-md" id='go'>Go</button></div>
	<div class="col-md-2"><?php echo '<button class="btn btn-success" id="export">Export</button>';?></div>
</div>
<br>

<div class="row" style="overflow-x: auto;">
    <table class="table" id="table2excel" border="2" style="width: 30%;">
	
	
        
		<?php if($project=="EPF" || $project=="ESI" || $project=="SALARY"|| $project=="EPF,ESI"){?>
		<tr>
            <th>Sl No</th>
            <th>Ecode</th>
			<th>Project Name</th>
			</tr>
			<?php 
			$sl=1;
				if($project=="EPF"){
					$compliance_required = ProjectDetails::find()->where(['compliance_required'=>$project,'project_status'=>'Active'])->all();
					
					
					}else if($project=="ESI"){
					$compliance_required = ProjectDetails::find()->where(['compliance_required'=>$project,'project_status'=>'Active'])->all();
					}else if($project=="SALARY"){
					
					$compliance_required = ProjectDetails::find()->where(['compliance_required'=>$project,'project_status'=>'Active'])->all();
					}else{
					$compliance_required = ProjectDetails::find()->where(['compliance_required'=>$project,'project_status'=>'Active'])->all();
					}
				foreach($compliance_required as $compliance){
				$atten = EngineerAttendance::find()->where(['project_id'=>$compliance->id])->one();
				$ecode = EmpDetails::find()->where(['id'=>$atten->emp_id])->one();
				echo '<tr>
				<td>' . $sl . '</td>
				<td>'.$ecode->empcode.'</td>
				<td>'.$compliance->project_name.'</td>
				 </tr>'; 
						$sl++;
						}
				
		}else{ ?>
		<tr>
            <th>Sl No</th>
			<th>Project Code</th>
			</tr>
			<?php
			$sl=1;
			if($project=="WC" || $project=="CLRA(S)" || $project=="CLRA(C)" || $project=="ISMW" || $project=="Factories Act" || $project=="GPA" || $project=="S&E" ){
					$compliance_required = ProjectDetails::find()->where(['compliance_required'=>$project,'project_status'=>'Active'])->all();
					}
				foreach($compliance_required as $compliance){
				//$atten = EngineerAttendance::find()->where(['project_id'=>$compliance->id])->one();
				//$ecode = EmpDetails::find()->where(['id'=>$atten->emp_id])->one();
				echo '<tr>
				<td>' . $sl . '</td>
				<td>'.$compliance->project_code.'</td>
				 </tr>'; 
						$sl++;
						}
			
	} ?>
		
				
				
			
			
			
           
    </table>
</div>

<?php
$script = <<< JS
$(document).ready(function(){	

   var pro =$("#project").val();
   if(pro==""){
  //$("#table2excel").hide();
   }
	$('#go').click(function(event){	  
	
		window.location.href ="index.php?r=project-details/compliance-report&pro="+ $('#project').val()
	
	});
	
});
$("#export").click(function(){
 $("#table2excel").table2excel({					
					name: "Compliance Report",
					filename: "compliance-report",
					fileext: ".xlsx",					
	});
});
JS;
$this->registerJs($script);
?>