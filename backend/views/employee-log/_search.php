<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user') ?>

    <?= $form->field($model, 'updatedate') ?>

    <?= $form->field($model, 'designation_from') ?>

    <?= $form->field($model, 'designation_to') ?>

    <?php // echo $form->field($model, 'attendance_from') ?>

    <?php // echo $form->field($model, 'attendance_to') ?>

    <?php // echo $form->field($model, 'esi_from') ?>

    <?php // echo $form->field($model, 'esi_to') ?>

    <?php // echo $form->field($model, 'pf_from') ?>

    <?php // echo $form->field($model, 'pf_to') ?>

    <?php // echo $form->field($model, 'pf_ restrict_from') ?>

    <?php // echo $form->field($model, 'pf_ restrict_to') ?>

    <?php // echo $form->field($model, 'pli_from') ?>

    <?php // echo $form->field($model, 'pli_to') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
