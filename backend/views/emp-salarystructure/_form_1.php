<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmpSalarystructure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-salarystructure-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'worklevel')->dropDownList([ 'WL5' => 'WL5', 'WL4C' => 'WL4C', 'WL4B' => 'WL4B', 'WL4A' => 'WL4A', 'WL3B' => 'WL3B', 'WL3A' => 'WL3A', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'grade')->dropDownList([ 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'basic')->textInput() ?>

    <?= $form->field($model, 'hra')->textInput() ?>

    <?= $form->field($model, 'splallowance')->textInput() ?>

    <?= $form->field($model, 'gross')->textInput() ?>

    <?= $form->field($model, 'daperday')->textInput() ?>

    <?= $form->field($model, 'dapermonth')->textInput() ?>

    <?= $form->field($model, 'payableallowance')->textInput() ?>

    <?= $form->field($model, 'netsalary')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
