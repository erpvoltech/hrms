<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Vgunit;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$designation = ArrayHelper::map(Designation::find()->all(), 'id', 'designation');
$unitGroupData = ArrayHelper::map(Vgunit::find()->all(), 'id', 'unit_group');
?>

<div class="emp-details-search">

   <?php
   $form = ActiveForm::begin([
               'action' => ['bloodgroup'],
               'method' => 'get',
               'layout' => 'horizontal',
   ]);
   ?>

   <div class="row">
      <div class=" col-lg-4"> <?= $form->field($model, 'empcode') ?></div>
      <div class=" col-lg-4"> <?= $form->field($model, 'empname') ?></div>
  


  
      <div class=" col-lg-4"> 
   <?=
                                $form->field($model, "designation_id")->widget(Select2::classname(), [
                                    'data' => $designation,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]);
                    ?>
   </div>
   </div>
    <div class="row">
      <div class=" col-lg-4"> 
		<?=
			$form->field($model, "department_id")->widget(Select2::classname(), [
				'data' => $deptData,
				'options' => ['placeholder' => 'Select...'],
				'pluginOptions' => [
					'width' => '200px'
				],
			]);
        ?>  </div>
 
   <div class=" col-lg-4">
    <?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...']) ?>
   </div>
   <div class=" col-lg-1"></div>
   <div class=" col-lg-1"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
   <div class=" col-lg-1">  <?= Html::a('Clear', ['bloodgroup'], ['class' => 'btn btn-xs btn-warning']) ?></div> 
   </div>
   <?php ActiveForm::end(); ?>
