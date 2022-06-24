<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmpStaffPayScale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-staff-pay-scale-form">

  <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
  <div class="row">
    <div class="col-lg-4">   <?= $form->field($model, 'salarystructure')->textInput(['maxlength' => true]) ?>    </div>

    <div class="col-lg-4">   <?= $form->field($model, 'basic')->textInput() ?>    </div>


    <div class="col-lg-4"> <?= $form->field($model, 'dearness_allowance')->textInput() ?></div>
    </div>
  <br>
    <div class="row">
      <div class="col-lg-4">    <?= $form->field($model, 'hra')->textInput() ?></div>
   

      <div class="col-lg-4"> <?= $form->field($model, 'conveyance_allowance')->textInput() ?></div>
    </div>
  <br>
  <div class="row">
    <div class="col-lg-4"> <?= $form->field($model, 'lta')->textInput() ?></div>

    <div class="col-lg-4"> <?= $form->field($model, 'medical')->textInput() ?></div>

   <!--<?= $form->field($model, 'pli')->textInput() ?>

   <?= $form->field($model, 'other_allowance')->textInput(['maxlength' => true]) ?> -->
  </div>
  <br>
   <div class="form-group">
     <div class="col-lg-5"></div>
     <div class="col-lg-4"> <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?></div
   </div>

   <?php ActiveForm::end(); ?>

</div>
