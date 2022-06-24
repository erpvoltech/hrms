<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Customer;
use yii\helpers\ArrayHelper;
$customer = ArrayHelper::map(Customer::find()->all(), 'id', 'customer_name');
?>
<div class="emp-salary-update-attendance">

   <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>
   <h5><b>Attendance Sheet Update Emp.:<?=$model->employee->empcode. '--->' .$model->employee->empname?></b></h5>
   
   <?= $form->field($model, 'statutory_rate') ?>
   <?= $form->field($model, 'leavedays') ?>
   <?= $form->field($model, 'lop_days') ?>
   <?= $form->field($model, 'allowance_paid')->label('TES') ?>
   <h5>Earnings</h5>
   <?= $form->field($model, 'over_time') ?>
   <?= $form->field($model, 'holiday_pay') ?>
   <?= $form->field($model, 'arrear') ?>
   <?= $form->field($model, 'special_allowance') ?>
    <h5>Deduction</h5>
   <?= $form->field($model, 'advance') ?>
   <?= $form->field($model, 'mobile') ?>
   <?= $form->field($model, 'loan') ?>
   <?= $form->field($model, 'insurance') ?>
   <?= $form->field($model, 'rent') ?>
   <?= $form->field($model, 'tds') ?>
   <?= $form->field($model, 'lwf') ?>
   <?= $form->field($model, 'others')->label('Other Deduction') ?>
   <?= $form->field($model, 'customer_id')->dropDownList($customer,['prompt' => '']) ?>      
   <?= $form->field($model, 'priority')->dropDownList(['Yes'=>'Yes','No'=>'No'],['prompt' => '']) ?>


   <div class="form-group">
      <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
   </div>
   <?php ActiveForm::end(); ?>

</div><!-- emp-salary-update-attendance -->
