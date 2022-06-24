<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgGmcEndorsement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-gmc-endorsement-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gmc_mother_policy_id')->textInput() ?>

    <?= $form->field($model, 'endorsement_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'endorsement_premium_paid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
