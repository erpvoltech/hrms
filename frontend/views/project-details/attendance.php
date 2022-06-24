<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EngineerAttendance;
use common\models\ProjectDetails;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
ini_set('memory_limit', '-1');
error_reporting(0);
/* @var $this yii\web\View */
/* @var $model common\models\EngineerAttendance */
/* @var $form ActiveForm */
$ProjectDetails = ArrayHelper::map(ProjectDetails::find()->all(), 'id', 'project_code');
$Attendance = EngineerAttendance::find()->all();
$prev = $_GET['att_date'];
$yesterday = date('Y-m-d', strtotime($prev . ' -1 day'));
/*foreach($Attendance as $att){
	
}*/
if ($_GET['att_date']) {
    $date = Yii::$app->formatter->asDate($_GET['att_date'], "dd-MM-yyyy");
}
$date = $_GET['att_date'];
print_r($date);

?>
<style>
.project-details-attendance{
	font-size: 12px;
}
.form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
    height: 28px;
    width: 100%;
    width: 120px;
	font-size: 12px;
    padding: 4px 4px;
}

.form-group {
    margin-bottom: 2px;
}
.sidenav {
  width: 130px;
  position: fixed;
  z-index: 1;
  top: 83px;
  left: 5px;
  background: #fff;
  overflow-x: hidden;
  padding: 8px 0;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 14px;
  color: #2196F3;
  display: block;
}

.sidenav a:hover {
  color: #064579;
}

th, td {
     padding: 0px; 
}

table, tr, th, td {
    border: #fbf9f9 solid 1px;
    border-collapse: collapse;
}

</style>
<!--<input type="hidden" value=<?//=Yii::$app->formatter->asDate($att->date, "dd-MM-yyyy")?> id="dbdate">-->
<div class="project-details-attendance">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
	<div class="col-sm-2">
	<!--<div class="sidenav">
  <a href="index.php?r=site%2Findex">Home</a>
  <a href="index.php?r=project-details%2Fattendance-menu">Main-Menu</a>
  <a href="index.php?r=project-details/attendance-index">Attendance</a>
  <!--<a href="#contact">Contact</a>
  
  
   'clientOptions' =>[               
				   'minDate' => '-2d',
				   'maxDate' => '+0d',
				],
				
</div>-->
	</div>
	<div class="col-sm-10">
	
	<div class="row">
	<table>
	<tr><th style="width:50px">Sl.No</th><th style="width:300px">Employee</th><th>Ecode</th><th>Project Code</th><th>Attendance</th><th>Over Time</th><th>Role</th><th>Spl Allowance</th><th>Advance Amt</th></tr>
	<?php 
	
	$slno = 1;
	foreach($modelemp as $emp){ 	
	//$lastatt = EngineerAttendance::find()->where(['emp_id'=>$emp->id])->orderBy(['id' => SORT_DESC])->one();
   	$yest_att = EngineerAttendance::find()->where(['emp_id'=>$emp->id])->andwhere(['date'=> Yii::$app->formatter->asDate($yesterday, 'yyyy-MM-dd')])->one();
	?>
	<tr>
	<td><?= $slno?></td>
        <td><?= $emp->empname?>
		<?= $form->field($model, 'emp_id[]')->hiddenInput(['value' => $emp->id])->label(False);?> </td>
		<td><?= $emp->empcode?></td>
		
		<td><?php if(array_key_exists($emp->id,$attdets)) { ?>
	<?php 
	$det = explode('|',$attdets[$emp->id]);
	?>
	<?= $form->field($model, 'project_id[]')->dropDownList($ProjectDetails
		,['options' => [ $det[0]=>['Selected'=>'selected']],'prompt'=>''])->label(False); ?>
	<?php }else if(!$attdets){ ?>
    <?= $form->field($model, 'project_id[]')->dropDownList(
        $ProjectDetails,
        ['options' => [ $yest_att['project_id']=>['Selected'=>'selected']],'prompt'=>'']
        )->label(False);?>
	<?php }else{ ?>
	<?= $form->field($model, 'project_id[]')->dropDownList(
        $ProjectDetails,
        ['class'=>'form-control','prompt'=>'']
        )->label(False);?>
	<?php }?>
	</td>
	<td>
	<?php if(array_key_exists($emp->id,$attdets)) { ?>
	<?php 
	$det = explode('|',$attdets[$emp->id]);
	?>
	<?= $form->field($model, 'attendance[]')->dropDownList(['Present'=>'Present','Leave'=>'Leave','Absent'=>'Absent','Idle'=>'Idle','Travel'=>'Travel','HO'=>'HO','H'=>'H','WO'=>'WO','FN'=>'FN','AN'=>'AN'],['options' => [ $det[1]=>['Selected'=>'selected']],'prompt'=>''])->label(False); ?>
	<?php }else if(!$attdets){ ?>
	<?= $form->field($model, 'attendance[]')->dropDownList(['Present'=>'Present','Leave'=>'Leave','Absent'=>'Absent','Idle'=>'Idle','Travel'=>'Travel','HO'=>'HO','H'=>'H','WO'=>'WO','FN'=>'FN','AN'=>'AN'],['options' => [ $yest_att['attendance']=>['Selected'=>'selected']],'prompt'=>''])->label(False); ?>
			
	<?php }else{ ?>
	<?= $form->field($model, 'attendance[]')->dropDownList(['Present'=>'Present','Leave'=>'Leave','Absent'=>'Absent','Idle'=>'Idle','Travel'=>'Travel','HO'=>'HO','H'=>'H','WO'=>'WO','FN'=>'FN','AN'=>'AN'],['prompt'=>''])->label(False);?>
	<?php }?>
	</td>
	<td>
	<?php if(array_key_exists($emp->id,$attdets)) { ?>
	<?php 
	$det = explode('|',$attdets[$emp->id]);
	?>
	<?= $form->field($model, 'overtime[]')->textInput(['value'=>$det[2]])->label(False); ?>
	<?php }else if(!$attdets){ ?>
	<?= $form->field($model, 'overtime[]')->label(False); ?>
	
	
	<?php }else{ ?>
	<?= $form->field($model, 'overtime[]')->label(False); ?>
	<?php }?>
	</td>
	<td>
	<?php if(array_key_exists($emp->id,$attdets)) { ?>
	<?php 
	$det = explode('|',$attdets[$emp->id]);
	?>
	<?= $form->field($model, 'role[]')->dropDownList(['Senior'=>'Senior','Junior'=>'Junior','Semiskilled'=>'Semiskilled','Unskilled'=>'Unskilled'],['options' => [ $det[3]=>['Selected'=>'selected']],'prompt'=>''])->label(False); ?>
	<?php }else if(!$attdets){ ?>
	<?= $form->field($model, 'role[]')->dropDownList(['Senior'=>'Senior','Junior'=>'Junior','Semiskilled'=>'Semiskilled','Unskilled'=>'Unskilled'],['options' => [ $yest_att['role']=>['Selected'=>'selected']],'prompt'=>''])->label(False); ?>
	<?php }else{ ?>
	<?= $form->field($model, 'role[]')->dropDownList(['Senior'=>'Senior','Junior'=>'Junior','Semiskilled'=>'Semiskilled','Unskilled'=>'Unskilled'],['prompt'=>''])->label(False);?>
	<?php }?>
		</td>
		
	<td>
	<?php if(array_key_exists($emp->id,$attdets)) { ?>
	<?php 
	$det = explode('|',$attdets[$emp->id]);
	?>
	<?= $form->field($model, 'special_allowance[]')->textInput(['value'=>$det[4]])->label(False); ?>
	<?php }else if(!$attdets){ ?>
	<?= $form->field($model, 'special_allowance[]')->label(False); ?>
	
	
	<?php }else{ ?>
	<?= $form->field($model, 'special_allowance[]')->label(False); ?>
	<?php }?>
	</td>
	
	<td>
	<?php if(array_key_exists($emp->id,$attdets)) { ?>
	<?php 
	$det = explode('|',$attdets[$emp->id]);
	?>
	<?= $form->field($model, 'advance_amount[]')->textInput(['value'=>$det[5]])->label(False); ?>
	<?php }else if(!$attdets){ ?>
	<?= $form->field($model, 'advance_amount[]')->label(False); ?>
	
	
	<?php }else{ ?>
	<?= $form->field($model, 'advance_amount[]')->label(False); ?>
	<?php }?>
	</td>
	
	
		
		<!--<td>
		<?//= $form->field($model, 'special_allowance[]')->label(False); ?>
		</td>
		<td>
			<?//= $form->field($model, 'advance_amount[]')->label(False); ?>
			</td>-->
	</tr>
	<?php  $slno++; }?>
	</table>
	<?php /*
	,['options' => [$lastatt->attendance => ['Selected'=>true]]]
		<div class="col-sm-3">
		<label > Employee </label>
		</div>
		<div class="col-sm-1">
		<label> Ecode </label>
		</div>
		<div class="col-sm-2">
		<label> Project Code </label>
		</div>
		<div class="col-sm-2">
		<label > Attendance </label>
		</div>	
	</div>
	
	<?php 
	$slno = 1;
	foreach($modelemp as $emp){ ?>
	
	<div class="row">
	<div class="col-sm-3">
		<?= $slno . ". "?>
        <?= $emp->empname?>
		<?= $form->field($model, 'emp_id[]')->hiddenInput(['value' => $emp->id])->label(False);?>
		</div>
	<div class="col-sm-1">
		<?= $emp->empcode?>
		</div>
	
	<div class="col-lg-2">
        <?= $form->field($model, 'project_id[]')->dropDownList(
        $ProjectDetails,
        ['prompt'=>'']
        )->label(False);?>
		</div>
	<div class="col-sm-2">
		<?= $form->field($model, 'attendance[]')->dropDownList(['Present'=>'Present','Leave'=>'Leave','Absent'=>'Absent','Idle'=>'Idle','Travel'=>'Travel','HO'=>'HO','H'=>'H','WO'=>'WO','FN'=>'FN','AN'=>'AN'],['prompt'=>''])->label(False);?>
		</div>
		
		</div>
		
	<?php $slno++; } ?>
*/?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
		</div>
		</div>
		
    <?php ActiveForm::end(); ?>

</div><!-- project-details-attendance -->


<?php
 $script = <<< JS
$(document).ready(function(){
	
	/*$(".btn").click(function(){
		
		var date=$("#engineerattendance-date").val();
		var dbdate=$("#dbdate").val();
		if(date==dbdate){
			alert('Attendance Date Already Exist!.');
			return false;
		}
		
	});*/
	
	$("#engineerattendance-project_id").select2();
 
/*$('#engineerattendance-date').datepicker({
  minDate: 0,
  stepMonths: 0,
  beforeShowDay: function(d) {
    var today = new Date(); //new Date("Mar 15 2016");
	

    if (d.getDay() === 0) {
      return [false];
    } else if ((today.getDay() >= 0 && today.getDay() < 4) && (d.getDate() == today.getDate() + 0 || d.getDate() == today.getDate() + 1 || d.getDate() == today.getDate() + 2)) {
      return [true];
    } else if (today.getDay() == 4 && (d.getDate() == today.getDate() + 0 || d.getDate() == today.getDate() + 1 || d.getDate() == today.getDate() + 2)) {

      return [true];

    } else if (today.getDay() == 5 && (d.getDate() == today.getDate() + 0 || d.getDate() == today.getDate() + 1 || d.getDate() == today.getDate() + 3)) {

      return [true];

    } else if (today.getDay() == 6 && (d.getDate() == today.getDate() + 0 || d.getDate() == today.getDate() + 2 || d.getDate() == today.getDate() + 3)) {

      return [true];

    } else {
      return [false];
    }


  }
});*/
	
});
JS;
$this->registerJs($script);

   ?>
