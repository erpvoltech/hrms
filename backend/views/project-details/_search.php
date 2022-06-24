<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Unit;
use common\models\Division;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>

<div class="project-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
		'layout' => 'horizontal'
    ]); ?>
	
 
	 <div class="row">
	<div class="col-lg-4">
		<?= $form->field($model, 'project_code') ?>
	</div><div class="col-lg-4">
		<?= $form->field($model, 'location_code') ?>
	</div><div class="col-lg-4">
		<?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...'])  ?>
	 </div></div>
	  <div class="row">
	<div class="col-lg-4">
   <?=$form->field($model, "division_id")->widget(Select2::classname(), [
					'data' => $divData,
					'options' => ['placeholder' => 'Select...'],
					'pluginOptions' => [
						'width' => '200px'
					],
				]);
           ?>	
		   </div><div class="col-lg-4">
	 <?= $form->field($model, 'project_status')->dropDownList([ 'Active' => 'Active', 'Hold' => 'Hold', 'Closed' => 'Closed', ], ['prompt' => '']) ?>
	 </div><div class="col-lg-1">
	  </div><div class="col-lg-3">
	  <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
       <?= Html::a('Clear', ['index'], ['class' => 'btn btn-warning']) ?>
</div></div>
   


    <?php // echo $form->field($model, 'job_details') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'compliance_required') ?>

    <?php // echo $form->field($model, 'consultant') ?>

    <?php // echo $form->field($model, 'consultant_id') ?>

   
    <?php // echo $form->field($model, 'remark') ?>

    <div class="form-group">
       
    </div>

    <?php ActiveForm::end(); ?>

</div>
