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
?>

<div class="emp-details-search">

   <?php
   $form = ActiveForm::begin([
               'action' => ['gratuity'],
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
        ?>
   </div>  
  
      <div class=" col-lg-4">
         <?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...']) ?> </div>
      <div class=" col-lg-4">
		 <?=
	 $form->field($model, 'year') ?>
		 
		 </div>
   </div>
   <div class="row">
      <div class=" col-lg-3"></div>
      <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
      <div class="form-group col-lg-2">  <?= Html::a('Clear', ['gratuity'], ['class' => 'btn btn-xs btn-warning']) ?>
      </div>
   </div>
   <?php ActiveForm::end(); ?>
