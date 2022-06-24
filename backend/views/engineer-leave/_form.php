<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="emp-leave-form">

<?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>
   <div class="row">
      <div class="col-lg-6 form-group">    <?= $form->field($model, 'eligible_first_half')->textInput() ?></div>
      <div class="col-lg-6 form-group">   <?= $form->field($model, 'eligible_second_half')->textInput() ?></div>
   </div>
   <div class="row">
      <div class="col-lg-6 form-group"> <?= $form->field($model, 'leave_taken_first_half')->textInput() ?></div>
      <div class="col-lg-6 form-group"> <?= $form->field($model, 'leave_taken_second_half')->textInput() ?></div>
   </div>
   <div class="row">
      <div class="col-lg-6 form-group">  <?= $form->field($model, 'remaining_leave_first_half')->textInput() ?></div>
      <div class="col-lg-6 form-group">   <?= $form->field($model, 'remaining_leave_second_half')->textInput() ?></div>
   </div>

   <br>
   <div class="row">
      <div class="col-lg-2 form-group"></div>
      <div class="col-lg-6 form-group" style="left:35px;">
<?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?>
      </div>
   </div>

<?php ActiveForm::end(); ?>

</div>

