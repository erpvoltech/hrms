<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsurancePolicy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-insurance-policy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'policy_for')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'policy_type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
