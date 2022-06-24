<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsurancePropertySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-insurance-property-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mother_id') ?>

    <?= $form->field($model, 'property_type') ?>

    <?= $form->field($model, 'insurance_no') ?>

    <?= $form->field($model, 'property_name') ?>

    <?php // echo $form->field($model, 'property_no') ?>

    <?php // echo $form->field($model, 'property_value') ?>

    <?php // echo $form->field($model, 'sum_insured') ?>

    <?php // echo $form->field($model, 'premium_paid') ?>

    <?php // echo $form->field($model, 'valid_from') ?>

    <?php // echo $form->field($model, 'valid_to') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'user_division') ?>

    <?php // echo $form->field($model, 'equipment_service') ?>

    <?php // echo $form->field($model, 'icn_id') ?>

    <?php // echo $form->field($model, 'insurance_agent_id') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
