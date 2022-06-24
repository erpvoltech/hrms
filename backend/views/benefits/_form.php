<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpBenefits */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-benefits-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'travelmode_ss')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'travelmode_ts')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lodging_metro')->textInput() ?>

    <?= $form->field($model, 'lodging_nonmetro')->textInput() ?>

    <?= $form->field($model, 'boarding_metro')->textInput() ?>

    <?= $form->field($model, 'boarding_nonmetro')->textInput() ?>

    <?= $form->field($model, 'gpa')->textInput() ?>

    <?= $form->field($model, 'gmc')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
