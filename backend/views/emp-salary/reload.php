<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmpDetails;

$ModelEmp = EmpDetails::find()->where(['id' => $id])->one();
if ($month)
   $model->month = $month;
?>

<div class="emp-salary-reload">

   <?php
   $form = ActiveForm::begin([
               'id' => 'form-reload',
               'layout' => 'horizontal',
               'action' => ['reload'],
   ]);
   ?>
   <div class="row">

      <div class="col-sm-5">
         <?=
         $form->field($model, 'month')->widget(\yii\jui\DatePicker::class, [
             'options' => ['class' => 'form-control'],
              'dateFormat' => 'MM-yyyy',
               'clientOptions' => [
                       'dateFormat' => 'MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
         ])
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
   <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'reload', 'value' => 'submit']) ?>
   <?= Html::submitButton('Reset', ['class' => 'btn btn-default', 'name' => 'reload', 'value' => 'reset']) ?>
      </div>
<?= $form->field($model, 'empid')->hiddenInput(['value' => $id])->label(false) ?>
   </div>
<?php ActiveForm::end(); ?>

</div>
