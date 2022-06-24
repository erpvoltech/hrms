<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesIssueSub */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-issue-sub-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'issue_item_id')->textInput() ?>

    <?= $form->field($model, 'issued_qty')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
