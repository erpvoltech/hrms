<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceProperty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-insurance-property-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'property_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insurance_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_value')->textInput() ?>

    <?= $form->field($model, 'sum_insured')->textInput() ?>

    <?= $form->field($model, 'premium_paid')->textInput() ?>

    <?= $form->field($model, 'valid_from')->textInput() ?>

    <?= $form->field($model, 'valid_to')->textInput() ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_division')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'equipment_service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icn_id')->textInput() ?>

    <?= $form->field($model, 'insurance_agent_id')->textInput() ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
