<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPoSubSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-po-sub-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'po_id') ?>

    <?= $form->field($model, 'po_item_id') ?>

    <?= $form->field($model, 'po_qty') ?>

    <?= $form->field($model, 'po_rate') ?>

    <?php // echo $form->field($model, 'po_amount') ?>

    <?php // echo $form->field($model, 'po_total_amount') ?>

    <?php // echo $form->field($model, 'po_sgst') ?>

    <?php // echo $form->field($model, 'po_igst') ?>

    <?php // echo $form->field($model, 'po_cgst') ?>

    <?php // echo $form->field($model, 'po_net_amount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
