<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPoSub */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-po-sub-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'po_id')->textInput() ?>

    <?= $form->field($model, 'po_item_id')->textInput() ?>

    <?= $form->field($model, 'po_qty')->textInput() ?>

    <?= $form->field($model, 'po_rate')->textInput() ?>

    <?= $form->field($model, 'po_amount')->textInput() ?>

    <?= $form->field($model, 'po_total_amount')->textInput() ?>

    <?= $form->field($model, 'po_sgst')->textInput() ?>

    <?= $form->field($model, 'po_igst')->textInput() ?>

    <?= $form->field($model, 'po_cgst')->textInput() ?>

    <?= $form->field($model, 'po_net_amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
