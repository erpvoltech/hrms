<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectSalUpload */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-sal-upload-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'month')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'project_emp_id')->hiddenInput()->label(false) ?>
	<div class="col-md-4">
    <?= $form->field($model, 'wage')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'special_basic')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'hra')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'canteen_allowance')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'transport_allowance')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'washing_allowance')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'other_allowance')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'society')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'income_tax')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'insurance')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'others')->textInput() ?>
	</div> <div class="col-md-4">
    <?= $form->field($model, 'recoveries')->textInput() ?>
	</div> 
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
