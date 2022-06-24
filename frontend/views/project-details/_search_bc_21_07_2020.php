<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Unit;
use common\models\Customer;
use common\models\Division;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\multiselect\MultiSelect;
$custData = ArrayHelper::map(Customer::find()->where(['type'=>'Customer'])->all(), 'id', 'customer_name');
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');

/* @var $this yii\web\View */
/* @var $model app\models\ProjectDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
    height: 31px; 
    width: 100%;
    width: 200px;
}
</style>
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
	</div><!--<div class="col-lg-4">
		<?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...'])  ?>
	 </div>--></div>
	  <div class="row">
	<!--<div class="col-lg-4">
   <?=$form->field($model, "division_id")->widget(Select2::classname(), [
					'data' => $divData,
					'options' => ['placeholder' => 'Select...'],
					'pluginOptions' => [
						'width' => '165px'
					],
				]);
           ?>	
		   </div>--><div class="col-lg-4">
	 <?= $form->field($model, 'project_status')->dropDownList([ 'Active' => 'Active', 'Hold' => 'Hold', 'Closed' => 'Closed', ], ['prompt' => '']) ?>
	 </div>
	 
	  <div class="col-sm-4">
	   <?=$form->field($model, 'state') ?>
	 </div>
	 </div>
	 <div class="row">
	 <div class="col-lg-4">
		<?= $form->field($model, 'principal_employer')->widget(Select2::classname(), [
				'data' => ArrayHelper::map(Customer::find()->where(['type'=>'Customer'])->all(), 'id', 'customer_name'),
				'pluginOptions' => [                    
                    'placeholder' => 'Select...',
                   'width' => '200px',
                ]
				])?>
	</div>
	<div class="col-lg-4">
		 <?= $form->field($model, 'customer_id')->widget(Select2::classname(), [
				'data' => ArrayHelper::map(Customer::find()->where(['type'=>'Customer'])->all(), 'id', 'customer_name'),
				'pluginOptions' => [                    
                    'placeholder' => 'Select...',
                   'width' => '200px',
                ]
				])?>
	</div>
	 </div>
	 
	  <div class="row">
	 <div class="col-sm-1">
	 </div>
	 <div class="col-sm-3">
	 
	  <p style="position:inherit;left:38px"><?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
       <?= Html::a('Clear', ['index'], ['class' => 'btn btn-warning']) ?></p>
	 </div>
	 </div>

    <!--<?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'project_code') ?>

    <?= $form->field($model, 'location_code') ?>

    <?= $form->field($model, 'location') ?>

    <?= $form->field($model, 'zone') ?>-->

    <?php // echo $form->field($model, 'principal_employer') ?>

    <?php // echo $form->field($model, 'employer_contact') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <?php // echo $form->field($model, 'customer_contact') ?>

    <?php // echo $form->field($model, 'job_details') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'compliance_required') ?>

    <?php // echo $form->field($model, 'consultant') ?>

    <?php // echo $form->field($model, 'consultant_id') ?>

    <?php // echo $form->field($model, 'consultant_contact') ?>

    <?php // echo $form->field($model, 'project_status') ?>

    <?php // echo $form->field($model, 'unit_id') ?>

    <?php // echo $form->field($model, 'division_id') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <div class="form-group">
       
    </div>

    <?php ActiveForm::end(); ?>

</div>
