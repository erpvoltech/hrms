<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingFacultySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="training-faculty-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'faculty_ecode') ?>

    <?= $form->field($model, 'faculty_name') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'created_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn-sm btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn-sm btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
