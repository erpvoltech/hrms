<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="group-form">
 <?php  $form = ActiveForm::begin([ 'layout' => 'horizontal']);?>
 <div class="row">
	<div class="form-group col-lg-4">
		 <?= $form->field($model, 'unit_group')->textinput() ?>
	</div>
 </div>
 <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2 p-l-20 form-group" style="left:35px;">
            <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
            </div>
         </div>
  <?php ActiveForm::end(); ?>
		 
</div>