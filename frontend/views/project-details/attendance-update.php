<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EngineerAttendance;
use common\models\ProjectDetails;
use common\models\EmpDetails;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\EngineerAttendance */
/* @var $form ActiveForm */
$ProjectDetails = ArrayHelper::map(ProjectDetails::find()->all(), 'id', 'project_code');
//print_r($ProjectDetails);
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
label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 500;
}
body{
	margin-top:36px;
}
</style>
<div class="project-details-attendance-update">

    <?php 
	
	$modelEmp = EmpDetails::findOne($model->emp_id);
	$Engg = EngineerAttendance::find()->where(['emp_id'=>$modelEmp->id])->one();

	$form = ActiveForm::begin(); ?>
	
	
	<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4"style="font-weight: 700;">
		
        <?= $modelEmp->empname?>
		<?= $form->field($model, 'emp_id')->hiddenInput(['value' => $modelEmp->id])->label(False);?>
		</div>
		<div class="col-sm-4">
		</div>
		</div>
	<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
	<?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [ 'options' => ['class' => 'form-control','autocomplete'=>'off'],
					//'language' => 'ru',
					
					'dateFormat' => 'yyyy-MM-dd',											
				])?>
	</div>
	<div class="col-sm-4">
	</div>
	</div>
	<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
        <?= $form->field($model, 'project_id')->dropDownList(
        $ProjectDetails,
        ['prompt'=>'']
        )->label(True);?>
		</div>
	<div class="col-sm-4">
	</div>
		</div>
	<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
		<?= $form->field($model, 'attendance')->dropDownList(['Present'=>'Present','Leave'=>'Leave','Absent'=>'Absent','Idle'=>'Idle','Travel'=>'Travel','HO'=>'HO','H'=>'H','WO'=>'WO','FN'=>'FN','AN'=>'AN'],['prompt'=>'Select...'])->label(True);?>
		</div>
	<div class="col-sm-4">
	</div>
		</div>
		<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
		<?= $form->field($model, 'overtime')->textInput(['value'=>$Engg['overtime']])->label(True); ?>
		</div>
	<div class="col-sm-4">
	</div>
		</div>
		<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
		<?= $form->field($model, 'role')->dropDownList(['Senior'=>'Senior','Junior'=>'Junior','Semiskilled'=>'Semiskilled','Unskilled'=>'Unskilled'],['prompt'=>'Select...'])->label(True);?>
		</div>
	<div class="col-sm-4">
	</div>
		</div>
		<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
		<?= $form->field($model, 'special_allowance')->label(True); ?>
		</div>
	<div class="col-sm-4">
	</div>
		</div>
		<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
		<?= $form->field($model, 'advance_amount')->label(True); ?>
		</div>
	<div class="col-sm-4">
	</div>
		</div>
		
		
	
        <div class="form-group" style="margin-left:390px;">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-attendance -->
