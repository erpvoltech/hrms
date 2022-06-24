<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesGrnSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-grn-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'grn_date') ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'bill_no') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
