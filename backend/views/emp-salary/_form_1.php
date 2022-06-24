<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmpLeaveCounter;

$absent = EmpLeaveCounter::find()->where(['empid' => $model->empid,'month'=>$model->month])->one();

?>
<div class="emp-salary-_form">

   <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
   <div class="row">
      <div class="form-group col-lg-4"> Emp. Code: <?= $model->employee->empcode ?>   </div>
      <div class="form-group col-lg-4"> Name: <?= $model->employee->empname ?>   </div>
      <div class="form-group col-lg-4"> Designation : <?= $model->designations->designation ?>   </div>

   </div>
   <div class="row">
      <div class="form-group col-lg-4"> Unit : <?= $model->units->name ?>   </div>
      <div class="form-group col-lg-4"> Department: <?= $model->department->name ?>   </div>
      <div class="form-group col-lg-4"> Salary Structure : <?= $model->remuneration->salary_structure ?>   </div>

   </div>

   <div class="row">
      <div class="form-group col-lg-4"> Work Level: <?= $model->remuneration->work_level ?>   </div>
      <div class="form-group col-lg-4"> Grade : <?= $model->remuneration->grade ?>   </div>

      <div class="form-group col-lg-4"> Month : <?= $model->month ?>   </div>
   </div>

   <div class="form-group col-lg-4"><?= $form->field($model, 'statutoryrate') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'absent')->textInput(['value'=>$absent->leave_days]) ?> </div><div class="form-group col-lg-4"> 
      <?= $form->field($model, 'forced_lop') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'paidallowance') ?> </div><div class="form-group col-lg-4">    
      <?= $form->field($model, 'basic') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'hra') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'spl_allowance') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'dearness_allowance') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'conveyance_allowance') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'over_time') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'arrear') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'advance_arrear_tes') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'lta_earning') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'medical_earning') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'guaranted_benefit') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'holiday_pay') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'washing_allowance') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'dust_allowance') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'performance_pay') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'other_allowance') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'pf') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'insurance') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'professional_tax') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'esi') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'advance') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'tes') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'mobile') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'loan') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'rent') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'tds') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'lwf') ?></div><div class="form-group col-lg-4">
      <?= $form->field($model, 'other_deduction') ?></div>



   <div class="form-group">
      <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
   </div>
   <?php ActiveForm::end(); ?>

</div><!-- emp-salary-_form -->
