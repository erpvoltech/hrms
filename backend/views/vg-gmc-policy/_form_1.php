<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgGmcPolicy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-gmc-policy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'policy_name')->dropDownList([ 'GMC' => 'GMC', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'insurance_comp_id')->textInput() ?>

    <?= $form->field($model, 'insurance_agents_id')->textInput() ?>

    <?= $form->field($model, 'policy_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_date')->textInput() ?>

    <?= $form->field($model, 'to_date')->textInput() ?>

    <?= $form->field($model, 'premium_paid')->textInput() ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
