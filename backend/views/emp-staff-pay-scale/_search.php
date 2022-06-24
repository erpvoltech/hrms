<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmpStaffPayScaleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-staff-pay-scale-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'package_name') ?>

    <?= $form->field($model, 'basic') ?>

    <?= $form->field($model, 'dearness_allowance') ?>

    <?= $form->field($model, 'hra') ?>

    <?php // echo $form->field($model, 'spl_allowance') ?>

    <?php // echo $form->field($model, 'conveyance_allowance') ?>

    <?php // echo $form->field($model, 'lta') ?>

    <?php // echo $form->field($model, 'medical') ?>

    <?php // echo $form->field($model, 'pli') ?>

    <?php  echo $form->field($model, 'other_allowance') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
