<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmpLeaveCounter;
use app\models\EmpSalarystructure;
error_reporting(0);
$Salarystructure = EmpSalarystructure::find()
                    ->where(['salarystructure' => $model->remuneration->salary_structure])
                    ->one();

$absent = EmpLeaveCounter::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();
$leavedays=$absent->leave_days;
?>
<div class="emp-salary-_form">
<div class="panel panel-default">
      <div class="panel-heading text-center">Update Employee Salary</div>
      <div class="panel-body">
   <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>  
   <?= $form->field($model, 'empid')->hiddenInput(['value' => $model->empid])->label(false) ?>
        <br>
        
         <div class="row">
          <div class="col-lg-2" style="text-align: right;"> <b>Emp. Code: </b> </div>
        <div class="col-lg-2"><?= $model->employee->empcode ?> </div> 
         <div class="col-lg-2" style="text-align: right;"> <b>Name: </b> </div>
       <div class="col-lg-2"> <?= $model->employee->empname ?> </div> 
        <div class="col-lg-2" style="text-align: right;"> <b> Designation :</b> </div>
        <div class="col-lg-2"><?= $model->designations->designation ?> </div> 
         </div>
        <br>
        <div class="row">
          <div class="col-lg-2" style="text-align: right;"> <b>Unit : </b> </div>
         <div class="col-lg-2"><?= $model->units->name ?>  </div>
         <div class="col-lg-2" style="text-align: right;"> <b>Department: </b> </div>
        <div class="col-lg-2"> <?= $model->department->name ?>  </div>
        <div class="col-lg-2" style="text-align: right;"> <b> Salary Structure : </b> </div> 
         <div class="col-lg-2"><?= $model->remuneration->salary_structure ?>  </div>
</div>
        <br> 
       <div class="row">
          <div class="col-lg-2" style="text-align: right;"> <b> Work Level:</b> </div>
       <div class="col-lg-2"> <?= $model->remuneration->work_level ?>  </div>
       <div class="col-lg-2" style="text-align: right;"> <b>   Grade : </b> </div> 
       <div class="col-lg-2"> <?= $model->remuneration->grade ?>  </div> 

      <div class="col-lg-2" style="text-align: right;"> <b>    Month : </b> </div>
       <div class="col-lg-2"> <?= $model->month ?>  </div>
  </div>
        <br>
         <br>
         <div class="row">
   <div class=" col-lg-4">
           <?= $form->field($model, 'statutoryrate') ?></div>
        <div class="col-lg-4">
      <?= $form->field($model, 'absent')->textInput(['value' => $leavedays]) ?> </div>
        <div class=" col-lg-4"> 
      <?= $form->field($model, 'forced_lop') ?></div>
      </div>
           <div class="row">
        <div class=" col-lg-4">
      <?= $form->field($model, 'paidallowance')->label('TES') ?> </div>
        <div class=" col-lg-4"> 
      <?= $form->field($model, 'over_time') ?></div>
        <div class=" col-lg-4">
      <?= $form->field($model, 'arrear') ?></div>
           </div>
           <div class="row">
        <div class=" col-lg-4">     
      <?= $form->field($model, 'holiday_pay') ?></div>
        <div class=" col-lg-4"> 
		<?= $form->field($model, 'spl_allowance')?></div>
        <div class=" col-lg-4">     
      <?= $form->field($model, 'insurance') ?></div>
           </div>
           <div class="row">
        <div class=" col-lg-4"> 
      <?= $form->field($model, 'advance') ?></div>
        <div class=" col-lg-4">    
      <?= $form->field($model, 'mobile') ?></div>
        <div class=" col-lg-4">
      <?= $form->field($model, 'loan') ?></div>
           </div>
           <div class="row">
        <div class=" col-lg-4">
      <?= $form->field($model, 'rent') ?></div>
        <div class="col-lg-4">
      <?= $form->field($model, 'tds') ?></div>
        <div class=" col-lg-4">
      <?= $form->field($model, 'lwf') ?></div>
           </div>
           <div class="row">
        <div class=" col-lg-4">
      <?= $form->field($model, 'other_deduction') ?></div> 
 		<div class=" col-lg-4">
	   <?= $form->field($model, 'caution_deposit') ?>
                </div>
        
   <div class="form-group ">
     <div class=" col-lg-5"> </div>
     <div class="col-lg-2"> <?= Html::submitButton('Submit', ['class' => 'btn-sm btn-success']) ?></div>
   </div>
        
   <?php ActiveForm::end(); ?>

</div>
      </div>
  </div>
