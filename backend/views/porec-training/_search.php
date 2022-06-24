<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PorecTrainingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="porec-training-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'training_type') ?>

    <?= $form->field($model, 'division') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'department') ?>
	
    <?= $form->field($model, 'ecode') ?>
    
	
	<?= $form->field($model, 'batch') ?>
	
	

    <?php // echo $form->field($model, 'training_startdate') ?>

    <?php // echo $form->field($model, 'training_enddate') ?>

    <?php // echo $form->field($model, 'trainig_topic') ?>

    <?php // echo $form->field($model, 'batch') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
