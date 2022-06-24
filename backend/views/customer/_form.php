<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>
	 <?= $form->field($model, 'type')->dropDownList([ 'Customer' => 'Customer', 'Consultant' => 'Consultant', 'Principal Employer' => 'Principal Employer', ], ['prompt' => '']) ?>
  <br><br>
    <div class="form-group">
      <div class="col-lg-5" > </div>
      <div class="col-lg-4" >   <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

   