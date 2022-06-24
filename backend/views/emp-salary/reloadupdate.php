<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmpDetails;
?>

<div class="emp-salary-reload">

   <?php
   $form = ActiveForm::begin([
               'id' => 'form-reload',
               'layout' => 'horizontal',
               'action' => ['reloadupdate?id='.$id],
   ]);
   ?>
   <div class="row">

      <div class="col-sm-5">
         <?=
         $form->field($model, 'month')->textInput(['value' => $month])->label('leave')
         ?>
      </div>
      <div class="col-sm-5">
         <?= $form->field($model, 'absent')->textInput(['value' => $absent])->label('leave') ?>
      </div>	
   </div>
   <div class="row">	
      <div class="col-sm-5">
         <?= $form->field($model, 'lop')->textInput(['value' => $lop]) ?>
      </div>   
      <div class="col-sm-5">
         <?= $form->field($model, 'allowance_paid')->textInput(['value' => $allowance_paid]) ?>
      </div>  
   </div>

   <div class="row">	
      <div class="col-sm-5">
         <?= $form->field($model, 'statutory_rate')->textInput(['value' => $statutory_rate]) ?>
      </div>  
      <div class="col-sm-5">      
         <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'reloadupdate', 'value' => 'submit']) ?>
         <?= Html::submitButton('Reset', ['class' => 'btn btn-default', 'name' => 'reloadupdate', 'value' => 'reset']) ?>
      </div>
      
   </div>
   <?php ActiveForm::end(); ?>

</div>
