<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgGpaPolicyClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-gpa-policy-claim-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?= $form->field($model, 'policy_serial_no') ?>

    <?= $form->field($model, 'contact_person') ?>

    <?= $form->field($model, 'contact_no') ?>

    <?php // echo $form->field($model, 'nature_of_accident') ?>

    <?php // echo $form->field($model, 'injury_detail') ?>

    <?php // echo $form->field($model, 'accident_place_address') ?>

    <?php // echo $form->field($model, 'accident_time') ?>

    <?php // echo $form->field($model, 'accident_notes') ?>

    <?php // echo $form->field($model, 'total_bill_amount') ?>

    <?php // echo $form->field($model, 'claim_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
