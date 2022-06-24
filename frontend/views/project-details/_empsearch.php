<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$designation = ArrayHelper::map(Designation::find()->all(), 'id', 'designation');
$division = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>

<div class="emp-details-search">

   <?php
   $form = ActiveForm::begin([
               'action' => ['request-engineer'],
               'method' => 'get',
               'layout' => 'horizontal',
   ]);
   ?>

   <div class="row">
      <div class=" col-lg-4"> <?= $form->field($model, 'empcode') ?></div>
      <div class=" col-lg-4"> <?= $form->field($model, 'empname') ?></div>
	  <div class=" col-lg-4"> <?= $form->field($model, 'division_id')->dropDownList($division, ['prompt' => 'Select...'])
   ?></div>
   </div>


   <div class="row">
      <div class=" col-lg-4"> <?= $form->field($model, 'designation_id')->dropDownList($designation, ['prompt' => 'Select...'])
   ?></div>
      <div class=" col-lg-4"> <?= $form->field($model, 'department_id')->dropDownList($deptData, ['prompt' => 'Select...'])
   ?></div>
   <div class=" col-lg-4">
         <?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...']) ?> </div>
   </div>
   
    
        <div class="row">
            <div class=" col-lg-6"></div>
        <div class=" col-lg-1"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-1">  <?= Html::a('Clear', ['request-engineer'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>	  
   <?php ActiveForm::end(); ?>
</div>
<br>

