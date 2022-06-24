<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$designation = ArrayHelper::map(Designation::find()->all(), 'id', 'designation');
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
<!--<input type="text" placeholder="&#xF002; Search" style="font-family:Arial, FontAwesome" />-->

<div class="emp-details-search">

   <?php
   $form = ActiveForm::begin([
               'action' => ['empindex'],
               'method' => 'get',
               'layout' => 'horizontal',
   ]);
   ?>
   <div class="row">
      <div class=" col-lg-4"> <?= $form->field($model, 'e_code')->label('ECode') ?></div>  
      <div class=" col-lg-4"> <?= $form->field($model, 'name')->label('Name') ?></div>  
   </div>
   <div class="row">
      <div class=" col-lg-4"> 
   <?=
                                $form->field($model, "designation")->widget(Select2::classname(), [
                                    'data' => $designation,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]);
                    ?>
   </div>  
      <div class=" col-lg-4"> 
   <?=
                                $form->field($model, "department")->widget(Select2::classname(), [
                                    'data' => $deptData,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]);
                    ?>
   </div>  
   </div>
   <div class="row"><div class=" col-lg-4"> 
         <?= $form->field($model, 'unit')->dropDownList($unitData, ['prompt' => 'Select...'])
         ?> </div>
      <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div> 
      <div class="form-group col-lg-2">  <?= Html::a('Clear', ['empindex'], ['class' => 'btn btn-xs btn-warning']) ?>
      </div>

      <?php ActiveForm::end(); ?>

   </div>

