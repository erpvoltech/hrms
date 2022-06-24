<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Vgunit;
use yii\helpers\ArrayHelper;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$designation = ArrayHelper::map(Designation::find()->all(), 'id', 'designation');
$unitGroupData = ArrayHelper::map(Vgunit::find()->all(), 'id', 'unit_group');

$model->unit_group=$group;
$model->month=$month;
?>

<div class="salary-search">

   <?php
   $form = ActiveForm::begin([
               'id' => 'form-reload',
               'layout' => 'horizontal',
               'action' => ['reload'],
   ]);
   ?>

  
   <div class="row">
      <div class=" col-lg-4">
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
         ?></div>
      <div class=" col-lg-4">
         <?= $form->field($model, 'unit_group')->dropDownList($unitGroupData, ['prompt' => 'Select...']) ?> </div>
   </div>
   <div class="row">
      <div class=" col-lg-3"></div>
      <div class=" col-lg-2"> <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'reload', 'value' => 'submit']) ?></div>
      <div class="form-group col-lg-2">  <?= Html::submitButton('Reset', ['class' => 'btn btn-default', 'name' => 'reload', 'value' => 'reset']) ?>
      </div>
   </div>
   <?php ActiveForm::end(); ?>
</div>
