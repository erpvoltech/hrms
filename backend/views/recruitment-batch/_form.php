<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\RecruitmentBatch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recruitment-batch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [    
	 'options' => ['class' => 'form-control'],
		'dateFormat' => 'dd-MM-yyyy',
	]) ?>

    <?= $form->field($model, 'batch_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
