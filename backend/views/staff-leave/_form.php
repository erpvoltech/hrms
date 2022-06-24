<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmpDetails;

$empModel = EmpDetails::find()->where(['id' => $model->empid])->one();

?>

<div class="emp-leave-staff-form">

  <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
        <div class="row">
  <div class="col-lg-4" > <?= $form->field($model, 'eligible_first_quarter')->textInput() ?></div>

  <div class="col-lg-4" >  <?= $form->field($model, 'eligible_second_quarter')->textInput() ?></div>

  <div class="col-lg-4" >  <?= $form->field($model, 'eligible_third_quarter')->textInput() ?></div>
</div>
  <br>
  <div class="row">
     <div class="col-lg-4" >  <?= $form->field($model, 'eligible_fourth_quarter')->textInput() ?></div>

     <div class="col-lg-4" >  <?= $form->field($model, 'leave_taken_first_quarter')->textInput() ?></div>

    <div class="col-lg-4" >   <?= $form->field($model, 'leave_taken_second_quarter')->textInput() ?></div>
  </div>
  <br>
  <div class="row">
    <div class="col-lg-4" >   <?= $form->field($model, 'leave_taken_third_quarter')->textInput() ?></div>

      <div class="col-lg-4" > <?= $form->field($model, 'leave_taken_fourth_quarter')->textInput() ?></div>

      <div class="col-lg-4" > <?= $form->field($model, 'remaining_leave_first_quarter')->textInput() ?></div>
  </div>
  <br>
  <div class="row">
     <div class="col-lg-4" > <?= $form->field($model, 'remaining_leave_second_quarter')->textInput() ?></div>

    <div class="col-lg-4" >  <?= $form->field($model, 'remaining_leave_third_quarter')->textInput() ?></div>

    <div class="col-lg-4" >  <?= $form->field($model, 'remaining_leave_fourth_quarter')->textInput() ?></div>
  </div>
  <br>  <br>
	<div class="row">
	<div class="col-md-5"></div>
    <div class="form-group">
<?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?>
    </div>
	</div>
<?php ActiveForm::end(); ?>

</div>
