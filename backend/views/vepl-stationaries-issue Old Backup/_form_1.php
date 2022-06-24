<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesIssue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-issue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'issue_date')->textInput() ?>

    <?= $form->field($model, 'issue_item_id')->textInput() ?>

    <?= $form->field($model, 'issued_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'issued_qty')->textInput() ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
